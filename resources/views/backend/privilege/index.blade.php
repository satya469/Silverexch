<?php
use App\Games;

?>
@extends('backend.layouts.appReport')

@section('title', app_name() . ' | Client List')

@section('content')

<style>
    .data-table table td a{
      background: none;
      color:#007bff;
    }
</style>
<div class="row">
  <div class="col-md-12 main-container">
    <div class="listing-grid">
      <div class="detail-row">
        <h2 class="d-inline-block">Privilege List</h2>
        <div class="float-right m-b-10">
          <p class="text-right">
              <span class="messageDisplay"></span>
              <a href="javascipt:void(0);" onclick="openUserFrom();" class="btn btn-diamond">Add Privilege</a>
          </p>
        </div>
      </div>
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <table id="clientListTable" class="table table-striped table-bordered dataTable no-footer" style="width:100%" role="grid" aria-describedby="clientListTable_info">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>User Name</th>
                <th>List Client</th>
                <th>Main Market</th>
                <th>Manage Fancy</th>
                <th>Fancy History</th>
                <th>Match History</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($privilegeModel as $key=>$privilege)
              <?php 
              $listofClient = $mainMarket = $manageFancy = $fancyHistory = $matchHistory = '';
              if($privilege->listOfClient == 1){
                $listofClient = "checked='checked'";
              }
              if($privilege->mainMarket == 1){
                $mainMarket = "checked='checked'";
              }
              if($privilege->manageFancy == 1){
                $manageFancy = "checked='checked'";
              }
              if($privilege->fancyHistory == 1){
                $fancyHistory = "checked='checked'";
              }
              if($privilege->matchHistory == 1){
                $matchHistory = "checked='checked'";
              }
              
              
              ?>
              <tr role="row" class="even">
                <td class="notLink">{{ ($key+1)}}</td>
                <td class="status">{{$privilege->userName}}</td>
                <td><input <?= $listofClient ?> type="checkbox" class="listClient" onclick="saveListClientPrivilege(this,'{{$privilege->id}}')" value="1"></td>
                <td><input <?= $mainMarket ?> type="checkbox" class="mainMarket" onclick="saveMainMarketPrivilege(this,'{{$privilege->id}}')" value="1"></td>
                <td><input <?= $manageFancy ?> type="checkbox" class="namageFancy" onclick="savenamageFancyPrivilege(this,'{{$privilege->id}}')" value="1"></td>
                <td><input <?= $fancyHistory ?> type="checkbox" class="fancyHistory" onclick="saveFancyHistoryPrivilege(this,'{{$privilege->id}}')" value="1"></td>
                <td><input <?= $matchHistory ?> type="checkbox" class="matchHistory" onclick="saveMatchHistoryPrivilege(this,'{{$privilege->id}}')" value="1"></td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-primary" onclick="editUser(this,'{{$privilege->id}}');">Edit</a>
                    <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteUser(this,'{{$privilege->id}}');">Delete</a>
                </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
         </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="showUSerPopup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="" id="LimitForm" method="post" autocomplete="off" onsubmit="return false">
        <div class="modal-body" id="modal-exposure-limit-body">
            <table class="table">
              <tr>
                  <th>User Name : </th>
                  <td><input type="text" name="userName" id="userName" value=""></td>
              </tr>
              <tr>
                  <th>Password : </th>
                  <td><input type="password" name="password" id="password" value=""></td>
              </tr>
          </table>
            
        </div>
        <div class="modal-footer">
            <div class="showUSerPopupmsg"></div>
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
          <button type="button" onclick="saveUser(this);" class="btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="showUSerPopupUpdate">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="" id="LimitForm" method="post" autocomplete="off" onsubmit="return false">
        <div class="modal-body" id="modal-exposure-limit-body">
            <table class="table">
              <tr>
                  <th>User Name : </th>
                  <td><input type="text" name="userNameupdata" id="userNameupdata" value=""></td>
              </tr>
              <tr>
                  <th>Password : </th>
                  <td><input type="password" name="passwordpudata" id="passwordpudata" value=""></td>
              </tr>
          </table>
            
        </div>
        <div class="modal-footer">
            <div class="showUSerPopupmsgUpdate"></div>
            <input type="hidden" id="id" value="">
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
          <button type="button" onclick="updateUser(this);" class="btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@push('after-scripts')
<script type="text/javascript">
  jQuery.noConflict();
  $(document).ready(function() {
      $('#clientListTable').DataTable( {
            "pageLength": 50,
            "order": [],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'excel',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
      });
  } );
function deleteUser(obj,id){
  if(!confirm("Are You Sure Delete This User")){
    return false;
  }
  $.ajax({
    url: "{{route('admin.privilige.deletePrivilege')}}",
    type: "POST",
    dataType: 'json',
    data: {
          'id':id,
          '_token': "{{ csrf_token() }}",
      },
    beforeSend: function(){
            showLoading('showUSerPopup');
    },
    complete:function(){
            hideLoading('showUSerPopup');
    },
    success: function(response){
      if(response.status == true){
        alert(response.message);
//        $('.messageDisplay').html(response.message);
      }else{
         alert(response.message);
//        $('.messageDisplay').html(response.message);
      }
    },
  });
}
function editUser(obj,id){
  $.ajax({
    url: "{{route('admin.privilige.editprivilege')}}",
    type: "POST",
    dataType: 'json',
    data: {
          'id':id,
          '_token': "{{ csrf_token() }}",
      },
    beforeSend: function(){
//            showLoading();
    },
    complete:function(){
//            hideLoading();
    },
    success: function(response){
      if(response.status == true){
        $('#id').val(id);
        $('#userNameupdata').val(response.name);
        $("#showUSerPopupUpdate").modal("show");
      }
    },
  });
  
}

