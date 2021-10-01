@extends('backend.layouts.appReport')

@section('title', app_name() )

@section('content')

<style>
    .data-table table td a{
      background: none;
      color:#007bff;
    }
    .header-title{
      padding: 10px;
      background: var(--theme2-bg85);
      color: #fff;
    }
</style>
<div class="row">
  <div class="col-md-12 main-container">
    <div class="listing-grid">
      <div class="detail-row">
        <h2 class="d-inline-block">Manage Soccer Fancy List</h2>
      </div>   
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <!--<table style="width:80%;" class="table coupon-table table table-striped table-bordered m-t-10">-->
          <?php 
          
            if(!isset($dataArr) || (isset($dataArr) && count($dataArr) == 0) ){
              echo "<div class='alert alert-info'>Record not available</div>";
            }
          ?>  
          <div class='col-md-8'> 
          
        @if(isset($dataArr['session']))
          @foreach($dataArr['session'] as $key=>$session)    
              
          <div class="header-title {{$session['TITLE']}}" style="background:var(--theme2-bg85);">
               {{$session['TITLE']}}
          </div>    
          <table class="table coupon-table table table-striped table-bordered m-t-10 {{$session['TITLE']}}">
            <tbody>
              <tr role="row" class="odd">
                <td>Cancel Match <input type='checkbox' data-match="{{$sports[0]->match_id}}" data-side="{{$session['TITLE']}}" value="TIE" class="resultDeclear"></td> 
                <td>Result Declare</td> 
                <td class="">
                </td>
                <td class="">
                </td>
                <td class="box-w1 BACK back-color fb_td">
                    <button class="bet-sec back">
                        <span class="odd backprice">BACK</span>
                    </button>
                </td>
                <td class="box-w1 LAY lay-color fb_td">
                    <button class="bet-sec lay">
                        <span class="odd layprice">LAY</span>
                    </button>
                </td>
                <td class="">
                </td>
                <td class="">
                </td>
                
              </tr>
              
              @if(isset($session['TEAMNAME']))
                @foreach($session['TEAMNAME'] as $tkey=>$tVal) 
                  <tr role="row" class="odd OVER_UNDER_{{$tkey}}">
                    <td class='teamName'>{{$tVal}}</td>  
                    <td class='teamName'><input type='checkbox' data-match="{{$sports[0]->match_id}}" data-side="{{$session['TITLE']}}" value="{{$tVal}}" class="resultDeclear"> </td> 
                    <td class="box-w1 BACK back-color fb_td">
                        <button class="bet-sec back">
                            <span class="odd back3t">0</span>
                            <span class="odd back3k">0</span>
                        </button>
                    </td>
                    <td class="box-w1 BACK back-color fb_td">
                        <button class="bet-sec back">
                            <span class="odd back2t">0</span>
                            <span class="odd back2k">0</span>
                        </button>
                    </td>
                    <td class="box-w1 BACK back-color fb_td">
                        <button class="bet-sec back">
                            <span class="odd back1t">0</span>
                            <span class="odd back1k">0</span>
                        </button>
                    </td>
                    <td class="box-w1 LAY lay-color fb_td">
                        <button class="bet-sec lay">
                            <span class="odd lay1t">0</span>
                             <span class="odd lay1k">0</span>
                        </button>
                    </td>
                    <td class="box-w1 LAY lay-color fb_td">
                        <button class="bet-sec lay">
                            <span class="odd lay2t">0</span>
                             <span class="odd lay2k">0</span>
                        </button>
                    </td>
                    <td class="box-w1 LAY lay-color fb_td">
                        <button class="bet-sec lay">
                            <span class="odd lay3t">0</span>
                             <span class="odd lay3k">0</span>
                        </button>
                    </td>

                  </tr>
                @endforeach
              @endif  
              
            </tbody>
          </table><br><br>
        @endforeach
            @endif
         </div>     
         </div>
      </div>
    </div>
  </div>
</div>


@endsection


@push('after-scripts')
<script type="text/javascript">
  getData();
  $( document ).ready(function() {
    setInterval(function(){ getData(); }, 10000);
  });
  $('.resultDeclear').on('click',function(){
    if($(this).prop('checked') == true){
      if(confirm("Are you Sure to win "+$(this).val())){
        var teamName = $(this).val();
        var matchID = $(this).attr("data-match");
        var betSide = $(this).attr("data-side");
        
        $.ajax({
          url: '{{route("admin.sports.soccersessionwinner")}}',
          dataType: 'json',
          type: "post",
          data: {
            'matchID':matchID,
            'winnerTeam':teamName,
            'betSide':betSide,
            '_token': "{{ csrf_token() }}",
          },
          success: function(data){
            if(data.status == true){
              $('.'+betSide).remove();
            }
            alert(data.message);
          }
        });
      }else{
        $(this).prop('checked', false);
      }
    }
  });
  function getData(){
    $.ajax({
      url: '{{route("frontend.getdatasoccer",$sports[0]->match_id)}}',
      dataType: 'json',
      type: "get",
      success: function(data){
        setbookmaker(data.session);
      }
    });
  }
  function setbookmaker(data){
    var i = 0;
    $.each(data, function(j, item) {
      var ret = item.RunnerName.split(" ");
      var text = ret[1].replace('.','');
      
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back1t').text(item.BackPrice1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').text(item.BackPrice2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').text(item.BackPrice3);

      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back1k').text(item.BackSize1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2k').text(item.BackSize2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3k').text(item.BackSize3);

      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay1t').text(item.LayPrice1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').text(item.LayPrice2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').text(item.LayPrice3);

      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay1k').text(item.LaySize1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2k').text(item.LaySize2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3k').text(item.LaySize3);

      
      
      i = parseInt(i)+parseInt(1);
      if(parseInt(i) == 2){
        i = 0;
      }
    });
  }
    
  
</script>


@endpush
