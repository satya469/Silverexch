<?php 
use App\AdminSetting;
$adminSetting = AdminSetting::first();
?>

@extends('frontend.layouts.appLogin')

@section('title', app_name())

@section('content')

    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center" style="max-width: 85% !importan">
            <div class="log-logo m-b-20 text-center">
                <img src="{{ url('/new/img/logo.png')}}" class="logo-login">
            </div>
            <div class="card">
                <div class="card-body text-center featured-box-login">
                    @include('includes.partials.messages')
                    
                    <h4>LOGIN <i class="fas fa-hand-point-down"></i></h4>
                    {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->text('first_name')
                                        ->class('form-control')
                                        ->placeholder('User Name')
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                        <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder('password')
                                        ->required() }}
                                        <i class="fas fa-key"></i>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group text-center mb-0">
                                    <button type="submit" class="btn btn-submit btn-login">
                                        Login
                                        <i class=" ml-2 fas fa-sign-in-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <small class="recaptchaTerms">This site is protected by reCAPTCHA and the Google
                          <a href="https://policies.google.com/privacy">Privacy Policy</a> and
                          <a href="https://policies.google.com/terms">Terms of Service</a> apply.
                        </small>
                        <div class="mt-2 text-center download-apk">
                            <a href="javascript:void(0);" class="blinking btn btn-submit btn-login">
                                <span><i class="fab fa-android"></i><b>Download Apk</b></span>
                            </a> 
                        </div>
                        @if(config('access.captcha.login'))
                            <div class="row">
                                <div class="col">
                                    @captcha
                                    {{ html()->hidden('captcha_status', 'true') }}
                                </div>
                            </div>
                        @endif

                    {{ html()->form()->close() }}

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                @include('frontend.auth.includes.socialite')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-styles')
   <style>
  html, body {
    height: 100%;
    font-family: roboto condensed,sans-serif;
    color: var(--site-color);
    font-size: 16px;
    line-height: 15px;
    background-color: var(--theme1-bg) !important;
}
.login {
    width: 100%;
    background-image: var(--theme1-bg) !important;
    display: flex;
    justify-content: center;
    height: 100vh;
}
@media only screen and (max-width: 768px) {
    .col-sm-8,
    .abclogin{
      max-width: 85% !importan;
    }
}
</style>
@endpush
@push('after-scripts')
    @if(config('access.captcha.login'))
        @captchaScripts
    @endif
@endpush