function updateUser(obj){
  var userName = $('#userNameupdata').val();
  var pass = $('#passwordpudata').val();
  if(userName == ''){
    alert("user name are required");
  }
  var id = $('#id').val();
  $.ajax({
    url: "{{route('admin.privilige.updateprivilege')}}",
    type: "POST",
    dataType: 'json',
    data: {
          'id':id,
          'userName': userName,
          'password':pass,
          '_token': "{{ csrf_token() }}",
      },
    beforeSend: function(){
//            showLoading();
    },
    complete:function(){
//            hideLoading();
    },
    success: function(response){
      if(response.status == true){
        $('#userName').val(response.name);
        $('.showUSerPopupmsgUpdate').html(response.message);
      }
    },
  });
  
}

function openUserFrom(){
  $("#showUSerPopup").modal("show");
}

function saveListClientPrivilege(obj,id){
  if($(obj).prop('checked') == true){
    var  listClient = 1;
  }else{
    var  listClient = 0;
  }
  $.ajax({
      url: "{{route('admin.privilige.storePrivilege')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'listClient':listClient,
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
//        if(response.status == true){
//          alert(response.message);
//          $('.messageDisplay').html(response.message);
//        }else{
//          $('.messageDisplay').html(response.message);
//        }
        alert(response.message);
      },
    });
}
function saveMainMarketPrivilege(obj,id){
  if($(obj).prop('checked') == true){
    var  mainMarket = 1;
  }else{
    var  mainMarket = 0;
  }
  $.ajax({
      url: "{{route('admin.privilige.storePrivilege')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'mainMarket':mainMarket,
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
//        if(response.status == true){
//          $('.messageDisplay').html(response.message);
//        }else{
//          $('.messageDisplay').html(response.message);
//        }
        alert(response.message);
      },
    });
}
function savenamageFancyPrivilege(obj,id){
  if($(obj).prop('checked') == true){
    var  namageFancy = 1;
  }else{
    var  namageFancy = 0;
  }
  $.ajax({
      url: "{{route('admin.privilige.storePrivilege')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'namageFancy':namageFancy,
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
//        if(response.status == true){
//          $('.messageDisplay').html(response.message);
//        }else{
//          $('.messageDisplay').html(response.message);
//        }
        alert(response.message);
      },
    });
}
function saveFancyHistoryPrivilege(obj,id){
  if($(obj).prop('checked') == true){
    var  fancyHistory = 1;
  }else{
    var  fancyHistory = 0;
  }
  $.ajax({
      url: "{{route('admin.privilige.storePrivilege')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'fancyHistory':fancyHistory,
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
//        if(response.status == true){
//          $('.messageDisplay').html(response.message);
//        }else{
//          $('.messageDisplay').html(response.message);
//        }
        alert(response.message);
      },
    });
}

function saveMatchHistoryPrivilege(obj,id){
  if($(obj).prop('checked') == true){
    var  matchHistory = 1;
  }else{
    var  matchHistory = 0;
  }
  $.ajax({
      url: "{{route('admin.privilige.storePrivilege')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'matchHistory':matchHistory,
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
//        if(response.status == true){
//          $('.messageDisplay').html(response.message);
//        }else{
//          $('.messageDisplay').html(response.message);
//        }
        alert(response.message);
        
      },
    });
}
function saveUser(obj){
  var userName  = $('#userName').val();
  var password  = $('#password').val();
  if(userName == '' || password == '' ){
    alert("Please Both value are required");
    return false;
  }
  $.ajax({
      url: "{{route('admin.privilige.store')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'userName':userName,
            'password':password,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
            showLoading('showUSerPopup');
      },
      complete:function(){
            hideLoading('showUSerPopup');
      },
      success: function(response){
        if(response.status == true){
          alert(response.message);
//          $('.showUSerPopupmsg').html(response.message);
        }else{
          alert(response.message);
//          $('.showUSerPopupmsg').html(response.message);
        }
        $("#showUSerPopup").modal("hide");
      },
    });
}
function chnagesuspened(id,obj){
  $.ajax({
      url: "{{route('admin.sports.chnagesuspened')}}",
      type: "POST",
      dataType: 'json',
      data: {
          'id':id,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
        if(response.status == true){
          $(obj).css('color','red');
        }
      },
    });
}

function setLimit(id){
  $('#id').val(id);
  $('.msg').html('');
  $.ajax({
      url: "{{route('admin.sports.getMAxMinLimit')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
        if(response.status == true){
          $('.msg').html(response.msg);
          $('#odd_min_limit').val(response.odd_min_limit);
          $('#odd_max_limit').val(response.odd_max_limit);
          $('#bookmaker_min_limit').val(response.bookmaker_min_limit);
          $('#bookmaker_max_limit').val(response.bookmaker_max_limit);
          $('#fancy_min_limit').val(response.fancy_min_limit);
          $('#fancy_max_limit').val(response.fancy_max_limit);
          $("#set-min-max-limit").modal("show");
        }
      },
    });
  
}

function saveLimitData(obj){
  var dataarr = $(obj).closest('form').serialize();
  $.ajax({
      url: "{{route('admin.sports.setLimit')}}",
      type: "POST",
      dataType: 'json',
      data: dataarr,
      beforeSend: function(){
//            showLoading();
      },
      complete:function(){
//            hideLoading();
      },
      success: function(response){
        if(response.status == true){
          $('.msg').html(response.msg);
        }else{
          $('.msg').html(response.msg);
        }
      },
    });
}


</script>

@endpush
