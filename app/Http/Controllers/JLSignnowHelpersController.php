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
    public function __construct(){
        $this->host = env('SIGNNOW_API_HOST');
        $this->basic_token = env('SIGNNOW_API_BASIC_TOKEN');
        $this->user = env('SIGNNOW_API_USER');
        $this->password = env('SIGNNOW_API_PASSWORD');
        $this->templateId = env('SIGNNOW_API_QUOTE_TEMPLATEID');
        $this->from = env('SIGNNOW_API_FROM_EMAIL');
        $this->subject = env('SIGNNOW_API_EMAIL_SUBJECT');
        $this->auth = new SignNowOAuth($this->host);
    }

   

    public function generateAccessRefreshToken()
    {
        $myAuth = $this->auth->basicAuthorization($this->basic_token);
        $bearerToken = $myAuth->create(
            new TokenRequestPassword($this->user, $this->password)
        );
        $access_token=$bearerToken->getAccessToken();
        $refresh_token=$bearerToken->getRefreshToken();
        $expires_in=$bearerToken->getExpiresIn();
        $response_code=$bearerToken->getCode();
        $response_error=$bearerToken->getError();
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
            $expiry_time = time()+($expires_in - 86400);
            $data=array(
                "access_token"=> $access_token,
                "refresh_token"=> $refresh_token,
            );
            $data=json_encode($data);
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
        return JL_SignnowHelpersModel::select('data','expires_in')->first();          
    }

    public function cleanAccessToken()
    {
        $obj=JL_SignnowHelpersModel::first();
        if($obj){
            $obj->delete(); 
        }
    }

    public function getSignNowAccessToken(){
        try {
            $tokens=$this->getTokensfromDB();
            $token_expires_in = time() - 1;
            if(!empty($tokens->data)){
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
           Log::info("getAccessToken getSignNowAccessToken from DB:");
           Log::info(print_r($tokens->data, 1));
           return $api_access_token;
        }catch (\Throwable $error) {
            Log::info("Signnow API error, for generating Access Token=>".$error->getMessage());
        }
    }

    public function sendSignNowDocumenttoSign(Request $request){
        try{           
            $access_token=$this->getSignNowAccessToken();
            if($access_token==false){
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
            $entityManager=$this->auth->bearerAuthorization($access_token);

            if(empty($request->input('sign_doc_name')) || empty($request->input('send_to_email')) || empty($request->input('fields'))){
                $response = [
                    'status' => false,
                    'msg' => 'Missing Params',
                ];
                return response()->json($response, 500);
            }

            $sign_doc_name = $request->input('sign_doc_name');
            $signerEmail = $request->input('send_to_email');
            $fields = $request->input('fields');
            $new_doc_name=$sign_doc_name."--".date('Y:m:j:h:i');

            //copy the template to generate the new document
            $templateCopy = (new TemplateCopy())
            ->setTemplateId($this->templateId)
            ->setDocumentName($new_doc_name);

            $new_doc_details=$entityManager->create($templateCopy);
            //current sent document ID
            $documentUniqueId=$new_doc_details->getId();
            // echo "<br>The Doc to sign=$documentUniqueId<br>";
            $roleName = 'The_Client';     
            $roleUniqueId=''; 
            $message="CS invited you to sign the quote";
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

            $input_data=$fields;

            $input_data['client_name_salutation']="Dear ".$input_data['client_name'].",";
            
            $prefill_sm = new FillSmartFields($entityManager);
            $fields_sm = [];
            if(count($input_data)>0){
                foreach($input_data as $key => $value){
                    $fields_sm[][$key]=$value;
                }
            }
        
            $smartFields = (new SmartField())->setFields($fields_sm);
            
            //$smartFields->addField('key', 'value');
        
            $prefill_status=$prefill_sm->fill($documentUniqueId, $smartFields);
            
            // Log::info("prefill_status";
            // print_r($prefill_status);
            // print_r($prefill_status->getStatus());

            $to[] = (new Recipient($signerEmail, $roleName, $roleUniqueId))
            ->setSubject($this->subject)
            ->setMessage($message);

            $invite = new Invite($this->from, $to, $cc);

            $res=$entityManager->create($invite, ["documentId" => $documentUniqueId]);            
           if($res->getStatus()=='success'){
                //return the ID, or save data to database                 
                $response = [
                    'documentUniqueId' => $documentUniqueId,
                    'status' => true,
                    'msg' => "The document was send successfully"
                ];
                return response()->json($response, 200);
           }else{
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
                'msg' => 'failed to send the document due to:'.$exception->getMessage()
            ];           
            return response()->json($response, 500);
        }
    }

    public function checkSignNowDocumentStatus(Request $request){
        $access_token=$this->getSignNowAccessToken();
            if($access_token==false){
                $response = [
                    'status' => false,
                    'msg' => 'Unable to Proceed! getting access token failed',
                ];
                return response()->json($response, 500);
            }
        $entityManager=$this->auth->bearerAuthorization($access_token);    
        if(empty($request->input('documentUniqueId'))){
            $response = [
                'status' => false,
                'msg' => 'Missing Params',
            ];
            return response()->json($response, 500);
        }
        $documentUniqueId = $request->input('documentUniqueId');

        $document = new Document($entityManager);  
        $documentEntity = $document->get($documentUniqueId);
       
        Log::info(print_r($documentEntity,1));
        $response = [
            'status' => true,
            'getPageCount' => $documentEntity->getPageCount(),
            'getId' => $documentEntity->getId(),
        ];
        return response()->json($response, 500);

    }
}
