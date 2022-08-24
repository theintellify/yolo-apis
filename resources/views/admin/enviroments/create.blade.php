@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.enviroment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.enviroments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="enviroment">{{ trans('cruds.enviroment.fields.enviroment') }}</label>
                <input class="form-control {{ $errors->has('enviroment') ? 'is-invalid' : '' }}" type="text" name="enviroment" id="enviroment" value="{{ old('enviroment', '') }}" required>
                @if($errors->has('enviroment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('enviroment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.enviroment.fields.enviroment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="baseurl">{{ trans('cruds.enviroment.fields.baseurl') }}</label>
                <input class="form-control {{ $errors->has('baseurl') ? 'is-invalid' : '' }}" type="text" name="baseurl" id="baseurl" value="{{ old('baseurl', '') }}" required>
                @if($errors->has('baseurl'))
                    <div class="invalid-feedback">
                        {{ $errors->first('baseurl') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.enviroment.fields.baseurl_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection