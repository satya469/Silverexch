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
        <h2 class="d-inline-block">Manage Cricket Fancy List</h2>
      </div>  
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <!--<table style="width:80%;" class="table coupon-table table table-striped table-bordered m-t-10">-->
            <?php 
            if(!isset($sports) || (isset($sports) && count($sports) == 0) ){
              echo "<div class='alert alert-info'>Record not available</div>";
            }
            ?>
            <table class="table coupon-table table table-striped table-bordered m-t-10">
            <tbody>
                
              @foreach($sports as $key=>$data)
              <?php 
              $treamname = str_replace(' ','_', $data->team_name);
              $treamname = str_replace('(','_', $treamname);
              $treamname = str_replace(')','_', $treamname);
              ?>
              <tr role="row" class="odd {{$treamname}}">
                  <td class="text-left "><a href="javascript:void(0);" class="teamName">{{$data->team_name}}</a></td>
                <td class="box-w1 LAY lay-color fb_td">
                    <button class="bet-sec lay">
                        <span class="odd layprice">0</span>
                         <span class="odd laysize">0</span>
                    </button>
                </td>
                <td class="box-w1 BACK back-color fb_td">
                    <button class="bet-sec back">
                        <span class="odd backprice">0</span>
                        <span class="odd backsize">0</span>
                    </button>
                </td>
                <td class="text-left"><div class="resultText"></div>
                    <input type="hidden" class="matchID" value="{{$matchID}}">
                    <input type="hidden" class="teamsname" value="{{$data->team_name}}">    
                    <a href="javascript:void(0);" onclick="showResult(this);">Result Declare</a>
                </td>
                <td class="text-left"><a href="javascript:void(0);" onclick="cancelFancy(this);">Result Cancel</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
         </div>
      </div>
    </div>
  </div>
</div>


@endsection


@push('after-scripts')
<script type="text/javascript">
  function showResult(obj){
    var html = '<input type="number"  class="resultrun" style="width:100px;padding:10px;"> ';
        html += '  <a href="javascript:void(0);" class="btn btn-primary" onclick="saveResult(this);">Submit</a>'
    $(obj).closest('td').find('.resultText').html(html);
  }
  function cancelFancy(obj){
    var matchID = $(obj).closest('tr').find('.matchID').val();
    var teamsname = $(obj).closest('tr').find('.teamsname').val();
    if(!confirm("Are You Sure Cancel Fancy?")){
      return false;
    }
    
    $.ajax({
      url: "{{ route('admin.sports.resultcancelcricketsession')}}",
      type: "post",
      dataType: 'json',
      data: {
          'matchID':matchID,
          'teamsname':teamsname,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
  //        showLoading();
      },
      complete:function(){
  //        hideLoading();
      },
      success: function(response){
        if(response.status == true){
          $(obj).closest('tr').remove();
          alert('Fancy Canceled successfully');  
        }
      },
    });
    
  }
  
  function saveResult(obj){
    var matchID = $(obj).closest('td').find('.matchID').val();
    var teamsname = $(obj).closest('td').find('.teamsname').val();
    var runtext = $(obj).closest('td').find('.resultrun').val();
    if(!confirm("Are You Sure "+runtext+" Run Result Declare ?")){
      return false;
    }
    
    $.ajax({
      url: "{{ route('admin.client.resultcricketsession')}}",
      type: "post",
      dataType: 'json',
      data: {
          'matchID':matchID,
          'teamsname':teamsname,
          'run':runtext,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
  //        showLoading();
      },
      complete:function(){
  //        hideLoading();
      },
      success: function(response){
        if(response.status == true){
          $(obj).closest('tr').remove();
          alert('Result Deaclear successfully');  
        }
      },
    });
    
  }
  getData();
  $( document ).ready(function() {
    setInterval(function(){ getData(); }, 9000);
  });
  
  $.noConflict();
  function getData(){
    $.ajax({
      url: '{{route("frontend.getdata",$matchID)}}',
      dataType: 'json',
      type: "get",
      success: function(data){
          setsession(data.session);
      }
    });
  }
  
  function setsession(data){
    $.each(data, function(i, item) {
      var team = item.RunnerName;
      team = team.replace(/\s/g , "_");
      team = team.replace(" " , "_");
      team = team.replace(')' , "_");
      team = team.replace('(' , "_");
      
      $("."+team).find('.layprice').text(item.LayPrice1);
      $("."+team).find('.laysize').text(item.LaySize1);

      $("."+team).find('.backprice').text(item.BackPrice1);
      $("."+team).find('.backsize').text(item.BackSize1);

    });
  }
</script>

@endpush
