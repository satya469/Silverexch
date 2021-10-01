@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')
 <div class="row">
  <div class="col-md-12 main-container">
    <div>
        <div class="add-account" style="box-shadow: none;">
        <!--<h2 class="m-b-20">Admin Site Setting</h2>-->
        <form id="account_createForm" method="post" action="{{route('admin.admin-setting.store')}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="admin_message">Admin Message:</label>
                    {{ html()->text('admin_message',$model->admin_message)
                                    ->class('form-control')
                                    ->placeholder('Admin Message')
                                    ->required()
                                    ->autofocus() }}
                    <span id="admin_message-required" class="error"></span>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="user_message">User Message:</label>
                    {{ html()->text('user_message',$model->user_message)
                                    ->class('form-control')
                                    ->placeholder('User Message')
                                    ->required() }}
                    <span id="user_message-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="maintanence">Maintanence:</label>
                    {{ html()->checkbox('maintanence',$model->maintanence)
                             ->attribute('onclick', 'checkStatus(this)')
                    }}
                    <span id="maintanence-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-12 msg">
                  <div class="form-group">
                    <label for="maintanence_message">Maintanence Message:</label>
                    {{ html()->text('maintanence_message',$model->maintanence_message)
                                    ->class('form-control')
                                    ->placeholder('Maintanence Message') }}
                    <span id="phone-error" class="error"></span>
                  </div>
                </div>
                 
              </div>
            </div>
             
          </div>
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="form-group col-md-3 float-right">
                <label for="m_pwd">Master Password:</label>
                <input required="" maxlength="15" placeholder="Master Password" name="m_pwd" id="m_pwd" value="" type="password" class="form-control">
                <span id="m_pwd-error" class="error"></span>
              </div>
            </div>
          </div>
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="float-right">
                @csrf
                <button class="btn btn-submit" type="submit">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection

@push('after-scripts')
<!--@include('backend.reloadJS')-->
<script>
 $( document ).ready(function() {
    checkStatus($('#maintanence'));
}); 
function checkStatus(obj){
  if($(obj).prop('checked') == true){
    $('.msg').show();
  }else{
    $('.msg').hide();
  }
}
</script>
@endpush
