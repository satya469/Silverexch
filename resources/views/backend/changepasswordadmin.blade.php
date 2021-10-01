@extends('backend.layouts.appReport')

@section('title', app_name() . ' | Add Sport')

@section('content')


<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="add-account">
        <h2 class="m-b-20">&nbsp;</h2>
        <form id="account_createForm" method="post" action="{{route('admin.client.userchangepasswordstore')}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              <h4 class="m-b-20 col-md-12">Change Password</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="username">Current Password</label>
                    <input required="" maxlength="15" placeholder="Current Password" name="old_password" id="old_password" value="" type="password" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="username">New Password</label>
                    <input required="" maxlength="15" placeholder="New Password" name="new_password" id="new_password" value="" type="password" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="username">Confirm Password</label>
                    <input required="" maxlength="15" placeholder="Confirm Password" name="c_password" id="c_password" value="" type="password" class="form-control">
                  </div>
                </div>  
              </div>
            </div>
            
          </div>
          
          
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="float-left">
                @csrf
                <button class="btn btn-submit" type="submit">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    
  </div>
</div>


@endsection

