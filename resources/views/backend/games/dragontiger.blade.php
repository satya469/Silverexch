@extends('backend.layouts.app')

@section('title', app_name())

@section('content')
<div class="row">
   <div class="col-md-8 featured-box-detail">
      <div class="coupon-card">
         <div class="game-heading">
             <span class="card-header-title">
                 <?= $sports->match_name ?>
             </span>
             <span class="card-header-title" style="float: right;">
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
             </span>
         </div>

          <script src="https://demo.nanocosmos.de/nanoplayer/api/release/nanoplayer.4.min.js?20200302"></script>
            <div class="casinoVideo">
              <div id="playerDiv"></div>
              <iframe src="http://176.58.120.211/diamond_teen_patti_tv/20_20_dragon_tiger.html" height="100%" width="100%"></iframe>
            </div>
            <!--END GAME VIDEO PLAY-->
            <div class="cardsDiv">
                <div class="Team0">
                    <b>Dragon</b><br>
                    <span class="card1"></span>
                </div>
                <div class="Team1">
                    <b>Tiger</b><br>
                    <span class="card1"></span>
                </div>
            </div>
            <div  class="timerClass" style="display:none;"><label id="time">00:00</label></div>

            <br>
          <div class="game-heading">
             <span class="card-header-title">MATCH ODDS</span>
          </div>
          <div class="card-content">
            <div class="table-header">
                <div class="float-left country-name box-4 min-max"><b></b></div>
                <div class="box-1 float-left"></div>
                <div class="box-1 float-left"></div>
                <div class="back box-1 float-left text-center"><b>BACK</b></div>
                <div class="lay box-1 float-left text-center"><b>LAY</b></div>
                <div class="box-1 float-left"></div>
                <div class="box-1 float-left"></div>
              </div>
              <div data-title="OPEN" class="table-body  ODDS">
                <div data-title="ACTIVE" class="table-row oddsTot oddssteam0">
                  <div class="float-left country-name box-4">
                      <span class="oddteamname1 team-name0"><b class="teamName"></b></span>
                    <p>
                        <span class="float-left matchValClear" style="color: black;">0</span>
                        <span class="float-right matchValClear" style="display: none; color: black;">0</span>
                    </p>
                  </div>
                  <div class="box-1 back2 float-left back-2 text-center">
                      <span class="odd d-block back3t"></span>
                      <span class="oddk d-block back3k"></span>
                  </div>
                  <div class="box-1 back1 float-left back-1 text-center">
                      <span class="odd d-block back2t"></span>
                      <span class="oddk d-block back2k"></span>
                  </div>
                  <div class="box-1 back float-left back lock text-center">
                      <span class="odd d-block back1t"></span>
                      <span class="oddk d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center">
                      <span class="odd d-block lay1t"></span>
                      <span class="oddk d-block lay1k"></span>
                  </div>
                  <div class="box-1 lay1 float-left text-center">
                      <span class="odd d-block lay2t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                  <div class="box-1 lay2 float-left text-center">
                      <span class="odd d-block lay3t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row oddsTot oddssteam1">
                  <div class="float-left country-name box-4">
                    <span class="oddteamname2 team-name1"><b class="teamName"></b></span>
                    <p>
                        <span class="float-left matchValClear" style="color: black;">0</span>
                        <span class="float-right matchValClear" style="display: none; color: black;">0</span>
                    </p>
                  </div>
                  <div class="box-1 back2 float-left back-2 text-center">
                      <span class="odd d-block back3t"></span>
                      <span class="oddk d-block back3k"></span>
                  </div>
                  <div class="box-1 back1 float-left back-1 text-center">
                      <span class="odd d-block back2t"></span>
                      <span class="oddk d-block back2k"></span>
                  </div>
                  <div class="box-1 back float-left back lock text-center">
                      <span class="odd d-block back1t"></span>
                      <span class="oddk d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center">
                      <span class="odd d-block lay1t"></span>
                      <span class="oddk d-block lay1k"></span>
                  </div>
                  <div class="box-1 lay1 float-left text-center">
                      <span class="odd d-block lay2t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                  <div class="box-1 lay2 float-left text-center">
                      <span class="odd d-block lay3t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                </div>
                  <div data-title="ACTIVE" class="table-row oddsTot oddssteam2">
                  <div class="float-left country-name box-4">
                    <span class="oddteamname2 team-name2"><b class="teamName"></b></span>
                    <p>
                        <span class="float-left matchValClear" style="color: black;">0</span>
                        <span class="float-right matchValClear" style="display: none; color: black;">0</span>
                    </p>
                  </div>
                  <div class="box-1 back2 float-left back-2 text-center">
                      <span class="odd d-block back3t"></span>
                      <span class="oddk d-block back3k"></span>
                  </div>
                  <div class="box-1 back1 float-left back-1 text-center">
                      <span class="odd d-block back2t"></span>
                      <span class="oddk d-block back2k"></span>
                  </div>
                  <div class="box-1 back float-left back lock text-center">
                      <span class="odd d-block back1t"></span>
                      <span class="oddk d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center">
                      <span class="odd d-block lay1t"></span>
                      <span class="oddk d-block lay1k"></span>
                  </div>
                  <div class="box-1 lay1 float-left text-center">
                      <span class="odd d-block lay2t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                  <div class="box-1 lay2 float-left text-center">
                      <span class="odd d-block lay3t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row oddsTot oddssteam3">
                  <div class="float-left country-name box-4">
                    <span class="oddteamname3 team-name3"><b class="teamName"></b></span>
                    <p>
                        <span class="float-left matchValClear" style="color: black;">0</span>
                        <span class="float-right matchValClear" style="display: none; color: black;">0</span>
                    </p>
                  </div>
                  <div class="box-1 back2 float-left back-2 text-center">
                      <span class="odd d-block back3t"></span>
                      <span class="oddk d-block back3k"></span>
                  </div>
                  <div class="box-1 back1 float-left back-1 text-center">
                      <span class="odd d-block back2t"></span>
                      <span class="oddk d-block back2k"></span>
                  </div>
                  <div class="box-1 back float-left back lock text-center">
                      <span class="odd d-block back1t"></span>
                      <span class="oddk d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center">
                      <span class="odd d-block lay1t"></span>
                      <span class="oddk d-block lay1k"></span>
                  </div>
                  <div class="box-1 lay1 float-left text-center">
                      <span class="odd d-block lay2t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                  <div class="box-1 lay2 float-left text-center">
                      <span class="odd d-block lay3t"></span>
                      <span class="oddk d-block lay2k"></span>
                  </div>
                </div>
              </div>
         </div>
         <br>
         <div class="game-heading">
            <span class="card-header-title">LAST RESULT</span>
        </div>
        <div class="card-content">
          <div class="table-responsive m-b-10 main-market market-bf" data-marketid="1.167146463">
              <div class="resultAdd pull-right" style="text-align: right;float: right;margin: 5px;" ></div>
          </div>
        </div>
      </div>
   </div>
  @include('backend.games.game.rightSide')
</div>
@endsection

@push('after-styles')
@include('backend.games.game.gameCss')
@endpush

@push('after-scripts')
@include('backend.games.js.gameCommonJS')
<script>
    var player;
        var config={"source":{"h5live": {
            "rtmp": {
                "url": "rtmp://bintu-play.nanocosmos.de/play",
                "streamname": "zWo7p-AZovR","type":"live"
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
    setInterval(function(){ getData(); }, 4000);
  });
  getData();
  function getData(){
    $.ajax({
      url: '{{ route("frontend.getcasinoData")}}',
      dataType: 'json',
      type: "POST",
      cache: false,
      async: false,
      data : "gameName=DragOnTiger&sportID={{$sports->id}}&_token={{csrf_token()}}",
      success: function(data){
       setDetails(data,'DragOnTiger');
        setodd(data.runner,'DragOnTiger');
        setResult(data.result,'DragOnTiger');
        getBetsList();
      }
    });
  }
</script>
@endpush
