@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')


<div class="container-fluid container-fluid-5">
<div class="row" style="margin-left: 0px;margin-right: 0px;">
  @include('frontend.game-list.leftSide')
  <!----> 
  
  <div class="col-md-10 featured-box load game-page">
      <div class="row row5">
        <div class="col-md-9 featured-box-detail sports-wrapper m-b-10">
          <!----> <!----> 
          @include('frontend.game-list.game.mybetHeader')
          @include('frontend.game-list.game.betShowmobileView')
          <div class="game-heading mobileodds">
              <span class="card-header-title">{{$sports->match_name}}</span> 
              <span class="float-right ">
                  <span style="padding-right: 10px;">Round ID : <span class="roundID"></span></span>
                  <input type="hidden" id="roundID" value="">
                  @if(!empty($sports->odd_min_limit))
                    <span style="padding-right: 10px;">Min : <span>{{$sports->odd_min_limit}}</span></span>
                  @endif
                  @if(!empty($sports->odd_max_limit))    
                    <span> Max : <span>{{$sports->odd_max_limit}}</span></span>
                  @endif
              </span>
          </div>
          <div class="markets mobileodds">
              
            <!-- GAME VIDEO PLAY -->
            
            <script src="https://demo.nanocosmos.de/nanoplayer/api/release/nanoplayer.4.min.js?20200302"></script>
            <div class="casinoVideo" style="">
              <div id="playerDiv"></div>
            </div>
            <!--END GAME VIDEO PLAY-->
            <div class="cardsDiv">
                <div class="Team0">
                    <b>Player A</b><br>
                    <span class="card1"></span>
                    <span class="card2"></span>
                    <span class="card3"></span>
                </div>
                <div class="Team1">
                    <b>Player B</b><br>
                  <span class="card1"></span>
                  <span class="card2"></span>
                  <span class="card3"></span>
                  
                </div>
            </div>
            <div  class="timerClass" style="display:none;"><label id="time">00:00</label></div>
            <div style="clear:fix;"></div>
            <div class="main-market  rootClass">
              <div class="market-title mt-1">
                MATCH_ODDS
              </div>
                <input type="hidden" class="MatchOdd" id="betType" value="ODDS">
              <div class="table-header">
                 <div class="float-left country-name box-4 mbox-4 min-max"><b></b></div>
                <div class="box-1 float-left not-active mobileOddsHide"></div>
                <div class="box-1 float-left not-active mobileOddsHide"></div>
                <div class="back box-1 float-left text-center not-active font-size-14 mbox-1"><b>BACK</b></div>
                <div class="lay box-1 float-left text-center not-active font-size-14 mbox-1"><b>LAY</b></div>
                <div class="box-1 float-left not-active mobileOddsHide"></div>
                <div class="box-1 float-left not-active mobileOddsHide"></div>
              </div>
              <div data-title="OPEN" class="table-body  ODDS">
                <div data-title="ACTIVE" class="table-row oddsTot oddssteam0">
                  <div class="float-left country-name box-4 mbox-4">
                      <span class="oddteamname1 team-name0"><b class="teamName"></b></span> 
                    <p>
                        <span class="float-left matchValClear matchValClearProfit" style="color: black;">0</span> 
                        <span class="float-right matchValClearProfit" style="display: none; color: black;">0</span>
                    </p>
                  </div>
                  <div class="box-1 back2 float-left back-2 text-center mobileOddsHide">
                      <span class="odd d-block back3t"></span> 
                      <span class="oddk d-block back3k"></span>
                  </div>
                  <div class="box-1 back1 float-left back-1 text-center mobileOddsHide">
                      <span class="odd d-block back2t"></span> 
                      <span class="oddk d-block back2k"></span>
                  </div>
                  <div class="box-1 back float-left back lock text-center font-size-14 mbox-1">
                      <span class="odd d-block back1t"></span> 
                      <span class="oddk d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center font-size-14 mbox-1">
                      <span class="odd d-block lay1t"></span> 
                      <span class="oddk d-block lay1k"></span>
                  </div>
                  <div class="box-1 lay1 float-left text-center mobileOddsHide">
                      <span class="odd d-block lay2t"></span> 
                      <span class="oddk d-block lay2k"></span>
                  </div>
                  <div class="box-1 lay2 float-left text-center mobileOddsHide">
                      <span class="odd d-block lay3t"></span> 
                      <span class="oddk d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row oddsTot oddssteam1">
                  <div class="float-left country-name box-4 mbox-4">
                    <span class="oddteamname2 team-name1"><b class="teamName"></b></span> 
                    <p>
                        <span class="float-left matchValClear matchValClearProfit" style="color: black;">0</span> 
                        <span class="float-right matchValClearProfit" style="display: none; color: black;">0</span>
                    </p>
                  </div>
                  <div class="box-1 back2 float-left back-2 text-center mobileOddsHide">
                      <span class="odd d-block back3t"></span> 
                      <span class="oddk d-block back3k"></span>
                  </div>
                  <div class="box-1 back1 float-left back-1 text-center mobileOddsHide">
                      <span class="odd d-block back2t"></span> 
                      <span class="oddk d-block back2k"></span>
                  </div>
                  <div class="box-1 back float-left back lock text-center font-size-14 mbox-1">
                      <span class="odd d-block back1t"></span> 
                      <span class="oddk d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center font-size-14 mbox-1">
                      <span class="odd d-block lay1t"></span> 
                      <span class="oddk d-block lay1k"></span>
                  </div>
                  <div class="box-1 lay1 float-left text-center mobileOddsHide">
                      <span class="odd d-block lay2t"></span> 
                      <span class="oddk d-block lay2k"></span>
                  </div>
                  <div class="box-1 lay2 float-left text-center mobileOddsHide">
                      <span class="odd d-block lay3t"></span> 
                      <span class="oddk d-block lay2k"></span>
                  </div>
                </div>
              </div>
              <div>
                <!---->
              </div>
            </div>
            
            <div class="main-market  rootClass">
              <div class="market-title mt-1">LAST RESULT</div>
              <div style="float: right;" class="table-header resultAdd pull-right text-right">
                
              </div>
            </div>
          </div>
        </div>
       @include('frontend.game-list.game.rightSide')
      </div>
    </div>
  </div>
