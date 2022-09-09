@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>Enter Your OTP</h1>

                <p class="text-muted">OTP</p>

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verifyOtp') }}">
                    @csrf

                    <div class="input-group mb-3">
                         

                        <input id="number" name="otp" maxlength="6" type="text" class="form-control {{ $errors->has('otp') ? ' is-invalid' : '' }}" required autocomplete="otp" autofocus placeholder="Enter OTP" value="{{ old('otp', null) }}">
                        @if($errors->has('error'))
                            <div class="invalid-feedback">
                                {{ $errors->first('error') }}
                            </div>
                        @endif
                        
                    </div>

                   

                   

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                         
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection