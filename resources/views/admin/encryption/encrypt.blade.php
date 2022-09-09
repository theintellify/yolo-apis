@extends('layouts.admin')
@section('content')
<style type="text/css">
    nav button{
        margin-right: 10px;
    }
</style>  
<div class="card">
    <div class="card-header">
         {{ trans('cruds.menu_encryption.title_singular') }}
    </div>

    <div class="card-body">
         <nav  class="nav nav-pills">
            <button type="button" class="btn btn-sm btn-primary"  data-toggle="pill" href="#home">Encrypt</button>
            <button type="button" class="btn btn-sm btn-success"  data-toggle="pill" href="#menu1">Decrypt</button >
             
          </nav>
          <?php
          $request_encrypt_type  = session('request_encrypt_type');
          $encrypted_response    = session('encrypted_response');
          $decrypted_response    = session('decrypted_response');
           if($request_encrypt_type==1){
                    $isEncryptActive = $request_encrypt_type;
           }
           if($request_encrypt_type==2){
                    $isDecryptActive = $request_encrypt_type;
                
           } 
          ?>
          <div class="tab-content  " style="margin-top: 10px;">
            <div id="home" class="tab-pane fade  {{ (isset($isEncryptActive)) ? 'in active show':''  }}">
              <div class="card bg-light  card-body ">
                <form  method="POST" action="{{ route("admin.execute.encryption") }}" enctype="multipart/form-data">
                    <input type="hidden" name="request_encrypt_type" value="1">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="cognito_id">{{ trans('cruds.menu_encryption.fields.cognito_id') }}</label>
                        <input class="form-control {{ $errors->has('cognito_id') ? 'is-invalid' : '' }}" type="text" name="cognito_id" id="cognito_id" value="{{ old('cognito_id', '') }}" required>
                        @if($errors->has('cognito_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cognito_id') }}
                            </div>
                        @endif
                       
                    </div>
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.menu_encryption.fields.request_body') }}</label>
                        <textarea name="body" class="form-control">{{ old('body', '') }}</textarea>
                    </div>                     
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                             Execute
                        </button>
                    </div>
                </form>
                <hr/>
                <div class="col-md-12">
                    @if($encrypted_response)
                  <pre> {{ pretty_print(json_encode($encrypted_response)) }}</pre>
                  @endif
                </div>
              </div>
              
            </div>
            <div id="menu1" class="tab-pane fade {{ (isset($isDecryptActive)) ? 'in active show':''  }}">
              <div class="card text-white card-body" style="background-color: #6c757d!important;">
                  <form  method="POST" action="{{ route("admin.execute.decryption") }}" enctype="multipart/form-data">
                    <input type="hidden" name="request_encrypt_type" value="2">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="decrypt_cognito_id">{{ trans('cruds.menu_encryption.fields.cognito_id') }}</label>
                        <input class="form-control {{ $errors->has('decrypt_cognito_id') ? 'is-invalid' : '' }}" type="text" name="decrypt_cognito_id" id="decrypt_cognito_id" value="{{ old('decrypt_cognito_id', '') }}" required>
                        @if($errors->has('decrypt_cognito_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('decrypt_cognito_id') }}
                            </div>
                        @endif
                       
                    </div>
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.menu_encryption.fields.request_body') }}</label>
                        <textarea name="decrypt_body" class="form-control">{{ old('decrypt_body', '') }}</textarea>
                    </div>                     
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            Execute
                        </button>
                    </div>
                </form>
                <hr/>
                <div class="col-md-12">
                    @if($decrypted_response)
                  <pre class="text-white"> {{ pretty_print($decrypted_response) }}</pre>
                  @endif
                </div>
              </div>
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