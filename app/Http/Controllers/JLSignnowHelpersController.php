<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SignNow\Api\Action\Data\Document\DownloadType;
use SignNow\Api\Action\OAuth as SignNowOAuth;
use SignNow\Api\Action\Document;
use SignNow\Api\Action\Data\Document\DocumentDownloadLinkParams;
use SignNow\Api\Action\Data\Document\GetDocumentRequestParams;
use SignNow\Api\Entity\Invite\Invite;
use SignNow\Api\Entity\Invite\Recipient;
use SignNow\Api\Action\PrefillTextFields;
use SignNow\Api\Entity\Document\PrefillText\FieldRequest;
use SignNow\Api\Entity\Auth\TokenRequestPassword;
use SignNow\Api\Action\FillSmartFields;
use SignNow\Api\Entity\Document\SmartField\SmartField;
use SignNow\Api\Entity\Template\Copy as TemplateCopy;
use Illuminate\Support\Facades\Log;
use DB;
use GuzzleHttp\Client;
use App\Models\JL_SignnowHelpersModel;
use App\Models\CompanyProfile;
use SignNow\Api\Entity\Document\DownloadLink;
use SignNow\Api\Entity\Document\Download as DocumentDownload;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Carbon;
use GuzzleHttp\Psr7\Stream;

class JLSignnowHelpersController extends Controller
{
    private $host;
    private $basic_token;
    private $user;
    private $password;
    private $manager_expirationdays;
    private $client_expirationdays;
    private $templateId;
    private $auth;
    private $notifications;
    private $from;
    private $subject_client;
    private $subject_manager;
    public $doc_name_pre;
    public function __construct($from_email = '')
    {
        $this->host = env('SIGNNOW_API_HOST');
        $this->basic_token = env('SIGNNOW_API_BASIC_TOKEN');
        $this->user = env('SIGNNOW_API_USER');
        $this->password = env('SIGNNOW_API_PASSWORD');
        $this->manager_expirationdays = env('SIGNNOW_API_MANAGER_EXPIRATIONDAYS');
        $this->client_expirationdays = env('SIGNNOW_API_CLIENT_EXPIRATIONDAYS');
        $this->templateId = env('SIGNNOW_API_QUOTE_TEMPLATEID');
        $this->from = $from_email;
        $this->subject_client = env('SIGNNOW_API_EMAIL_SUBJECT_CLIENT');
        $this->subject_manager = env('SIGNNOW_API_EMAIL_SUBJECT_MANAGER');
        $this->doc_name_pre = env('SIGNNOW_API_DOC_NAME_PRE');
        $this->auth = new SignNowOAuth($this->host);
        //send notification
        $this->notifications = new NotificationController();
    }

    public function generateAccessRefreshToken()
    {
        $myAuth = $this->auth->basicAuthorization($this->basic_token);
        $bearerToken = $myAuth->create(
            new TokenRequestPassword($this->user, $this->password)
        );
        $access_token = $bearerToken->getAccessToken();
        $refresh_token = $bearerToken->getRefreshToken();
        $expires_in = $bearerToken->getExpiresIn();
        $response_code = $bearerToken->getCode();
        $response_error = $bearerToken->getError();
        // Log::info("Refresh Token Response:");
        // Log::info(print_r($access_token, 1));
        // Log::info(print_r($refresh_token, 1));
        // Log::info(print_r($expires_in, 1));

        //vendor\signnow\api-php-sdk\src\Entity\Auth\Token.php
        // Log::info("access_token=$access_token");
        // Log::info("refresh_token=$refresh_token");
        // Log::info("expires_in=$expires_in");
        // Log::info("response_code=$response_code");
        // Log::info("response_error=$response_error");

        if (empty($access_token)) {
            $this->cleanAccessToken();
            return false;
        } else {
            //delete the previous token first
            $this->cleanAccessToken();
            //it should expired one day before the expiry time, which is 30 days for now, so add 86400 seconds
            $expiry_time = time() + ($expires_in - 86400);
            $data = array(
                "access_token" => $access_token,
                "refresh_token" => $refresh_token,
            );
            $data = json_encode($data);
            DB::table('signnow_tokens')->insert([
                'data' => $data,
                'expires_in' => $expiry_time,
            ]);
            //Log::info("New Token generated and saved");
            return true;
        }
    }

    public function getTokensfromDB()
    {
        return JL_SignnowHelpersModel::select('data', 'expires_in')->first();
    }

