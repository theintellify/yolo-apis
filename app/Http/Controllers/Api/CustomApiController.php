<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\YoloApis;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
class CustomApiController extends Controller
{
    public function createApi(Request $request)
    {
    	$yoloApis = YoloApis::all();

    	return view('Api.create',compact('yoloApis'));
    }

    public function storeCustomApi(Request $request)
    {
    	$requestBody = (array)json_decode($request->request_body);
    	 
    	$data = json_encode($requestBody);
    	 
    	$cognito_user_id       = $request->cognitoid;
    	$api_url         = $request->api_url;
    	$api_type        = $request->api_type;
	    $response        = $this->getResponse($api_url,$api_type,$data,$cognito_user_id);

	    if($response!="")
	    {
	    	$yoloApis = new YoloApis();
		  	$yoloApis->api_type  = $api_type;
		  	$yoloApis->api_url   = $api_url;
		  	$yoloApis->request_body  = $request->request_body;
		    $yoloApis->response_data = $response;
		  	$saveResult = $yoloApis->save();
	    }

	    $yoloApis = YoloApis::orderBy('id','desc')->get();

	    return redirect()->route('createapi');
    	 
    }

    public function getResponse($url,$type,$data,$cognitoId){
	 
		//$data = str_replace('null', '""', $data);//Replace Null value with doublequotes "" 
	
        $uuidSimple = str_replace("-", "", $cognitoId);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv 	    = substr($mdString,16);      
      	
      	
        $encrypt   = openssl_encrypt($data, 'aes-128-cbc', $key,0,$iv);
        	 
       	$jsonBody  = ["headers"=>["x-shyld-app-id"=>base64_encode($cognitoId)],"body"=>$encrypt];

        
       	 
       	$client = new Client(); 
       	//$url ='https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/users';
       	
       	
		if($type=="POST"){
			 
		 	$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
			 
		}
		if($type=="GET"){
		 	$response = $client->get($url);
		}

		 
		
		
    	$result = $response->getBody()->getContents();
    	 
    	return $result;
    	 


       
	}
}
