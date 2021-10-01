@extends('backend.layouts.appReport')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
 <div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="add-account">
        <h2 class="m-b-20">Manage TV</h2>
        <form id="account_createForm" method="post" action="{{route('admin.managetvstore')}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              <!--<h4 class="m-b-20 col-md-12">Admin Message - User Message Detail</h4>-->
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="TV_URL_1">TV URL 1:</label>
                    {{ html()->text('TV_URL_1',$model->TV_URL_1)
                                    ->class('form-control')
                                    ->placeholder('TV URL 1')
                                    ->autofocus() }}
                    <span id="TV_URL_1-required" class="error"></span>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="TV_URL_2">TV URL 2:</label>
                    {{ html()->text('TV_URL_2',$model->TV_URL_2)
                                    ->class('form-control')
                                    ->placeholder('TV URL 2')
                                    ->autofocus() }}
                    <span id="TV_URL_1-required" class="error"></span>
                  </div>
                </div>
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="TV_URL_3">TV URL 3:</label>
                    {{ html()->text('TV_URL_3',$model->TV_URL_3)
                                    ->class('form-control')
                                    ->placeholder('TV URL 3') }}
                    <span id="TV_URL_1-required" class="error"></span>
                  </div>
                </div>
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="TV_URL_4">TV URL 4:</label>
                    {{ html()->text('TV_URL_4',$model->TV_URL_4)
                                    ->class('form-control')
                                    ->placeholder('TV URL 4') }}
                    <span id="TV_URL_1-required" class="error"></span>
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
