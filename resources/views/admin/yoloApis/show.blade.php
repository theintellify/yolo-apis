@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.yoloApi.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.yolo-apis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
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
                        <th>
                            {{ trans('cruds.yoloApi.fields.request_body') }}
                        </th>
                        <td>
                            {{ pretty_print($yoloApi->request_body) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yoloApi.fields.response_data') }}
                        </th>
                        <td>
                            {{ pretty_print($yoloApi->response_data) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.yolo-apis.index') }}">
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