</div>
 @include('frontend.game-list.game.popupHtml')

@endsection
<script src="{{asset('new/sportJS/gameComman.js')}}"></script>
@push('after-styles')
@include('frontend.game-list.game.gameCss')
@endpush

@push('after-scripts')
@include('frontend.game-list.js.gameCommonJS')

<script>
   var player;
        var config={"source":{"h5live": {
            "rtmp": {
                "url": "rtmp://bintu-play.nanocosmos.de/play",
                "streamname": "zWo7p-Yrtea","type":"live"
            },
            "server": {
                "websocket": "wss://bintu-h5live.nanocosmos.de:443/h5live/stream.mp4",
                "hls": "https://bintu-h5live.nanocosmos.de:443/h5live/http/playlist.m3u8",
                "progressive": "https://bintu-h5live.nanocosmos.de:443/h5live/http/stream.mp4"
            }}},"style":{width:'100%',height:"100%",aspectratio:'16/9',controls:false,scaling:'letterbox'},
            "playback": {
        "autoplay": true,
        "automute": true,
        "muted": false
    }
        };
        player = new NanoPlayer("playerDiv");
        player.setup(config).then(function (config) {
            console.log("setup success");
            console.log("config: " + JSON.stringify(config, undefined, 4));
        }, function (error) {
            alert(error.message);
        });
</script>

<script>
  $( document ).ready(function() {
    setInterval(function(){ getData(); }, 9000);
  });
