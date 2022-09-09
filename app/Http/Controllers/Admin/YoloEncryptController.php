<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YoloEncryptController extends Controller
{
    public function index(Request $request)
    {
    	 
    	return view('admin.encryption.encrypt');
    }

    public function executeEncryption(Request $request)
    {
    	$requestBody = (array)json_decode($request->body);
        $body        = json_encode($requestBody); 
        $cognitoID = $request->cognito_id;
        $encrypted_response = $this->getEncrptedBody($cognitoID,$body);
    	return redirect()->back()->with(['encrypted_response'=>$encrypted_response,'request_encrypt_type'=>$request->request_encrypt_type])->withInput($request->all());


    }

    public function executeDecryption(Request $request)
    {
    	$requestBody = $request->decrypt_body;
         
        $cognitoID   = $request->decrypt_cognito_id;
        $decrypted_response = $this->getDecryptBody($cognitoID,$requestBody);
    	return redirect()->back()->with(['decrypted_response'=>$decrypted_response,'request_encrypt_type'=>$request->request_encrypt_type])->withInput($request->all());
    }

    public function getEncrptedBody($cognitoID,$body){
        
        $uuidSimple = str_replace("-", "", $cognitoID);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv         = substr($mdString,16);         
        $encrypt   = openssl_encrypt($body, 'aes-128-cbc', $key,0,$iv);
        $jsonBody  = ["headers"=>["x-shyld-app-id"=>base64_encode($cognitoID)],"body"=>$encrypt];
        return $jsonBody;
    }


    public function getDecryptBody($cognitoID,$body){
        $uuidSimple = str_replace("-", "", $cognitoID);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv         = substr($mdString,16);         
        $decrypt    = openssl_decrypt($body, 'aes-128-cbc', $key,0,$iv);
        return $decrypt;
    }
}
