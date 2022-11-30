<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyYoloApiRequest;
use App\Http\Requests\StoreYoloApiRequest;
use App\Http\Requests\UpdateYoloApiRequest;
use App\Models\Enviroment;
use App\Models\YoloApi;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
class YoloApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('yolo_api_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        if($request->archive==1){

            $yoloApis = YoloApi::with(['enviroment'])->where('api_status','=','1')->get();    
        } else {
            $yoloApis = YoloApi::with(['enviroment'])->get();
        }
        
 
        return view('admin.yoloApis.index', compact('yoloApis'));
    }

    public function create()
    {
        abort_if(Gate::denies('yolo_api_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enviroments = Enviroment::pluck('enviroment', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.yoloApis.create', compact('enviroments'));
    }

    public function store(StoreYoloApiRequest $request)
    {

        //$yoloApi = YoloApi::create($request->all());
        $url = $request->url.''.$request->endpoint;
        
        $requestBody = (array)json_decode($request->request_body);
         
        $data = json_encode($requestBody);
        $response = '';  
        $cognito_user_id  = $request->cognito;
        $messageName = $requestBody['header']->message_name;
        if($request->api_type==1){
            $api_type        = 'GET';    
        } 
        if($request->api_type==2){
            $api_type        = 'POST';    
        } 
        
 
        $response        = $this->getResponse($url,$api_type,$data,$cognito_user_id);
        $responseData    =  (array) json_decode($response);

        $decryptedBody = $this->decryptData($url,$api_type,$responseData['body'],$cognito_user_id); 
        
        if($response!="")
        {
            $yoloApis = new YoloApi();
            $yoloApis->api_name       = $request->api_name;
            $yoloApis->enviroment_id  = $request->enviroment_id;
            $yoloApis->api_type       = $request->api_type;
            $yoloApis->url            = $request->url;
            $yoloApis->message_name   = $messageName;
            $yoloApis->endpoint       = $request->endpoint;
            $yoloApis->endpoint       = $request->endpoint;
            $yoloApis->cognito        = $request->cognito;
            $yoloApis->request_body   = $request->request_body;
            $yoloApis->response_data  = $response;
            $yoloApis->decrypted_body = $decryptedBody;
            $yoloApis->api_status     = $request->api_status;
            $yoloApis->api_version    = $request->api_version;
            $yoloApis->decrypted_body = $decryptedBody;
            $saveResult = $yoloApis->save();

            return redirect()->route('admin.yolo-apis.index');
        } else {
         

            return redirect()->route('admin.yolo-apis.index');
        }
    }

    public function edit(YoloApi $yoloApi)
    {
        abort_if(Gate::denies('yolo_api_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enviroments = Enviroment::pluck('enviroment', 'id')->prepend(trans('global.pleaseSelect'), '');

        $yoloApi->load('enviroment');

        return view('admin.yoloApis.edit', compact('enviroments', 'yoloApi'));
    }

    public function update(UpdateYoloApiRequest $request, YoloApi $yoloApi)
    {
        
       
        $url = $request->url.''.$request->endpoint;
        
        $requestBody = (array)json_decode($request->request_body);
         
        $data = json_encode($requestBody);
        $messageName = $requestBody['header']->message_name;

        $response = '';  
        $cognito_user_id       = $request->cognito;
        
        if($request->api_type==1){
            $api_type        = 'GET';    
        } 
        if($request->api_type==2){
            $api_type        = 'POST';    
        } 
        
        $response        = $this->getResponse($url,$api_type,$data,$cognito_user_id);

        $responseData  =  (array) json_decode($response);

        $decryptedBody = $this->decryptData($url,$api_type,$responseData['body'],$cognito_user_id); 
        
        if($response!="")
        {
            $yoloApis =  YoloApi::find($yoloApi->id);
            $yoloApis->api_name       = $request->api_name;
            $yoloApis->enviroment_id  = $request->enviroment_id;
            $yoloApis->api_type       = $request->api_type;
            $yoloApis->url            = $request->url;
            $yoloApis->message_name   = $messageName;
            $yoloApis->endpoint       = $request->endpoint;
            $yoloApis->endpoint       = $request->endpoint;
            $yoloApis->cognito        = $request->cognito;
            $yoloApis->request_body   = $request->request_body;
            $yoloApis->response_data  = $response;
            $yoloApis->api_status     = $request->api_status;
            $yoloApis->api_version    = $request->api_version;
            $yoloApis->decrypted_body = $decryptedBody;
            $saveResult = $yoloApis->save();

            return redirect()->route('admin.yolo-apis.index');
        } else {
         

            return redirect()->route('admin.yolo-apis.index');
        }



        return redirect()->route('admin.yolo-apis.index');
    }
    public function getEncrptedBody($yoloApi){
        $requestBody = (array)json_decode($yoloApi->request_body);
        $data = json_encode($requestBody); 

        $url      = $yoloApi->url;
        $api_type = ($yoloApi->api_type==1) ? 'GET' : 'POST';
        $cognito  = $yoloApi->cognito;


        $uuidSimple = str_replace("-", "", $cognito);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv         = substr($mdString,16);         
        $encrypt   = openssl_encrypt($data, 'aes-128-cbc', $key,0,$iv);
        $jsonBody  = ["headers"=>["x-shyld-app-id"=>base64_encode($cognito)],"body"=>$encrypt];
        return $jsonBody;
    }
    public function show(YoloApi $yoloApi)
    {
        abort_if(Gate::denies('yolo_api_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yoloApi->load('enviroment');
       
        
        $encrptedBody = $this->getEncrptedBody($yoloApi); 
        
        return view('admin.yoloApis.show', compact('yoloApi','encrptedBody'));
    }

    public function destroy(YoloApi $yoloApi)
    {
        abort_if(Gate::denies('yolo_api_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yoloApi->delete();

        return back();
    }

    public function massDestroy(MassDestroyYoloApiRequest $request)
    {
        YoloApi::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function tryApi(Request $request,$id)
    {
      
        $enviroments = Enviroment::pluck('enviroment', 'id')->prepend(trans('global.pleaseSelect'), '');
        $yoloApis = YoloApi::find($id);
        $data = '';

        return view('admin.yoloApis.tryApi', compact('enviroments','yoloApis','data'));
    }
    public function tryCustomApi(Request $request)
    {
        $id = $request->id;
        $url = $request->url.''.$request->endpoint;
        
        $requestBody = (array)json_decode($request->request_body);
         
        $data = json_encode($requestBody);
        $response = '';  
        $cognito_user_id       = $request->cognito;
        
        if($request->api_type==1){
            $api_type        = 'GET';    
        } 
        if($request->api_type==2){
            $api_type        = 'POST';    
        } 
        
 
        $response      = $this->getResponse($url,$api_type,$data,$cognito_user_id);
        $responseData  =  (array) json_decode($response);

        $decryptedBody = $this->decryptData($url,$api_type,$responseData['body'],$cognito_user_id);   
        
        return redirect()->back()->with(['data'=>$response,'decryptedBody'=>$decryptedBody])->withInput();
    }


    public function getResponse($url,$type,$data,$cognitoId){
     
     
        //$data = str_replace('null', '""', $data);//Replace Null value with doublequotes "" 
    
        $uuidSimple = str_replace("-", "", $cognitoId);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv         = substr($mdString,16);         
        $encrypt   = openssl_encrypt($data, 'aes-128-cbc', $key,0,$iv);
        $jsonBody  = ["headers"=>["x-shyld-app-id"=>base64_encode($cognitoId)],"body"=>$encrypt];
        $client = new Client(); 
        //$url ='https://ri7b2aywq1.execute-api.us-west-2.amazonaws.com/dev/users';
        $response = '';
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

    public function decryptData($url,$type,$data,$cognitoId){
        $uuidSimple = str_replace("-", "", $cognitoId);
        $stringStr  = $uuidSimple.'@SiMBA.InSuRAnCE';
        $mdString   = md5($stringStr);   //@SiMBA.InSuRAnCE
        $key        = substr($mdString,0,16);
        $iv         = substr($mdString,16);         
        $decrypt   = openssl_decrypt($data, 'aes-128-cbc', $key,0,$iv);
        return $decrypt;
    }
}