//  $( document ).ready(function() {
//    setInterval(function(){  getBetsList(); }, 10000);
//  });
  $( document ).ready(function() {
    var isMobile = false; //initiate as false
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        isMobile = true;
        $('#sidebar-right').remove();
    }else{
      $('.mobilebetOdds').remove();
    }
    $('.box-1').on('click',function(){
      var betType = $(this).closest('.rootClass').find('#betType').val();
      var amount = $(this).find('.odd').text();
      if(parseFloat($.trim(amount))<= 0 || $.trim(amount) == ''){
          return false
      }
      if($(this).hasClass('back')){
            betPosition = 'back';
        }else if($(this).hasClass('back1')){
            betPosition = 'back1';
        }else if($(this).hasClass('back2')){
            betPosition = 'back2';
        }else if($(this).hasClass('lay')){
            betPosition = 'lay';
        }else if($(this).hasClass('lay1')){
            betPosition = 'lay1';
        }else if($(this).hasClass('lay2')){
            betPosition = 'lay2';
        }
        $('#betPosition').val(betPosition);
      if(isMobile){
        $('#showBet').show();
        $('#myModalBetView').modal('show');
        
        var html = '';
        var i = 0;
        $('.oddsTot').each(function(){
          var teamname = $(this).find('.teamName').text();
          var matchValClear = $(this).find('.matchValClear').text();
          if(matchValClear == ''){
            matchValClear = 0;
          }
          var color = "green";
          if(parseInt(matchValClear) < 0){
            color = 'red';
          }
          html +='<tr class="oddstbl'+i+'">';
            html +='<td style="text-align:left;" class="tname">'+teamname+'</td>';
            html +='<td style="text-align:center;color:'+color+'">'+matchValClear+'</td>';
            html +='<td style="text-align:right;" class="profitLoss"></td>';
          html +='</tr>';
          i++;
        });
        $('.showbetTot').html(html);
      }
      $('.rootClass').find('.country-name .float-right ').text('');
      $('#bet-profit').text('');
      $('#betAmount').val('');
//      $('.box-1').css('border','1px solid #fff');
//      $(this).css('border','2px solid #000');
      
      var amount = $(this).find('.odd').text();
      var amountK = $(this).find('.oddk').text();
      var countryName = $(this).closest('.table-row').find('.teamName').text();
        
      $('.amountint').val(amount);
      $('#betOddk').val(amountK);
      $('#teamNameBet').text(countryName);
      $('#betTypeAdd').val(betType);

      if(isMobile){
        $('.modal-body').removeClass('back-color');
        $('.modal-body').removeClass('lay-color');
      }else{
        $('#showBet').removeClass('back-color');
        $('#showBet').removeClass('lay-color');
      }  
      if($(this).hasClass("back") || $(this).hasClass("back1") || $(this).hasClass("back2")){
        $('#showBet').addClass('back-color');
        $('#betSide').val('back');
        if(isMobile){
          $('.modal-body').addClass('back-color');
        }
      }else{
        $('#showBet').addClass('lay-color');
        $('#betSide').val('lay');
        if(isMobile){
          $('.modal-body').addClass('lay-color');
        }
      }
      if(!$("#showBet").hasClass("show")){
        $('#showBet').addClass('show');
      }
    });
      
    $('.value-buttons').find('button').on('click',function(){
      var amt = $(this).attr('data-bet');
      $('#betAmount').val(amt);
      betODDCalculation(amt);
    });
      
    $('#betAmount').on('keyup',function(){
      var amt = $(this).val();
      betODDCalculation(amt);
    });
  });
   getData();
  function getData(){
   
    $.ajax({
      url: '{{ route("frontend.getcasinoData")}}',
      dataType: 'json',
      type: "POST",
      cache: false,
      async: false, 
      data : "gameName=TeenPati20&sportID={{$sports->id}}&_token={{csrf_token()}}",
      success: function(data){
        setDetails(data.detail,'TeenPati20');
        setodd(data.runner,'TeenPati20');
        setResult(data.result,'TeenPati20');
       getBetsList();
      }
    });
  }
</script>
@endpush