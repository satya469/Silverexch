@extends('backend.layouts.app')

@section('title', app_name() . ' | Market Analysis')

@section('content')
<style>
    #home-events{
      background: #2f353a;
      padding: 8px;
    }
    #home-events li a{
      color: #fff;
    }
    .tabActive{
      display: block;
    }
    .hideActive{
      display: none;
    }
    .activeUL{
      background-color: var(--theme1-bg);
      color: var(--primary-color);
    }
    .row33 .col-33{
       display: inline-block;
       margin: 2px;
    }
    .sidebar-right{
        max-width: 33% !important;
    }
    .video_nav_tab .nav-item{
        font-size: 12px;
    }
    .tab_video{
        width:100%;
    }
</style>


<div class="row">
   <div class="col-md-8 featured-box-detail">
      <div class="coupon-card">
         <div class="game-heading"> <span class="card-header-title">Delhi Capitals v Rajasthan Royals</span><span class="card-header-title" style="float: right;">Oct 14, 2020 7:30 PM</span></div>
         <br>
         <div class="game-heading"> <span class="card-header-title">MATCH ODDS <a href="#" class=" m-r-5 game-rules-icon blinking" data-id="match"><span><i class="fa fa-info-circle float-right"></i></span></a></span> <span class="float-right m-r-10">Maximum Bet : <span id="maxbetlmt">10000</span></span><span class="float-right m-r-10">Minimum Bet : <span id="maxbetlmt">100</span></span></div>
         <div class="card-content">
            <div class="table-responsive m-b-10 main-market market-bf" data-marketid="1.167146463">
               <table class="table coupon-table table table-striped table-bordered m-t-10 ">
                  <thead>
                     <tr>
                        <th>Total Match: </th>
                        <th class="box-w1">&nbsp;</th>
                        <th class="box-w1">&nbsp;</th>
                        <th class="back box-w1">Back</th>
                        <th class="lay box-w1">Lay</th>
                        <th class="box-w1">&nbsp;</th>
                        <th class="box-w1">&nbsp;</th>
                     </tr>
                  </thead>
                  <tbody id="dyn_bind">
                     <tr class="bet-info ">
                        <td class="team-name nation">
                           <span><strong>Delhi Capitals</strong></span>
                           <p class="box-w4"><span class="float-right book" id="book_349" style="color: black;"></span> <span class="float-right profit" id="profit_349" style="color: black;"></span></p>
                           <p class="box-w4"><span class="float-left book" style="color: green;">3660.00</span><span class="float-left  profit" style="color: black;"></span></p>
                        </td>
                        <td class="box-w1 back-color" id="blockin1" style="background: rgb(178, 214, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.52</span>21  </button></td>
                        <td id="blockin2" class="box-w1 back-color" style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.53</span> 166 </button></td>
                        <td id="blockin3" class="box-w1 back-color" style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.54</span> 50.85 </button></td>
                        <td id="blockin4" class="box-w1 lay-color" style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">1.55</span>29.2</button></td>
                        <td id="blockin5" class="box-w1 lay-color" style="background: rgb(248, 187, 200) none repeat scroll 0% 0%; transition: all 1s ease 0s;"><button class="bet-sec lay"><span class="odd layprice">1.56</span>4.9</button></td>
                        <td id="blockin6" class="box-w1 lay-color" style="background: rgb(246, 205, 214) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">1.57</span>16.4</button></td>
                     </tr>
                     <tr class="bet-info ">
                        <td class="team-name nation" id="10301">
                           <span><strong>Rajasthan Royals</strong></span>
                           <p class="box-w4"><span class="float-right book" id="book_10301" style="color: black;"> </span> <span class="float-right profit" id="profit_10301" style="color: black;"></span></p>
                           <p class="box-w4"><span class="float-left book" style="color: red;">-4580.00</span> <span class="float-left  profit" style="color: black;"></span></p>
                        </td>
                        <td id="blockin7" class="box-w1 back-color" style="background: rgb(178, 214, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.76</span>3.6</button></td>
                        <td id="blockin8" class="box-w1 back-color" style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.78</span>2.8  </button></td>
                        <td id="blockin9" class="box-w1 back-color" style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.8</span>16.1  </button></td>
                        <td id="blockin10" class="box-w1 lay-color" style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">2.84</span>15.59</button></td>
                        <td id="blockin11" class="box-w1 lay-color" style="background: rgb(248, 187, 200) none repeat scroll 0% 0%; transition: all 1s ease 0s;"><button class="bet-sec lay"><span class="odd layprice">2.86</span>19.45</button></td>
                        <td id="blockin12" class="box-w1 lay-color" style="background: rgb(246, 205, 214) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">2.88</span>4.6</button></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div> 
         <br>
         <div class="game-heading"> <span class="card-header-title">Bookmaker Market  <a href="#" class=" m-r-5 game-rules-icon blinking" data-id="match"><span><i class="fa fa-info-circle float-right"></i></span></a></span> <span class="float-right m-r-10">Maximum Bet : <span id="maxbetlmt">10000</span></span><span class="float-right m-r-10">Minimum Bet : <span id="maxbetlmt">100</span></span></div>
         <div class="card-content">
            <div class="table-responsive m-b-10 main-market market-bf" data-marketid="1.167146463">
               <table class="table coupon-table table table-striped table-bordered m-t-10 ">
                  <thead>
                     <tr>
                        <th>Total Match: </th>
                        <th class="box-w1">&nbsp;</th>
                        <th class="box-w1">&nbsp;</th>
                        <th class="back box-w1">Back</th>
                        <th class="lay box-w1">Lay</th>
                        <th class="box-w1">&nbsp;</th>
                        <th class="box-w1">&nbsp;</th>
                     </tr>
                  </thead>
                  <tbody id="dyn_bind">
                     <tr class="bet-info ">
                        <td class="team-name nation">
                           <span><strong>Delhi Capitals</strong></span>
                           <p class="box-w4"><span class="float-right book" id="book_349" style="color: black;"></span> <span class="float-right profit" id="profit_349" style="color: black;"></span></p>
                           <p class="box-w4"><span class="float-left book" style="color: green;">3660.00</span><span class="float-left  profit" style="color: black;"></span></p>
                        </td>
                        <td class="box-w1 back-color" id="blockin1" style="background: rgb(178, 214, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.52</span>21  </button></td>
                        <td id="blockin2" class="box-w1 back-color" style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.53</span> 166 </button></td>
                        <td id="blockin3" class="box-w1 back-color" style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.54</span> 50.85 </button></td>
                        <td id="blockin4" class="box-w1 lay-color" style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">1.55</span>29.2</button></td>
                        <td id="blockin5" class="box-w1 lay-color" style="background: rgb(248, 187, 200) none repeat scroll 0% 0%; transition: all 1s ease 0s;"><button class="bet-sec lay"><span class="odd layprice">1.56</span>4.9</button></td>
                        <td id="blockin6" class="box-w1 lay-color" style="background: rgb(246, 205, 214) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">1.57</span>16.4</button></td>
                     </tr>
                     <tr class="bet-info ">
                        <td class="team-name nation" id="10301">
                           <span><strong>Rajasthan Royals</strong></span>
                           <p class="box-w4"><span class="float-right book" id="book_10301" style="color: black;"> </span> <span class="float-right profit" id="profit_10301" style="color: black;"></span></p>
                           <p class="box-w4"><span class="float-left book" style="color: red;">-4580.00</span> <span class="float-left  profit" style="color: black;"></span></p>
                        </td>
                        <td id="blockin7" class="box-w1 back-color" style="background: rgb(178, 214, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.76</span>3.6</button></td>
                        <td id="blockin8" class="box-w1 back-color" style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.78</span>2.8  </button></td>
                        <td id="blockin9" class="box-w1 back-color" style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.8</span>16.1  </button></td>
                        <td id="blockin10" class="box-w1 lay-color" style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">2.84</span>15.59</button></td>
                        <td id="blockin11" class="box-w1 lay-color" style="background: rgb(248, 187, 200) none repeat scroll 0% 0%; transition: all 1s ease 0s;"><button class="bet-sec lay"><span class="odd layprice">2.86</span>19.45</button></td>
                        <td id="blockin12" class="box-w1 lay-color" style="background: rgb(246, 205, 214) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">2.88</span>4.6</button></td>
                     </tr>
                  </tbody>
               </table>
            </div>    
         </div>
         
         <br>
         <div class="game-heading"> <span class="card-header-title">Session Market <a href="#" class=" m-r-5 game-rules-icon blinking" data-id="match"><span><i class="fa fa-info-circle float-right"></i></span></a></span> <span class="float-right m-r-10">Maximum Bet : <span id="maxbetlmt">10000</span></span><span class="float-right m-r-10">Minimum Bet : <span id="maxbetlmt">100</span></span></div>
         <div class="card-content">
            <div class="table-responsive m-b-10 main-market market-bf" data-marketid="1.167146463">
               <table class="table coupon-table table table-striped table-bordered m-t-10 ">
                  <thead>
                     <tr>
                        <th style="width:65%;">Total Match: </th>
                        <th class="lay box-w1">Lay</th>
                        <th class="back box-w1">Back</th>
                        <th class="box-w1" style="width:15%;">&nbsp;</th>
                     </tr>
                  </thead>
                  <tbody id="dyn_bind">
                     <tr class="bet-info ">
                        <td class="team-name nation" style="width:65%;">
                           <span><strong>Delhi Capitals</strong></span>
                        </td>
                        <td id="blockin4" class="box-w1 lay-color" style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">1.55</span>29.2</button></td>
                        <td id="blockin3" class="box-w1 back-color" style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">1.54</span> 50.85 </button></td>
                        <td id="box-w1" class="box-w1 " style="width:15%;"></td>
                     </tr>
                     <tr class="bet-info ">
                        <td class="team-name nation" style="width:65%;">
                           <span><strong>Rajasthan Royals</strong></span>
                        </td>
                        <td id="blockin10" class="box-w1 lay-color" style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;"><button class="bet-sec lay"><span class="odd layprice">2.84</span>15.59</button></td>
                        <td id="blockin9" class="box-w1 back-color" style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;"><button class="bet-sec back "> <span class="odd backprice">2.8</span>16.1  </button></td>
                        <td id="blockin12" style="width:15%;" class="box-w1">
                          
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>    
             
         </div>
      </div>
   </div>
   <div class="col-md-4 sidebar-right">
      <div class="card-header" data-toggle="collapse" data-target="#demo">
         <div class="row33">
            <div class="col-33">
               <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Bet Lock <span class="caret"></span></button>
               <ul class="dropdown-menu">
                  <li><a href="#">Lock</a></li>
                  <li><a href="#">Unlock</a></li>
                  <li><a href="#">Select user</a></li>
               </ul>
            </div>
            <div class="col-33">
               <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Fancy Lock</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <li><a href="#">Lock</a></li>
                     <li><a href="#">Unlock</a></li>
                     <li><a href="#">Select user</a></li>
                  </div>
               </div>
            </div>
            <div class="col-33"><button class="btn btn-primary">User Book</button></div>
            <div class="col-33"><button class="btn btn-primary">Bookmaker Book</button></div>
            <div class="col-33">
               <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bookmaker Lock</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                     <li><a href="#">Lock</a></li>
                     <li><a href="#">Unlock</a></li>
                     <li><a href="#">Select user</a></li>
                  </div>
               </div>
            </div>
         </div>
         <h6 class="card-title">Live Match <span class="float-right"><i class="fa fa-tv"></i> live stream started</span> </h6>
      </div>
      <div id="demo" class="collapse hide ">
         <ul class="nav nav-tabs video_nav_tab">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#video1">Channel 1</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#video2">Channel 2</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#video3">Channel 3</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#video4">Channel 4</a></li>
         </ul>
         <div class="tab-content">
            <div id="video1" class=" tab-pane active"><iframe class="tab_video" src="https://livetvline.com:8888/embed_player?urlServer=wss://livetvline.com:8443&amp;streamName=ch_125261&amp;mediaProviders=WebRTC,Flash,MSE,WSPlayer"></iframe></div>
            <div id="video2" class=" tab-pane fade"><iframe class="tab_video" src="https://livetvline.com:8888/embed_player?urlServer=wss://livetvline.com:8443&amp;streamName=ch_225262&amp;mediaProviders=WebRTC,Flash,MSE,WSPlayer"></iframe></div>
            <div id="video3" class=" tab-pane fade"><iframe class="tab_video" src="https://livetvline.com:8888/embed_player?urlServer=wss://livetvline.com:8443&amp;streamName=ch_325263&amp;mediaProviders=WebRTC,Flash,MSE,WSPlayer"></iframe></div>
            <div id="video4" class=" tab-pane fade"><iframe class="tab_video" src="https://livetvline.com:8888/embed_player?urlServer=wss://livetvline.com:8443&amp;streamName=ch_425264&amp;mediaProviders=WebRTC,Flash,MSE,WSPlayer"></iframe></div>
         </div>
      </div>
      <div class="card m-b-10 mt-3 place-bet ">
         <div class="card-header">
            <h6 class="card-title d-inline-block">Place Bet</h6>
            <a class="btn btn-secondary float-right change-value" id="cng_btn_val" href="#">Change Button Value</a>
         </div>
      </div>
      <div class="card m-b-10 place-bet">
         <div class="card-header">
            <h6 class="card-title d-inline-block">My Bet</h6>
         </div>
         <div class="table-responsive hide-box-click " style="padding-bottom: 4px; display: block;">
            <div>
               <ul class="nav nav-tabs">
                  <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Match</a></li>
               </ul>
               <div class="tab-content">
                  <div id="home" class="container tab-pane active">
                     <br>
                     <table class="table coupon-table">
                        <thead>
                           <tr>
                              <th style="text-align: center;"> User Name</th>
                              <th style="text-align: center;"> Team Name</th>
                              <th style="text-align: center;"> Odds</th>
                              <th style="text-align: center;"> Stake</th>
                              <th style="text-align: center;"> Action </th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Match 1st over run(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 6  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Match 1st over run(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 7  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.84  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.80  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.80  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.79  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.74  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.75  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 169  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 169  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(248, 187, 200) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.73  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(248, 187, 200) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> sultan1  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.73  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.81  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Match 1st over run(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 6  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 165  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Only 11 over run DC  </td>
                              <td style="text-align: center;"> 8  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(248, 187, 200) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.74  </td>
                              <td style="text-align: center;"> 10000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Only 13 over run DC  </td>
                              <td style="text-align: center;"> 9  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.73  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.70  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.72  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.67  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.69  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.71  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(248, 187, 200) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.73  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.72  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(248, 187, 200) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Rajasthan Royals  </td>
                              <td style="text-align: center;"> 2.42  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Only 16 over run DC  </td>
                              <td style="text-align: center;"> 9  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 175  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 175  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 175  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.59  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(146, 201, 240) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.62  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.67  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(248, 187, 200) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Delhi Capitals  </td>
                              <td style="text-align: center;"> 1.68  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Only 20 over run DC  </td>
                              <td style="text-align: center;"> 12  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> Only 20 over run DC  </td>
                              <td style="text-align: center;"> 12  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 164  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: green;" class="fa fa-undo"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 1st 3 wkt runs RR  </td>
                              <td style="text-align: center;"> 109  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi  </td>
                              <td style="text-align: center;"> 1st 3 wkt runs RR  </td>
                              <td style="text-align: center;"> 109  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi@1  </td>
                              <td style="text-align: center;"> Match 1st over run(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 5  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi@1  </td>
                              <td style="text-align: center;"> Only 2 over run DC  </td>
                              <td style="text-align: center;"> 6  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi@1  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 163  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(114, 187, 239) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi@1  </td>
                              <td style="text-align: center;"> 20 over runs DC(DC vs RR)adv  </td>
                              <td style="text-align: center;"> 165  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                           <tr style="background: rgb(250, 169, 186) none repeat scroll 0% 0%;">
                              <td style="text-align: center;"> karthi@1  </td>
                              <td style="text-align: center;"> Only 11 over run DC  </td>
                              <td style="text-align: center;"> 8  </td>
                              <td style="text-align: center;"> 1000  </td>
                              <td style="text-align: center;"> <i style="color: red;" class="fa fa-trash"></i> </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div id="menu1" class="container tab-pane ">
                     <br>
                     <table class="table coupon-table">
                        <thead>
                           <tr>
                              <th style="text-align: center;"> User Name</th>
                              <th style="text-align: center;"> Team Name</th>
                              <th style="text-align: center;"> Odds</th>
                              <th style="text-align: center;"> Stake</th>
                              <th style="text-align: center;"> Action </th>
                           </tr>
                        </thead>
                        <tbody></tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <form method="post" id="frm_placebet">
         <table class="table table-borderedless place-bet">
            <tbody><br></tbody>
         </table>
         <div class="col-md-12"><button class="btn btn-sm btn-danger float-left" type="button">Reset</button><button class="btn btn-sm btn-success float-right" type="submit" id="submit_btn">Submit</button><input id="Odds1" type="hidden" value=""><input id="Odds2" type="hidden" value=""><input id="team_id1" type="hidden" value=""></div>
      </form>
   </div>
</div>




@endsection


@push('after-scripts')
<!--@include('backend.reloadJS')-->
<script type="text/javascript">
 

</script>

@endpush