    public function cleanAccessToken()
    {
        $obj = JL_SignnowHelpersModel::first();
        if ($obj) {
            $obj->delete();
        }
    }

    public function getSignNowAccessToken()
    {
        try {
            $tokens = $this->getTokensfromDB();
            $token_expires_in = time() - 1;
            if (!empty($tokens->data)) {
                $token_expires_in = $tokens->expires_in;
                $settings_data = json_decode($tokens->data);
                $api_access_token = $settings_data->access_token;
            }
            if (empty($tokens->data) || time() > $token_expires_in) {
                if ($this->generateAccessRefreshToken() == true) {
                    //return the token now
                    $tokens = $this->getTokensfromDB();
                    $settings_data = json_decode($tokens->data);
                    return $settings_data->access_token;
                } else {
                    $this->cleanAccessToken();
                    return false;
                }
            }
            // Log::info("getAccessToken getSignNowAccessToken from DB:");
            // Log::info(print_r($tokens->data, 1));
            return $api_access_token;
        } catch (\Throwable $error) {
            Log::info("Signnow API error, for generating Access Token=>" . $error->getMessage());
        }
    }


    public function CreateOrganization($inputs)
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();
            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            $response = $client->post($this->host . '/v2/organizations', [
                'exceptions' => false,
                'http_errors' => false,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => $inputs['organization_name'],
                    //'logo' => $inputs['logo'],

                    // 'phone_number' => $inputs['phone_number'],
                    // 'subscription_id' => $inputs['subscription_id'],
                    // 'subscription_package_id' => $inputs['subscription_package_id'],
                    // 'created' => $inputs['created'],
                    // 'updated' => $inputs['updated'],
                    // 'id' => $inputs['id'],
                    // 'enterprise_id' => $inputs['enterprise_id'],


                    // 'creator_user_id' => $inputs['creator_user_id'],



                    //'country' => $inputs['country'],
                    // 'billing_address' => [
                    //     'street' => $inputs['billing_address.street'],
                    //     'city' => $inputs['billing_address.city'],
                    //     'state' => $inputs['billing_address.state'],
                    //     'zip' => $inputs['billing_address.zip'],
                    // ],
                    // 'billing_info' => [
                    //     'card_number' => $inputs['billing_info.card_number'],
                    //     'expiration_date' => $inputs['billing_info.expiration_date'],
                    //     'cvv' => $inputs['billing_info.cvv'],
                    // ],
                    // 'logo' => $inputs['logo'], // Assuming 'logo' is a base64-encoded image
                    // 'phone_number' => $inputs['phone_number']
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            Log::info(print_r($data, 1));
            $statusCode = $response->getStatusCode();
            if (!empty($data['id'])) {
                return response()->json(['status' => true, 'msg' => 'Organization created successfully', 'id' => $data['id']]);
            } else {
                Log::info('Organization Creation Failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Organization creation failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Create the Organization:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function AssignBrandToDocument($document_id, $brand_id)
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();
            //get the ID from current user profile
            $response = $client->put($this->host . "/v2/documents/$document_id/brand", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'brand_id' => $brand_id
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 201) {
                return response()->json(['status' => true, 'msg' => 'Brand successfully assigned to the document!']);
            } else {
                Log::info('Brand assignment to document failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Brand assignment to document failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to assignment Brand to document:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function getDocumentBranding()
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();

            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;

            //get the ID from current user profile
            $document_id = "b5a096a6c3ed44c481529cefa1cffc3bd497dbcd";
            $response = $client->get($this->host . "/v2/documents/$document_id/brand", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            echo "<pre>";
            print_r($data);
            die;
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to get Brand for the Document:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function getAllBranding()
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();

            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            //get the ID from current user profile
            $response = $client->get($this->host . "/v2/brands", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            foreach ($data['data'] as $index => $brand) {
                if ($brand['owner_type'] == 'user') {
                    // $client->delete($this->host . "/v2/brands/" . $brand['unique_id'], [
                    //     'headers' => [
                    //         'Authorization' => 'Bearer ' . $accessToken,
                    //         'Content-Type' => 'application/json',
                    //         'Accept' => 'application/json',
                    //     ],
                    // ]);
                }
            }
            echo "<pre>";
            print_r($data);
            die;
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to get all brandings list:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function CreateBrandFromTemplate($inputs = array())
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();

            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            // Assuming the JSON file is located in the storage/app directory
            $jsonFilePath = public_path('assets/media/sign_now_default_brand.json');
            $brand_json = json_decode(file_get_contents($jsonFilePath), true);
            // $brand_json['resources']['general']['header']['background'] = "#ff0000";
            // $brand_json['resources']['general']['buttons']['default']['background'] = "#00ff00";
            // $brand_json['resources']['general']['icons']['background'] = "#00ff00";
            $brand_json['resources']['editor']['sender-info']['contact-email'] = $inputs['contact_email'];
            $brand_json['resources']['editor']['accessibility']['visibility'] = false;
            $brand_json['resources']['logo']['url'] = $inputs['logo_url'];
            $brand_json['resources']['email-logo']['url'] = $inputs['logo_url'];
            $brand_json['resources']['email-general']['logo']['position'] = 'middle';
            $brand_json['resources']['email-general']['sender_email'] = $inputs['contact_email'];
            $brand_json['resources']['email-general']['signnow_references'] = false;
            //make the api call to create the brand
            $response = $client->post($this->host . "/v2/brands", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'title' => $inputs['title']
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 201 && !empty($data['data']['id'])) {
                $brand_id = $data['data']['id'];
                $response_general = $client->put($this->host . "/v2/brands/$brand_id/resources/general", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => $brand_json['resources']['general'],
                ]);

                $response_editor = $client->put($this->host . "/v2/brands/$brand_id/resources/editor", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => $brand_json['resources']['editor'],
                ]);


                $response_logo = $client->put($this->host . "/v2/brands/$brand_id/resources/logo", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'url' => $brand_json['resources']['email-logo']['url']
                    ],
                ]);

                $response_email_general = $client->put($this->host . "/v2/brands/$brand_id/resources/email-general", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' =>  $brand_json['resources']['email-general'],
                ]);

                $response_general_statusCode = $response_general->getStatusCode();
                $response_editor_statusCode = $response_editor->getStatusCode();
                $response_logo_statusCode = $response_logo->getStatusCode();
                $response_email_general_statusCode = $response_email_general->getStatusCode();
                if ($response_general_statusCode != 204) {
                    Log::info('response_general signnow brand creation failed=');
                    Log::info(print_r($response_general, 1));
                } else  if ($response_editor_statusCode != 204) {
                    Log::info('response_editor signnow brand creation failed=');
                    Log::info(print_r($response_editor, 1));
                } else  if ($response_logo_statusCode != 204) {
                    Log::info('logo signnow brand creation failed=');
                    Log::info(print_r($response_logo, 1));
                } else  if ($response_email_general_statusCode != 204) {
                    Log::info('email-general signnow brand creation failed=');
                    Log::info(print_r($response_email_general, 1));
                }
                return response()->json(['status' => true, 'msg' => 'Brand Created successfully', 'id' => $data['data']['id']]);
            } else {
                Log::info('Brand Creation Failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Brand Creation failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Edit the Organization:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function EditBrandName($inputs = array())
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();
            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            //make the api call to create the brand
            $response = $client->put($this->host . "/v2/brands/" . $inputs['brand_id'], [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'title' => $inputs['title']
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 204) {
                return response()->json(['status' => true, 'msg' => 'Brand Name Updated successfully']);
            } else {
                Log::info('Brand Name Update Failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Brand Name Update failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Edit the Brand:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function EditBrandEditorInfo($inputs = array())
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();
            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            // Assuming the JSON file is located in the storage/app directory
            $jsonFilePath = public_path('assets/media/sign_now_default_brand.json');
            $brand_json = json_decode(file_get_contents($jsonFilePath), true);
            $brand_json['resources']['editor']['sender-info']['contact-email'] = $inputs['contact_email'];
            $brand_json['resources']['editor']['accessibility']['visibility'] = false;
            $brand_json['resources']['email-general']['logo']['position'] = 'middle';
            $brand_json['resources']['email-general']['sender_email'] = $inputs['contact_email'];
            $brand_json['resources']['email-general']['signnow_references'] = false;
            //make the api call to change the brand logo
            $response_editor = $client->put($this->host . "/v2/brands/" . $inputs['brand_id'] . "/resources/editor", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $brand_json['resources']['editor'],
            ]);

            $response_email_general = $client->put($this->host . "/v2/brands/" . $inputs['brand_id'] . "/resources/email-general", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' =>  $brand_json['resources']['email-general'],
            ]);

            $response_editor_statusCode = $response_editor->getStatusCode();
            $response_email_general_statusCode = $response_email_general->getStatusCode();
            $data_editor = json_decode($response_editor->getBody(), true);
            $data_email_general = json_decode($response_email_general->getBody(), true);

            if ($response_editor_statusCode != 204) {
                Log::info("Brand editor contact email Update failed $response_editor_statusCode");
                Log::info(print_r($data_editor, 1));
                return response()->json(['status' => false, 'msg' => 'Brand editor contact email Update failed']);
            } else if ($response_email_general_statusCode != 204) {
                Log::info("Brand email general Update failed $response_email_general_statusCode");
                Log::info(print_r($data_email_general, 1));
                return response()->json(['status' => false, 'msg' => 'Brand email general Update failed']);
            } else {
                return response()->json(['status' => true, 'msg' => 'Brand editor contact email/email general Updated successfully']);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Edit the Brand editor contact email/email general:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function EditBrandLogo($inputs = array())
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();
            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            //make the api call to change the brand logo
            $response = $client->put($this->host . "/v2/brands/" . $inputs['brand_id'] . "/resources/logo", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'url' => $inputs['logo_url']
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 204) {
                return response()->json(['status' => true, 'msg' => 'Brand Logo Updated successfully']);
            } else {
                Log::info('Brand Logo Update Failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Brand Logo Update failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Edit the Brand Logo:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function EditOrganization($inputs, $organizationId)
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();

            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            //get the ID from current user profile
            $response = $client->put($this->host . "/v2/organizations/$organizationId", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => $inputs['organization_name']
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 204) {
                return response()->json(['status' => true, 'msg' => 'Organization updated successfully']);
            } else {
                Log::info('Organization updation Failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Organization updation failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Edit the Organization:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function uploadOrganizationLogo(&$logo_src, $organizationId, $company_name)
    {   //this method need to be fixed, fix it when going to use it, logo endpoint is not working as expected
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();

            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;


            // Make API request to update organization with the new logo
            $response = $client->put($this->host . '/v2/organizations/' . $organizationId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'multipart/form-data; boundary=' . $logo_src->getBoundary(),
                ],
                'json' => [
                    'name' => $company_name
                ],
            ]);


            //get the ID from current user profile
            $response = $client->post($this->host . "/v2/organizations/$organizationId/logo", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'key' => "my first logo",
                    'type' => "file",
                    'logo' => $logo_src
                ],
            ]);


            $data = json_decode($response->getBody(), true);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 204) {
                return response()->json(['status' => true, 'msg' => 'Organization logo uploaded successfully']);
            } else {
                Log::info('Organization uploading Failed, status code=' . $statusCode);
                Log::info(print_r($data, 1));
                return response()->json(['status' => false, 'msg' => 'Organization uploading failed',]);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Edit the Organization:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function DeleteOrganization($org_id)
    {
        try {
            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);
            $client = new Client();
            // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
            $accessToken = $access_token;
            //get the ID from current user profile 

            try {
                $response = $client->delete($this->host . "/v2/organizations/$org_id", [
                    'exceptions' => false,
                    'http_errors' => false,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'msg' => $e->getMessage()]);
            }
            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody(), true);
            if ($statusCode === 204) {
                // Successful deletion, the organization was deleted
                return response()->json(['status' => true, 'msg' => 'Organization deleted successfully']);
            } elseif ($statusCode === 404) {
                // Organization not found or does not exist
                return response()->json(['status' => false, 'msg' => 'Organization not found or does not exist']);
            } else {
                // Error handling - handle the specific error based on the response data
                return response()->json(['status' => false, 'msg' => $data['error'] ?? 'An error occurred during organization deletion'], $statusCode);
            }
            //Delete the organization
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to Delete the Organization:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function makeUserOrganiationAdmin($organizationId, $userId)
    {
        $access_token = $this->getSignNowAccessToken();
        if ($access_token == false) {
            $response = [
                'status' => false,
                'msg' => 'Unable to Proceed! getting access token failed',
            ];
            return response()->json($response, 500);
        }
        $entityManager = $this->auth->bearerAuthorization($access_token);
        $client = new Client();

        // Replace 'YOUR_ACCESS_TOKEN' with your actual SignNow API access token
        $accessToken = $access_token;

        $response = $client->put($this->host . '/v2/organizations/' . $organizationId . '/users/' . $userId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'role' => 'admin',
                // Add other user-related parameters as needed
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data;
    }

    public function sendSignNowDocumenttoSign(Request $request)
    {
        try {

            if (empty(auth()->user()->companyProfile->signnow_brand_id)) {
                //return error
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! Please update your Company Profile to be able to send Quotations!',
                ];
                return response()->json($response, 500);
            }

            //get the brand details from the User Company Profile
            $brand_id = auth()->user()->companyProfile->signnow_brand_id;

            $access_token = $this->getSignNowAccessToken();
            if ($access_token == false) {
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager = $this->auth->bearerAuthorization($access_token);

            if (empty($request->input('sign_doc_name')) || empty($request->input('manager_email')) || empty($request->input('send_to_email')) || empty($request->input('fields'))) {
                $response = [
                    'status' => false,
                    'msg' => 'Missing Params',
                ];
                return response()->json($response, 500);
            }

            $sign_doc_name = $request->input('sign_doc_name');
            $signerEmail = $request->input('send_to_email');
            $manager_email = $request->input('manager_email');
            $fields = $request->input('fields');
            $new_doc_name = $sign_doc_name . "--" . date('Y:m:j:h:i');

            //copy the template to generate the new document
            $templateCopy = (new TemplateCopy())
                ->setTemplateId($this->templateId)
                ->setDocumentName($new_doc_name);

            $new_doc_details = $entityManager->create($templateCopy);

            //current sent document ID
            $documentUniqueId = $new_doc_details->getId();

            // echo "<br>The Doc to sign=$documentUniqueId<br>";           
            $message = $fields['company_project_manager'] . " from (" . $fields['company_name_address'] . ")" . " invited you to sign the Quotation";
            $message_header = "Please review and sign!";
            $message_manager = "Please upload the system generated Quote and sign the document so that " . $fields['client_name_company_name'] . " may can review and sign the Quotation";
            $message_header_manager = "Please Upload the required documents to initiate the quotation signing process for " . $fields['client_name_company_name'] . ".";
            $cc = [];

            $input_data = $fields;

            $input_data['client_name_salutation'] = $input_data['client_name'] . ",";

            $prefill_sm = new FillSmartFields($entityManager);
            $fields_sm = [];
            if (count($input_data) > 0) {
                foreach ($input_data as $key => $value) {
                    $fields_sm[][$key] = $value;
                }
            }

            $smartFields = (new SmartField())->setFields($fields_sm);

            //$smartFields->addField('key', 'value');

            $prefill_status = $prefill_sm->fill($documentUniqueId, $smartFields);

            // Log::info("prefill_status";
            // print_r($prefill_status);
            // print_r($prefill_status->getStatus());


            //send the invite to the project manager
            $company_roleName = "Company_Manager";
            $to[] = (new Recipient($manager_email, $company_roleName, "", 1, $this->manager_expirationdays))
                ->setSubject($this->subject_manager)
                ->setMessage($message_manager);

            //send invite to the cotractor
            $roleName = 'The_Client';
            $roleUniqueId = '';
            $to[] = (new Recipient($signerEmail, $roleName, $roleUniqueId, 2, $this->client_expirationdays))
                ->setSubject($this->subject_client)
                ->setMessage($message);

            $invite = new Invite($this->from, $to, $cc);

            $res = $entityManager->create($invite, ["documentId" => $documentUniqueId]);
            if ($res->getStatus() == 'success') {

                //assign brand to the document to apply the custom look and feel
                $assigned_response = $this->AssignBrandToDocument($documentUniqueId, $brand_id);
                if ($assigned_response->getData()->status == false) {
                    Log::info("Unabel to Assign a Brand to a Document");
                    Log::info(print_r($assigned_response, 1));
                }

                //return the ID, or save data to database                 
                $response = [
                    'documentUniqueId' => $documentUniqueId,
                    'status' => true,
                    'msg' => "The document was sent successfully"
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'msg' => 'failed to send the document'
                ];
                Log::info("ERROR [SignNow API]: ");
                Log::info(print_r($res, true));
                return response()->json($response, 500);
            }
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API]: ");
            Log::info(print_r($exception->getMessage(), true));
            $response = [
                'status' => false,
                'msg' => 'failed to send the document due to:' . $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function checkSignNowDocumentStatus(Request $request)
    {
        $access_token = $this->getSignNowAccessToken();
        if ($access_token == false) {
            $response = [
                'status' => false,
                'msg' => 'Unable to Proceed! getting access token failed',
            ];
            return response()->json($response, 500);
        }
        $entityManager = $this->auth->bearerAuthorization($access_token);
        if (empty($request->input('documentUniqueId'))) {
            $response = [
                'request_status' => false,
                'msg' => 'Missing Params',
            ];
            return response()->json($response, 500);
        }
        $documentUniqueId = $request->input('documentUniqueId');

        $document = new Document($entityManager);
        $documentEntity = $document->get($documentUniqueId);
        //to check if the signer has signed the document
        $signature_details = $documentEntity->getSignatures();
        $fieldinvites_details = $documentEntity->getFieldInvites();
        //Log::info(print_r($documentEntity,1));
        //Log::info(print_r($fieldinvites_details,1));
        Log::info(print_r($signature_details, 1));
        $response = [
            'request_status' => true,
            'getPageCount' => $documentEntity->getPageCount(),
            'getId' => $documentEntity->getId(),
            'manager_signed' => !empty($signature_details[0]['data']) ? true : false,
            'manager_signed_details' => !empty($signature_details[0]['data']) ? $signature_details[0] : array(),
            'manager_email_status' => !empty($fieldinvites_details[0]['email_statuses'][0]) ? end($fieldinvites_details[0]['email_statuses']) : array(),
        ];

        if ($response['manager_signed'] == true) {
            $response['client_signed'] = !empty($signature_details[1]['data']) ? true : false;
            $response['client_signed_details'] = !empty($signature_details[1]['data']) ? $signature_details[1] : array();
            $response['client_declined'] = !empty($fieldinvites_details[1]['declined'][0]) ? true : false;
            $response['client_declined_reason'] = !empty($fieldinvites_details[1]['declined'][0]) ? end($fieldinvites_details[1]['declined'])['declined_text'] : array();
            $response['client_declined_details'] = !empty($fieldinvites_details[1]['declined'][0]) ? $fieldinvites_details[1]['declined'] : array();
        }

        // echo "<pre>";
        // print_r($fieldinvites_details);
        // echo "</pre><br><br>";
        return response()->json($response, 200);
    }

    public function checkstatusSampleCalls()
    {
        $from_company_email = "testmanager33@mailinator.com";
        $cont = new JLSignnowHelpersController($from_company_email);
        $request_data = array(
            'documentUniqueId' => '7480adb7a5d048c68a0793ea6fe145b2c001b148',
            //52bc970050944bf5a5c767ea32e6b14c6e394441    rejected
            //7b896909e3d24d649077136a1c39c304dbded16b    declined       
            //22e7c479de5b44d59757df2284d77e43edc70f47    both signed    
        );
        $myRequest = new \Illuminate\Http\Request();
        $myRequest->setMethod('POST');
        $myRequest->merge($request_data);
        $doc_status_response = $cont->checkSignNowDocumentStatus($myRequest);
        $response_data = $doc_status_response->getData();
        //manager not signed
        if ($doc_status_response->getData()->manager_signed == 0) {
            echo "The manager has to upload the quote and sign the document";
        } else if ($doc_status_response->getData()->manager_signed == 1) {
            if (isset($doc_status_response->getData()->client_declined) && $doc_status_response->getData()->client_declined == 1 && $doc_status_response->getData()->client_signed == 0) {
                echo "The Document was signed by the manager and declined by the client, REASON:" . $response_data->client_declined_reason;
            } else if ($doc_status_response->getData()->client_signed == 1) {
                echo "The manager and client has signed the document";
            } else  if ($doc_status_response->getData()->client_signed == 0) {
                echo "The manager has signed the document and uploaded the quote, and the client has to sign it.";
            }
        }
    }

    public function handleWebhook(Request $request)
    {

        try {

            // //validate the request first
            // $signnow_signature = $request->header('x-signnow-signature');
            // $signnow_hmac_signature = env('SIGNNOW_API_HMAC_SIGNATURE');
            // $secret = $this->getSignNowAccessToken(); //env('SIGNNOW_API_BASIC_TOKEN');
            // if ($this->HashIsValid($secret, $signnow_signature, $signnow_hmac_signature)) {
            //     return response()->json('Valid Hash', 200);
            // } else {
            //     return response()->json('Wrong Hash', 200);
            // }


            //Log::info(print_r($request->all(), 1));
            //Log::info("Web Hook headers");
            //Log::info(print_r($request->headers->all(), 1));
            Log::info("Web Hook meta");
            Log::info(print_r($request->input('meta'), 1));
            Log::info("Web Hook content");
            Log::info(print_r($request->input('content'), 1));

            $meta = $request->input('meta');
            $content = $request->input('content');

            Log::info(print_r($meta['event'], 1));

            if ($meta['event'] == 'user.document.fieldinvite.signed') {
                $document_id = $content['document_id'];
                $signer_email = $content['signer'];
                $status = $content['status'];
                $quote_data = Quotation::where('signnow_document_id', '=', $document_id)->select('id', 'created_by', 'status')->first();
                //check if the process was completed by the Manager or client
                //$the_signer = User::where('email', '=', $signer_email)->select('id')->first();
                if ($quote_data['status'] == 0 || $quote_data['status'] == 3) {
                    //if signer is manager
                    //signature is pending by client
                    $updated_data = array(
                        'status' => 2,
                        'status_update_at' =>  Carbon::now()->toDateTimeString(),
                    );
                    $notification_message = "The Quotation was signed by the Manager";
                } else {
                    //if signer is a client
                    //signed successfully
                    $updated_data = array(
                        'status' => 1,
                        'status_update_at' =>  Carbon::now()->toDateTimeString(),
                    );
                    $notification_message = "The Quotation was completely Signed";
                }
                $quot_obj = Quotation::find($quote_data['id']);
                $quot_obj->update($updated_data);
                $this->notifications->sendMoudleNotification(1, $quote_data['created_by'], date('Y-m-d'), 'quotation', $quote_data['id'], "", "", "", $document_id, $notification_message, "", 200, 'signed');
            } else if ($meta['event'] == 'user.document.fieldinvite.decline') {
                //cancel the invite, and add the status update
                $document_id = $content['document_id'];
                $signer_email = $content['signer'];
                $status = $content['status'];
                $quote_data = Quotation::where('signnow_document_id', '=', $document_id)->select('id', 'created_by', 'status')->first();
                //check if declined by the Manager or client
                //$the_signer = User::where('email', '=', $signer_email)->select('id')->first();

                if ($quote_data['status'] == 0) {
                    //if signer is manager
                    //declined by manager
                    $updated_data = array(
                        'status' => 3,
                        'status_update_at' =>  Carbon::now()->toDateTimeString(),
                    );
                    $notification_message = "The Quotation was declined by the Manager";
                } else {
                    //if signer is a client
                    //declined by client
                    $updated_data = array(
                        'status' => 5,
                        'status_update_at' =>  Carbon::now()->toDateTimeString(),
                    );
                    $notification_message = "The Quotation was declined by the Client";
                    //cancel the invite if declined by the client
                }
                $quot_obj = Quotation::find($quote_data['id']);
                $quot_obj->update($updated_data);
                $this->notifications->sendMoudleNotification(1, $quote_data['created_by'], date('Y-m-d'), 'quotation', $quote_data['id'], "", "", "", $document_id, $notification_message, "", 500, 'declined');
            } else if ($meta['event'] == 'user.invite.expired') {
                //cancel the invite, and add the status update
                $document_id = $content['document_id'];
                $signer_email = $content['signer'];
                $status = $content['status'];
                $quote_data = Quotation::where('signnow_document_id', '=', $document_id)->select('id', 'created_by', 'status')->first();
                //check if declined by the Manager or client
                //$the_signer = User::where('email', '=', $signer_email)->select('id')->first();
                if ($quote_data['status'] == 0) {
                    //if signer is manager
                    //missed by manager
                    $updated_data = array(
                        'status' => 4,
                        'status_update_at' =>  Carbon::now()->toDateTimeString(),
                    );
                    $notification_message = "The Quotation got Expired before the Manager Signature";
                } else {
                    //if signer is a client
                    //missed by client
                    $updated_data = array(
                        'status' => 6,
                        'status_update_at' =>  Carbon::now()->toDateTimeString(),
                    );
                    $notification_message = "The Quotation got Expired before the Client Signature";
                }
                $quot_obj = Quotation::find($quote_data['id']);
                $quot_obj->update($updated_data);
                //send system notification to Manager
                $this->notifications->sendMoudleNotification(1, $quote_data['created_by'], date('Y-m-d'), 'quotation', $quote_data['id'], "", "", "", $document_id, $notification_message, "", 300, 'expired');
            }
            return response()->json('response from wequote', 200);
        } catch (Throwable $exception) {
            Log::info("ERROR [SignNow API Hook Error]: ");
            Log::info(print_r($exception->getMessage(), true));
            return response()->json('Exception Occured', 500);
        }
    }

    protected static function ComputeHash($secret, $payload)
    {
        $hexHash = hash_hmac('sha256', $payload, utf8_encode($secret));
        $base64Hash = base64_encode(hex2bin($hexHash));
        return $base64Hash;
    }
    protected static function HashIsValid($secret, $payload, $verify)
    {
        return hash_equals($verify, self::ComputeHash($secret, $payload));
    }

    public function previewDoc($documentUniqueId)
    {
        if (empty($documentUniqueId))
            abort(404, 'No Document');
        $quote_data = Quotation::join('projects', 'projects.id', '=', 'quotations.project_id')
            ->where("signnow_document_id", "=", $documentUniqueId)->select('projects.name AS project_name', 'quotations.created_by')->first();

        if ($quote_data->created_by != Auth::user()->id) {
            abort(403, 'No Access to the Document');
        }

        $access_token = $this->getSignNowAccessToken();
        if ($access_token == false) {
            return "";
        }
        $entityManager = $this->auth->bearerAuthorization($access_token);

        $fileName = $this->doc_name_pre . $quote_data->project_name . '.zip';
        $mime_type = "application/zip";
        //to download with all histroy
        //$expectedContent = $entityManager->get(new DocumentDownload(), ['id' => $documentUniqueId], ['type' => 'zip', 'with_history' => 1,'attachments' => 1]);
        $expectedContent = $entityManager->get(new DocumentDownload(), ['id' => $documentUniqueId], ['type' => 'zip', 'attachments' => 1]);
        $zip_cont = $expectedContent->getContent();
        return response()->stream(function () use ($zip_cont, $mime_type, $fileName) {
            $file = fopen('php://output', 'w');
            fwrite($file, $zip_cont);
            fclose($file);
        }, 200, [
            'Content-Type' => $mime_type,
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
            'Expires' => '0',
            'Pragma' => 'public',
        ], 'attachment');



        //Redirect to the download link, no attachments are included, only the main signed document
        //$link = $entityManager->create(new DocumentDownloadLinkParams(), ['id' => $documentUniqueId], ['type' => 'zip', 'with_history' => 1, 'attachments' => 1]);
        //$link= $link->getLink();
        //return Redirect::intended($link);

        //get a link to be used all the time
        //$document = $entityManager->get(new DocumentDownload(), ['id' => $documentUniqueId], ['type' => 'zip', 'with_history' => 1]);

        //download by SuiteCRM Approach
        /*
        ini_set(
            'zlib.output_compression',
            'Off'
        );
        header('Content-Disposition: attachment; filename="' . $fileName . '";');
        // disable content type sniffing in MSIE
        header("X-Content-Type-Options: nosniff");
        //header("Content-Length: " . filesize($local_location));
        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
        set_time_limit(0);
        // When output_buffering = On, ob_get_level() may return 1 even if ob_end_clean() returns false
        // This happens on some QA stacks. See Bug#64860
        while (ob_get_level() && @ob_end_clean()) {;
        }
        ob_start();
        ob_end_clean();
        echo $entityManager->get(new DocumentDownload(), ['id' => $documentUniqueId], ['type' => 'zip', 'with_history' => 1]);
        die;
        */



        //download by Laravel Approach
        /*
        $headers = [
            'Content-Type' => 'application/octet-stream',
            //'Content-Length' => $validated['size'],
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename=test.zip',
        ];
        return response()->streamDownload(function ($link) {
            echo $link->getContent();
        }, $fileName);
        return response()->streamDownload(function () use (&$link) {
            echo $link;
        }, $fileName, [
            "Content-type" => "application/octet-stream",
            "Content-Disposition" => "attachment; filename=" . $fileName, ";",
        ]);
        return response()->streamDownload(function () use ($link) {
            // @codeCoverageIgnoreStart
            fpassthru($link);
            fclose($link);
            // @codeCoverageIgnoreEnd
        }, 'test.zip');
        return response()->download($link, 'document.zip', array('Content-Type: application/zip'));
        */
    }
}
