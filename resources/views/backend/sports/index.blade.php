<?php
use App\Games;

?>
@extends('backend.layouts.appReport')

@section('title', app_name())

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
        <h2 class="d-inline-block">Match List</h2>
        <div class="float-right m-b-10">
          <p class="text-right">
            <a href="{{ route('admin.addSports',$id) }}" class="btn btn-diamond">Add Match</a>
          </p>
        </div>
      </div>
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <table id="clientListTable" class="table table-striped table-bordered dataTable no-footer" style="width:100%" role="grid" aria-describedby="clientListTable_info">
            <thead>
              <tr>
                  <th style="width: 40%;">Game</th>
                <th>Status</th>
                <th>Action</th>
                <th>In Play</th>
                <th>Bet Limit</th>
                @if($gameModel->name != 'CASINO')
                <th>Winner Select</th>
                <!--<th>Manage Fancy</th>-->
                @endif
              </tr>
            </thead>
            <tbody id="addNEwRowBody">
              @include('backend.sports.matchListBody')  
            </tbody>
          </table>
         </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="set-min-max-limit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Set Min and Max Limit</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="" id="LimitForm" method="post" autocomplete="off" onsubmit="return false">
        <div class="modal-body" id="modal-exposure-limit-body">
            <table class="table">
              @if($gameModel->name == 'CASINO')
                <tr>
                    <th>Min Limit</th>
                    <td><input type="text" name="odd_min_limit" id="odd_min_limit" value="0" class="text-right form-control"></td>
                </tr>
                <tr>
                    <th>Max Limit</th>
                    <td><input type="text" name="odd_max_limit" id="odd_max_limit" value="0" class="text-right form-control"></td>
                </tr>
              @else
              <tr>
                  <th>ODD Min Limit</th>
                  <td><input type="text" name="odd_min_limit" id="odd_min_limit" value="0" class="text-right form-control"></td>
              </tr>
              <tr>
                  <th>ODD Max Limit</th>
                  <td><input type="text" name="odd_max_limit" id="odd_max_limit" value="0" class="text-right form-control"></td>
              </tr>
              <tr>
                  <th>BookMaker Min Limit</th>
                  <td><input type="text" name="bookmaker_min_limit" id="bookmaker_min_limit" value="0" class="text-right form-control"></td>
              </tr>
              <tr>
                  <th>BookMaker Max Limit</th>
                  <td><input type="text" name="bookmaker_max_limit" id="bookmaker_max_limit" value="0" class="text-right  form-control"></td>
              </tr>
              <tr>
                  <th>Fancy Min Limit</th>
                  <td><input type="text" name="fancy_min_limit" id="fancy_min_limit" value="0" class="text-right form-control"></td>
              </tr>
              <tr>
                  <th>Fancy Max Limit</th>
                  <td><input type="text" name="fancy_max_limit" id="fancy_max_limit" value="0" class="text-right form-control"></td>
              </tr> 
              @endif
          </table>
            
        </div>
        <div class="modal-footer">
            <div class="msg"></div>
            @csrf
          <input type="hidden" name="id" id="id">
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
          <button type="button" onclick="saveLimitData(this);" class="btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="model-winner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Select Winner</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <form action="" id="LimitForm" method="post" autocomplete="off" onsubmit="return false">
        <div class="modal-body" id="model-winner-body">
        </div>
        <div class="modal-footer">
            <div class="model-winner-msg"></div>
            @csrf
          <input type="hidden" name="id" id="id">
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
          <button type="button" onclick="saveWinnerData(this);" class="btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@push('after-scripts')
<script type="text/javascript">
  
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

function changeStatus(id,obj){
  $.ajax({
      url: "{{route('admin.sports.chnagestatus')}}",
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
          $(obj).text(response.msg);
          $(obj).closest('tr').find('.status').text(response.text);
        }
      },
    });
}
function changeStatusInplay(id,obj){
  $.ajax({
      url: "{{route('admin.sports.chnagestatusInplay')}}",
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
          $(obj).text(response.msg);
        }
      },
    });
}
function winnerSelect(id,obj){
  $("#model-winner").find('#id').val(id);
  $("#model-winner").find('.msg').html('');
  $.ajax({
      url: "{{route('admin.sports.winnerselect')}}",
      type: "POST",
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
        $("#model-winner-body").html(response);
        $("#model-winner").modal("show");
      },
    });
}
function saveWinnerData(obj){
  var teamName  = $("#model-winner").find('#winnerTeam').val();
  if(teamName == ''){
    alert("Please Select Winner Team");
    return false;
  }
  var id = $("#model-winner").find('#id').val();
  $.ajax({
      url: "{{route('admin.sports.winnerselectstore')}}",
      type: "POST",
      dataType: 'json',
      data: {
            'id':id,
            'winnerTeam':teamName,
            '_token': "{{ csrf_token() }}",
        },
      beforeSend: function(){
            showLoading('model-winner');
      },
      complete:function(){
            hideLoading('model-winner');
      },
      success: function(response){
        if(response.status == true){
          alert(response.message);
          $("#model-winner").modal("hide");
//          $('.model-winner-msg').html(response.message);
          $('#addNEwRowBody').html(response.bodyHtml);
          
        }else{
          alert(response.message);
          $("#model-winner").modal("hide");
//          $('.model-winner-msg').html(response.message);
        }
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
$.noConflict();
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
          alert(response.msg);
          $('.msg').html(response.msg);
        }else{
           alert(response.msg);
           
          $('.msg').html(response.msg);
        }
        $("#set-min-max-limit").modal("hide");
      },
    });
}


</script>

@endpush
