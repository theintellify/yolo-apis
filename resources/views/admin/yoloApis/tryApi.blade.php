@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.try') }}  API
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.yolo-apis.try") }}" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{request()->id}}">
            @csrf 
            <div class="form-group">
                <label class="required" for="enviroment_id">{{ trans('cruds.yoloApi.fields.enviroment') }}</label>
                <select class="form-control select2 {{ $errors->has('enviroment') ? 'is-invalid' : '' }}" name="enviroment_id" id="enviroment_id" required>
                    @foreach($enviroments as $id => $entry)
                        <option value="{{ $id }}" {{ ($yoloApis->enviroment_id == $id)  ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('enviroment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('enviroment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.enviroment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.yoloApi.fields.api_type') }}</label>
                <select class="form-control {{ $errors->has('api_type') ? 'is-invalid' : '' }}" name="api_type" id="api_type" required>
                    <option value disabled {{ old('api_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\YoloApi::API_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{($key==$yoloApis->api_type) ? 'selected' : '' }} {{ old('api_type', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('api_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('api_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.api_type_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="url">{{ trans('cruds.yoloApi.fields.url') }}</label>
                 <input type="text" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" placeholder="URL" name="url" id="url" value="{{ $yoloApis->url }}" required readonly="readonly">
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.url_helper') }}</span>





                 

            </div>  
            
            <div class="form-group">
                <label class="required" for="endpoint">{{ trans('cruds.yoloApi.fields.endpoint') }}</label>
                <input class="form-control {{ $errors->has('endpoint') ? 'is-invalid' : '' }}" type="text" name="endpoint" id="endpoint" value="{{ $yoloApis->endpoint  }}" required>
                @if($errors->has('endpoint'))
                    <div class="invalid-feedback">
                        {{ $errors->first('endpoint') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.endpoint_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="cognito">{{ trans('cruds.yoloApi.fields.cognito') }}</label>
                <input class="form-control {{ $errors->has('cognito') ? 'is-invalid' : '' }}" type="text" name="cognito" id="cognito" value="{{  $yoloApis->cognito  }}" required>
                @if($errors->has('cognito'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cognito') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.cognito_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="request_body">{{ trans('cruds.yoloApi.fields.request_body') }}</label>
                <textarea class="form-control {{ $errors->has('request_body') ? 'is-invalid' : '' }}" name="request_body" id="request_body" required>{{ $yoloApis->request_body  }}</textarea>
                @if($errors->has('request_body'))
                    <div class="invalid-feedback">
                        {{ $errors->first('request_body') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.request_body_helper') }}</span>
            </div>
            <!-- <div class="form-group">
                <label for="response_data">{{ trans('cruds.yoloApi.fields.response_data') }}</label>
                <textarea class="form-control {{ $errors->has('response_data') ? 'is-invalid' : '' }}" name="response_data" id="response_data">{{ old('response_data') }}</textarea>
                @if($errors->has('response_data'))
                    <div class="invalid-feedback">
                        {{ $errors->first('response_data') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.response_data_helper') }}</span>
            </div> -->
            <div class="form-group">
                <button class="btn btn-danger" type="submit" id="btn-submit">
                    {{ trans('global.try') }}
                </button>
            </div>
        </form>
     
        <div>
               Please wait while for API response after Click Try ...your API response will be displayed below
        </div>
                
                <div id="beautified"  class="alert alert-info text-bold">
                     
                    
                         @if(\Session::has('data'))
                            <?php $data = \Session::get('data'); ?>
                            <p>
                                <?php echo pretty_print($data); ?>
                            </p>
                               
                          
                             
                        @endif 
                     
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
    

</div>



@endsection

@section('scripts')
<script >
                                             
                     
 

    $("#enviroment_id").change(function(evt){
       
        var id = $(this).val();
        if(id!=""){
             $("#url").val("");
            var url = '{{ route("api.getenviromentUrl", ":id") }}';
            url = url.replace(':id', id );
            $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function (data) {
                            console.log("data"+data.data.baseurl);
                           
                            $("#url").val(data.data.baseurl); 
                        },
                        error: function (error) {

                            
                        }
                    });
        }


    });
</script>

@endsection
 