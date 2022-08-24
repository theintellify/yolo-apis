@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.yoloApi.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.yolo-apis.update", [$yoloApi->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="enviroment_id">{{ trans('cruds.yoloApi.fields.enviroment') }}</label>
                <select class="form-control select2 {{ $errors->has('enviroment') ? 'is-invalid' : '' }}" name="enviroment_id" id="enviroment_id" required>
                    @foreach($enviroments as $id => $entry)
                        <option value="{{ $id }}" {{ (old('enviroment_id') ? old('enviroment_id') : $yoloApi->enviroment->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <option value="{{ $key }}" {{ old('api_type', $yoloApi->api_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', $yoloApi->url) }}" required readonly="readonly">
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="endpoint">{{ trans('cruds.yoloApi.fields.endpoint') }}</label>
                <input class="form-control {{ $errors->has('endpoint') ? 'is-invalid' : '' }}" type="text" name="endpoint" id="endpoint" value="{{ old('endpoint', $yoloApi->endpoint) }}" required>
                @if($errors->has('endpoint'))
                    <div class="invalid-feedback">
                        {{ $errors->first('endpoint') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.endpoint_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="cognito">{{ trans('cruds.yoloApi.fields.cognito') }}</label>
                <input class="form-control {{ $errors->has('cognito') ? 'is-invalid' : '' }}" type="text" name="cognito" id="cognito" value="{{ old('cognito', $yoloApi->cognito) }}" required>
                @if($errors->has('cognito'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cognito') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.cognito_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="request_body">{{ trans('cruds.yoloApi.fields.request_body') }}</label>
                <textarea class="form-control {{ $errors->has('request_body') ? 'is-invalid' : '' }}" name="request_body" id="request_body" required>{{ old('request_body', $yoloApi->request_body) }}</textarea>
                @if($errors->has('request_body'))
                    <div class="invalid-feedback">
                        {{ $errors->first('request_body') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.request_body_helper') }}</span>
            </div>
            <!-- <div class="form-group">
                <label for="response_data">{{ trans('cruds.yoloApi.fields.response_data') }}</label>
                <textarea class="form-control {{ $errors->has('response_data') ? 'is-invalid' : '' }}" name="response_data" id="response_data">{{ old('response_data', $yoloApi->response_data) }}</textarea>
                @if($errors->has('response_data'))
                    <div class="invalid-feedback">
                        {{ $errors->first('response_data') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.yoloApi.fields.response_data_helper') }}</span>
            </div> -->
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
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