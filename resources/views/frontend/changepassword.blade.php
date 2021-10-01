@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 featured-box">
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0">Change Password</h4>
      </div>
      <div class="card-body container-fluid container-fluid-5 button-value">
        <div class="row"><div class="col-12" id="msg"></div></div>
        <div class="row">
            <form style="width: 100%;" method="POST" action="{{route('frontend.userchangepasswordstore')}}">
            <div class="col-sm-12">
                <input type="hidden" name='_token' value="{{ csrf_token() }}">
              <div class="form-group col-sm-6">
                <label for="usr">Current Password</label>
                <input type="password" name="old_password" class="form-control" id="usr">
              </div>
            </div>    
            <div class="col-sm-12">
                <input type="hidden" name='_token' value="{{ csrf_token() }}">
              <div class="form-group col-sm-6">
                <label for="usr">New Password</label>
                <input type="password" name="new_password" class="form-control" id="usr">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group col-sm-6">
                <label for="pwd">Confirm Password</label>
                <input type="password" name="c_password" class="form-control" id="pwd">
              </div>
            </div>
            <div class="col-sm-12">    
              <div class="form-group col-sm-6">
                  <input type="submit" class="btn btn-primary" value="submit">
              </div>  
            </div>
                </form>
            </div>
        </div>
      </div>
    </div>


  </div>
</div>


@endsection

@push('after-styles')
<style>
  a {
  pointer-events: none;
  cursor: default;
}
.chnagePass{
  pointer-events: auto !important;
  cursor: default;
}    
</style>

@endpush
