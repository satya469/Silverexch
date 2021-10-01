@extends('frontend.layouts.appLogin')

@section('title', app_name())

@push('after-styles')
<style>
  .card-header-1 {
    padding: 5px 0.25rem 25px;
    font-size: 1.5rem;
    font-weight: 500;
    text-align: center;
    /*position: relative;*/
}
.card-header-1::before, .card-header-1::after {
    content: "";
    height: 1px;
    position: absolute;
    top: 35px;
    width: 20%;
    background: #000;
}
.card-header-1::after {
    right: 23px;
}
.card-header-1::before {
    left: 23px;
}
.card{
  width:100%;
  min-width: 400px;
}
.justify-content-center {
    width: 45%;
}
</style>
@endpush
@section('content')

    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="log-logo m-b-20 text-center">
                <img src="{{ url('/new/img/logo.png')}}" class="logo-login">
            </div>
            <div class="card">
                <div class="card-body text-center featured-box-login">
                    <div class="clearfix" style="clear:both;"></div>
                    <div class="card-header-1">Sign In</div>
                    {{ html()->form('POST', route('frontend.auth.admin-login.post'))->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <!--{{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}-->

                                    {{ html()->text('first_name')
                                        ->class('form-control')
                                        ->placeholder('User Name')
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                        <!--<i class="fas fa-user"></i>-->
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <!--{{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}-->

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder('password')
                                        ->required() }}
                                        <!--<i class="fas fa-key"></i>-->
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        @include('includes.partials.messages')

                        <div class="row">
                            <div class="col">
                                <div class="form-group text-center mb-0">
                                    <button type="submit" class="btn btn-submit btn-login">
                                        Login
                                        <i class=" ml-2 fas fa-sign-in-alt"></i>
                                    </button>
                                </div>
                            </div><!--col-->
                        </div><!--row-->
                        
                    {{ html()->form()->close() }}

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                @include('frontend.auth.includes.socialite')
                            </div>
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card body-->
            </div><!--card-->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if(config('access.captcha.login'))
        @captchaScripts
    @endif
@endpush
