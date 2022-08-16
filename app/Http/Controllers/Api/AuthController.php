<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\YoloApis;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;


class AuthController extends Controller
{
	

	 
	/**
        @OA\Post(
            path="/userservice",
            tags={"Userservice"},
            summary="Endpoint users",
            description="",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function userService(Request $request)
	{	 
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];

       	 
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//Comman function for the Encryption of any request body send in raw accepted as json
	public function createKeys($data,$cognitoId){
	 
		$data = str_replace('null', '""', $data);//Replace Null value with doublequotes "" 
		$uuidSimple = str_replace("-", "", $cognitoId);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv 	    = substr($mdString,16);  
        $encrypt    = openssl_encrypt($data, 'aes-128-cbc', $key,0,$iv);
      	return $encrypt;

	}
	/**
        @OA\Post(
            path="/userprofileservice",
            tags={"UserProfileService"},
            summary="Endpoint users",
            description="Get User profile Information",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function UserProfileService(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/users";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}


	/**
        @OA\Post(
            path="/usersnotification",
            tags={"Users Notification"},
            summary="Endpoint users",
            description="Get User Notification (Retrieve)",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function usersNotification(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
        $data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/users";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	/**
        @OA\Post(
            path="/updateuserfcmtoken",
            tags={"Update User FCM Token"},
            summary="Endpoint users",
            description="Update user FCM token which is used to send message",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function updateUserFcmToken(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
		$cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
        $data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/users";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//insurancetype
	/**
        @OA\Post(
            path="/insurancetype",
            tags={"Insurance Type"},
            summary="Endpoint Insurance-v2",
            description="Get User insurances",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function insuranceType(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}



	/**
        @OA\Post(
            path="/insurancev2",
            tags={"Save User Insurance"},
            summary="Endpoint Insurance-v2",
            description="Save user insurance details",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function insurancev2(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	/**
        @OA\Post(
            path="/saveinsurancev2",
            tags={"Save User Insurance Assets"},
            summary="Endpoint Insurance-v2",
            description="save or update user assets",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function saveInsurancev2(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}
	 
	/**
        @OA\Post(
            path="/saveassetmapping",
            tags={"Save Assets to User Insurance Mapping"},
            summary="Endpoint Insurance-v2",
            description="Save Assets to User Insurance Mapping",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function saveAssetMapping(Request $request)
	{	
		$jsonData        = $request->all();
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		//$cognito_user_id = $request->json('header')['created_by'];
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}
	//Get User Insurances
	/**
        @OA\Post(
            path="/getuserinsurance",
            tags={"Get User Insurances"},
            summary="Endpoint Insurance-v2",
            description="Used to get insuarance details of users",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function getUserInsurance(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	/**
        @OA\Post(
            path="/userinsurancedetail",
            tags={"Get User Insurance Basic Details"},
            summary="Endpoint Insurance-v2",
            description="Get basic details for user added insurances with limit",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function userInsuranceDetail(Request $request)
	{	
		$jsonData        = $request->all();
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		//$cognito_user_id = $request->json('header')['created_by'];
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}


	/**
        @OA\Post(
            path="/admininsurance",
            tags={"Get Admin User Insurances"},
            summary="Endpoint web",
            description="Get Admin User Insurances",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function adminInsurance(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://6tjo95g76k.execute-api.us-west-2.amazonaws.com/dev/web";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	/**
        @OA\Post(
            path="/getuserinsuranceabstract",
            tags={"Get User Insurance Abstract"},
            summary="Endpoint Insurance-v2",
            description="Get User Insurance Abstract",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function userInsuranceAbstract(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	/**
        @OA\Post(
            path="/getuserinsurancecoverages",
            tags={"Get User Insurance Coverages"},
            summary="Endpoint Insurance-v2",
            description="Get User Insurance Coverages",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function getUserInsuranceCoverage(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//Get Asset Vaults
	/**
        @OA\Post(
            path="/getassetvaults",
            tags={"Get Asset Vaults"},
            summary="Endpoint asset-vault",
            description="Get Asset Vaults",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function getAssetVaults(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/asset-vault";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//DELETE Asset Vaults
	/**
        @OA\Post(
            path="/deleteassetvaults",
            tags={"Delete Asset Vaults"},
            summary="Endpoint asset-vault",
            description="Delete Asset Vaults",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function deleteAssetVaults(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/asset-vault";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}
	//insertupdateuserinsurancecoverages

	/**
        @OA\Post(
            path="/insert-update-user-insurance-coverages",
            tags={"Insert Update User Insurance Coverages"},
            summary="Endpoint Insurance-v2",
            description="Insert Update User Insurance Coverages",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function insertUpdateUserInsuranceCoverages(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//Update User Insurance Abstract
	/**
        @OA\Post(
            path="/update-user-insurance-abstract",
            tags={"Update User Insurance Abstract"},
            summary="Endpoint Insurance-v2",
            description="Update User Insurance Abstract",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function updateUserInsuranceAbstract(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}
	//insert-user-insurance-abstract
	/**
        @OA\Post(
            path="/insert-user-insurance-abstract",
            tags={"Insert User Insurance Abstract"},
            summary="Endpoint Insurance-v2",
            description="Insert User Insurance Abstract",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function insertUserInsuranceAbstract(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}
	//Update Asset Vaults
	/**
        @OA\Post(
            path="/update-asset-vaults",
            tags={"Update Asset Vaults"},
            summary="Endpoint Insurance-v2",
            description="Update Asset Vaults",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function updateAssetVaults(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//Get Contacts
	/**
        @OA\Post(
            path="/getcontacts",
            tags={"Get Contacts"},
            summary="Endpoint Insurance-v2",
            description="Get Contacts",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function getContacts(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	//Update Contacts
	/**
        @OA\Post(
            path="/updatecontacts",
            tags={"Update Contacts"},
            summary="Endpoint Insurance-v2",
            description="Get Contacts",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function updateContacts(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/Insurance-v2";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}

	/**
        @OA\Post(
            path="/datamanager",
            tags={"Data Manager"},
            summary="Endpoint DataManager",
            description="Data Manager",
            security={{"bearerAuth":{}}},
            @OA\Parameter(
             name="CognitoID",
              in="header",
               description="CognitoID",
                required=true,
            ),
            @OA\Parameter(
             name="URL",
              in="header",
               description="API URL",
                required=true,
            ),
            @OA\RequestBody(
                description = "",
                @OA\JsonContent(
                    type = "object",
                    example = {
                        "_method": "POST"
                    }
                ),
            ),
            @OA\Response(
                response="default",
                description="",
                @OA\MediaType(
                    mediaType="application/json",
                ),
            ),
        )
    **/	
	public function dataManager(Request $request)
	{	
		$jsonData        = $request->all();
		//$cognito_user_id = $request->json('header')['created_by'];
        $cognito_user_id = $request->header('CognitoID');
        $url             = $request->header('url');
		$data 			 = json_encode($jsonData);
 	    $encrypt         = $this->createKeys($data,$cognito_user_id);
 	    $jsonBody        = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito_user_id)],"body"=>$encrypt];
       	//$url      ="https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/DataManager";
		$client   = new Client();
		$response = $client->post($url,
			    ['body' => json_encode($jsonBody)]
			);
    	$result = $response->getBody()->getContents();
	    return response()->json(json_decode($result));			
	}



	


}
