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
use App\Models\JL_SignnowHelpersModel;
use SignNow\Api\Entity\Document\DownloadLink;
use SignNow\Api\Entity\Document\Download as DocumentDownload;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class JLSignnowHelpersController extends Controller
{
    private $host;
    private $basic_token;
    private $user;
    private $password;
    private $templateId;
    private $auth;
    private $from;
    private $subject;
    public $doc_name_pre;
    public function __construct($from_email = '')
    {
        $this->host = env('SIGNNOW_API_HOST');
        $this->basic_token = env('SIGNNOW_API_BASIC_TOKEN');
        $this->user = env('SIGNNOW_API_USER');
        $this->password = env('SIGNNOW_API_PASSWORD');
        $this->templateId = env('SIGNNOW_API_QUOTE_TEMPLATEID');
        $this->from = $from_email;
        $this->subject = env('SIGNNOW_API_EMAIL_SUBJECT');
        $this->doc_name_pre = env('SIGNNOW_API_DOC_NAME_PRE');
        $this->auth = new SignNowOAuth($this->host);
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
        Log::info("Refresh Token Response:");
        Log::info(print_r($access_token, 1));
        Log::info(print_r($refresh_token, 1));
        Log::info(print_r($expires_in, 1));

        //vendor\signnow\api-php-sdk\src\Entity\Auth\Token.php
        Log::info("access_token=$access_token");
        Log::info("refresh_token=$refresh_token");
        Log::info("expires_in=$expires_in");
        Log::info("response_code=$response_code");
        Log::info("response_error=$response_error");

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
            Log::info("New Token generated and saved");
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



    public function sendSignNowDocumenttoSign(Request $request)
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

            if (empty($request->input('sign_doc_name')) || empty($request->input('send_to_email')) || empty($request->input('fields'))) {
                $response = [
                    'status' => false,
                    'msg' => 'Missing Params',
                ];
                return response()->json($response, 500);
            }

            $sign_doc_name = $request->input('sign_doc_name');
            $signerEmail = $request->input('send_to_email');
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
            $message = "CS invited you to sign the quote";
            $cc = [];


            // $input_data=array(
            //     "company_name"=> "Quote Estimator Company",
            //     "company_street_address"=> "Street Number 1",
            //     "company_city_state_zip"=> "New York, NY, 61255524",
            //     "company_phone"=> "+12525252525",
            //     "company_email"=> "contractor@gmail.com",
            //     "client_name"=> "Mr Ali",
            //     "client_company_name"=> "Automatve",
            //     "client_street_address"=> "Street Number 2",
            //     "client_city_state_zip"=> "Viana, VN, A8569",
            // );

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
            $to[] = (new Recipient($this->from, $company_roleName, "", 1))
                ->setSubject($this->subject)
                ->setMessage($message);

            //send invite to the cotractor
            $roleName = 'The_Client';
            $roleUniqueId = '';
            $to[] = (new Recipient($signerEmail, $roleName, $roleUniqueId, 2))
                ->setSubject($this->subject)
                ->setMessage($message);

            $invite = new Invite($this->from, $to, $cc);

            $res = $entityManager->create($invite, ["documentId" => $documentUniqueId]);
            if ($res->getStatus() == 'success') {
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
                if ($quote_data['status'] == 'Pending_Manager_Signature' || $quote_data['status'] == 'Declined_by_Manager') {
                    //if signer is manager
                    $updated_data = array(
                        'status' => 'Signed_by_Manager_Pending_By_Client',
                    );
                } else {
                    //if signer is a client
                    $updated_data = array(
                        'status' => 'Signed_Successfully_And_closed',
                    );
                }
                $quot_obj = Quotation::find($quote_data['id']);
                $quot_obj->update($updated_data);
            } else if ($meta['event'] == 'user.document.fieldinvite.decline') {
                //cancel the invite, and add the status update
                $document_id = $content['document_id'];
                $signer_email = $content['signer'];
                $status = $content['status'];
                $quote_data = Quotation::where('signnow_document_id', '=', $document_id)->select('id', 'created_by', 'status')->first();
                //check if declined by the Manager or client
                //$the_signer = User::where('email', '=', $signer_email)->select('id')->first();

                if ($quote_data['status'] == 'Pending_Manager_Signature') {
                    //if signer is manager
                    $updated_data = array(
                        'status' => 'Declined_by_Manager',
                    );
                } else {
                    //if signer is a client
                    $updated_data = array(
                        'status' => 'Declined_by_Client',
                    );
                    //cancel the invite if declined by the client
                }
                $quot_obj = Quotation::find($quote_data['id']);
                $quot_obj->update($updated_data);
            }
            // $signnow_signature = $request->header('x-signnow-signature');
            // Log::info("signnow_signature=" . $signnow_signature);
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
