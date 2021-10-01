@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 featured-box">
    

<div class="card">
  <div class="card-header">
    <h4 class="mb-0">Change Password</h4>
  </div>
  <div class="card-body container-fluid container-fluid-5">
       <div class="row row5 mt-2">
           <div id="msg" class="col-12"></div>
             
       </div>
      <form id="changepass">
    <div class="row row5 mt-2">
      <div style="width:100%;padding: 10px;">
          @csrf
        <div class="form-group"><label>Current Password</label> <input name='oldpassword' id="old" type="password" class="form-control"></div>
        <div class="form-group"><label>New Password</label> <input id='new' name='newpassword' type="password" class="form-control"></div>
        <div class="form-group"><label>Confirm New Password</label> <input id="conf" type="password" class="form-control"></div>
      </div>
    </div>
    <div class="row row5 mt-2">
        <div class="col-12"><a href="javascript:void(0);" onclick="saveValue();" class="btn btn-primary">Change Password</a></div>
    </div>
      </form>
  </div>
</div>



  </div>
</div>


@endsection

@push('after-scripts')
<script>
  function saveValue(){
    $("#msg").html('');
    if($('#old').val() == '' || $('#new').val() == '' || $('#conf').val() == ''){
      return false;
    }
    if($('#new').val() != $('#conf').val()){
     var html = '<div class="alert alert-danger">new password or Confirm New Password not match!</div>';
      $("#msg").html(html);
       return false;
    }
    var data = $("#changepass").serialize();
    var inputs = $("#changepass").find("input, select, button, textarea");
    inputs.prop("disabled", true);
    
    request = $.ajax({
        url: "{{route('frontend.pwStore')}}",
        type: "post",
        dataType: "JSON",
        data: data
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
      var html = '';
      if(response.status == true){
        html += '<div class="alert alert-success">'+response.message+'</div>';
//        inputs.val('');
      }else{
        html += '<div class="alert alert-danger">'+response.message+'</div>';
      }
      location.reload(true);
      $("#msg").html(html);
    });
  // Callback handler that will be called regardless
  // if the request failed or succeeded
  request.always(function () {
      // Reenable the inputs
      inputs.prop("disabled", false);
  });
  }
</script>

@endpush
