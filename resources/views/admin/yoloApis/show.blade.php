@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.yoloApi.title') }}
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-primary" href="{{ route('admin.yolo-apis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                <a class="btn btn-warning text-white" href="{{ URL::to('admin/yolo-apis/try',$yoloApi->id) }}">Try API</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th style="width: 200px;">
                            {{ trans('cruds.yoloApi.fields.id') }}
                        </th>
                        <td>
                            {{ $yoloApi->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.enviroment') }}
                        </th>
                        <td>
                            {{ $yoloApi->enviroment->enviroment ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.api_type') }}
                        </th>
                        <td>
                            {{ App\Models\YoloApi::API_TYPE_SELECT[$yoloApi->api_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.url') }}
                        </th>
                        <td>
                            {{ $yoloApi->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.endpoint') }}
                        </th>
                        <td>
                            {{ $yoloApi->endpoint }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.cognito') }}
                        </th>
                        <td>
                            {{ $yoloApi->cognito }}
                        </td>
                    </tr>
                    <tr>
                        <th >
                            {{ trans('cruds.yoloApi.fields.request_body') }}
                        </th>

                        <td> <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#request_body">Click to view</button>    
                            <div id="request_body" class="accordion-collapse collapse" >{{ pretty_print($yoloApi->request_body) }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th >
                            {{ trans('cruds.yoloApi.fields.request_encrypted_body') }}
                        </th>

                        <td> <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#request_encrypted_body">Click to view</button>    
                            <div id="request_encrypted_body" class="accordion-collapse collapse" style="width: 1050px;">
                                 
                                      {{ pretty_print(json_encode($encrptedBody)) }}
                                  
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.response_data') }}
                        </th>
                        <td>
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#response_data">Click to view</button>
                            <div id="response_data" class="accordion-collapse collapse" style="width: 950px;"> 
                            {{ pretty_print($yoloApi->response_data) }}
                            </div>
                        </td>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.decrypted_body') }}
                        </th>
                        <td>
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#decrypted_body">Click to view</button>
                            <div id="decrypted_body" class="accordion-collapse collapse" >  
                                {{ pretty_print($yoloApi->decrypted_body) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.api_version') }}
                        </th>
                        <td>
                            {{ $yoloApi->api_version }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.api_status') }}
                        </th>
                        <td>
                            {{ $yoloApi->api_status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-primary" href="{{ route('admin.yolo-apis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
 

 <?php function pretty_print($json_data)
{
//Initialize variable for adding space
$space = 0;
$flag = false;
//Using <pre> tag to format alignment and font
echo'<pre style="color:#000;font-size:large;">';
//loop for iterating the full json data
for($counter=0; $counter<strlen($json_data); $counter++)
{
//Checking ending second and third brackets
if( $json_data[$counter] == '}' || $json_data[$counter] == ']' )
    {
$space--;
echo"\n";
echo str_repeat(' ', ($space*2));
    }

//Checking for double quote(“) and comma (,)
if( $json_data[$counter] == '"'&& ($json_data[$counter-1] == ',' || $json_data[$counter-2] == ',') )
    {
echo"\n";
echo str_repeat(' ', ($space*2));
    }
if( $json_data[$counter] == '"'&& !$flag )
    {
if( $json_data[$counter-1] == ':' || $json_data[$counter-2] == ':' )
//Add formatting for question and answer
echo'';
else
//Add formatting for answer options
echo' ';
    }
echo$json_data[$counter];
//Checking conditions for adding closing span tag  
if( $json_data[$counter] == '"'&&$flag )
echo'</span>';
if( $json_data[$counter] == '"' )
$flag= !$flag;
//Checking starting second and third brackets
if( $json_data[$counter] == '{' || $json_data[$counter] == '[' )
    {
$space++;
echo"\n";
echo str_repeat(' ', ($space*2));
    }
}
echo"</pre>";
} ?>
    

@endsection

