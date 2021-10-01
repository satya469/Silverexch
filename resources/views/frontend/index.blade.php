@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 featured-box">
    <div>
      <!----> 
      <div class="pb-4">
        <div class="tab-content">
          <div class="tab-pane active">
            <div class="coupon-card coupon-card-first">
              <div class="card-content">
                <table class="table coupon-table">
                  <thead>
                    <tr>
                      <th style="width: 63%;">Game</th>
                      <th colspan="2">1</th>
                      <th colspan="2">X</th>
                      <th colspan="2">2</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="game-name">
                          <a href="/game-detail/2009081426" class="text-dark">Testing 1 vs Testing 2 / Sep  8 2020  9:00PM (IST)</a>
                        </div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                          <i class="fas fa-tv v-m icon-tv"></i>
                          </span> 
                          <span class="game-icon">
                          <img src="/front/img/icons/ic_fancy.png" class="fancy-icon">
                          </span> 
                          <span class="game-icon">
                          <img src="/front/img/icons/ic_bm.png" class="bookmaker-icon">
                          </span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td>
                        <button class="back">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="back">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="back">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay">
                        <span class="odd">-</span>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name">
                          <a href="/casino/cricketv/431005246" class="text-dark">TKR XI Vs GAW XI / Sep 29 2020 12:00AM (IST)</a>
                        </div>
                        <div class="game-icons">
                          <span class="game-icon">
                          <span class="active"></span>
                          </span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                          <img src="/front/img/icons/ic_fancy.png" class="fancy-icon">
                          </span> 
                          <span class="game-icon">
                          <img src="/front/img/icons/ic_bm.png" class="bookmaker-icon">
                          </span> 
                          <span class="game-icon">
                          <img src="/front/img/icons/ic_vir.png" class="ic-card">
                          </span>
                        </div>
                      </td>
                      <td>
                        <button class="back">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="back">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="back">
                        <span class="odd">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay">
                        <span class="odd">-</span>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name">
                          <a href="/casino/cricketv/332006077" class="text-dark">Perth Scorchers XI Vs Adelaide Strikers XI / Sep 29 2020  1:30AM (IST)</a>
                        </div>
                        <div class="game-icons">
                          <span class="game-icon">
                          <span class="active"></span>
                          </span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> <span class="game-icon"><img src="/front/img/icons/ic_bm.png" class="bookmaker-icon"></span> <span class="game-icon"><img src="/front/img/icons/ic_vir.png" class="ic-card"></span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/casino/cricketv/431005247" class="text-dark">TKR XI Vs BT XI / Sep 29 2020  2:30AM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon"><span class="active"></span></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_vir.png" class="ic-card"></span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/casino/cricketv/332006078" class="text-dark">Sydney Sixers XI Vs Melbourne Renegades XI / Sep 29 2020  3:00AM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_vir.png" class="ic-card"></span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30029359" class="text-dark">Delhi Capitals v Sunrisers Hyderabad / Sep 29 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> <span class="game-icon"><img src="/front/img/icons/ic_bm.png" class="bookmaker-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.86</span></button></td>
                      <td><button class="lay"><span class="odd">1.88</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">2.12</span></button></td>
                      <td><button class="lay"><span class="odd">2.16</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30038726" class="text-dark">Australia Women v New Zealand Women (3rd T20) / Sep 30 2020  9:15AM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> <span class="game-icon"><img src="/front/img/icons/ic_bm.png" class="bookmaker-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.25</span></button></td>
                      <td><button class="lay"><span class="odd">1.28</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">4.6</span></button></td>
                      <td><button class="lay"><span class="odd">5</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30029364" class="text-dark">Rajasthan Royals v Kolkata Knight Riders / Sep 30 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> <span class="game-icon"><img src="/front/img/icons/ic_bm.png" class="bookmaker-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">2.08</span></button></td>
                      <td><button class="lay"><span class="odd">2.18</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">1.85</span></button></td>
                      <td><button class="lay"><span class="odd">1.93</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30026482" class="text-dark">Surrey v Kent / Oct  1 2020  5:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.8</span></button></td>
                      <td><button class="lay"><span class="odd">1.87</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">2.14</span></button></td>
                      <td><button class="lay"><span class="odd">2.26</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30031644" class="text-dark">Kings XI Punjab v Mumbai Indians / Oct  1 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">2.28</span></button></td>
                      <td><button class="lay"><span class="odd">2.4</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">1.71</span></button></td>
                      <td><button class="lay"><span class="odd">1.77</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30026481" class="text-dark">Nottinghamshire v Leicestershire / Oct  1 2020 10:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.4</span></button></td>
                      <td><button class="lay"><span class="odd">1.47</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">3.15</span></button></td>
                      <td><button class="lay"><span class="odd">3.5</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30035278" class="text-dark">Chennai Super Kings v Sunrisers Hyderabad / Oct  2 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.81</span></button></td>
                      <td><button class="lay"><span class="odd">1.92</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">2.08</span></button></td>
                      <td><button class="lay"><span class="odd">2.22</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30035305" class="text-dark">Royal Challengers Bangalore v Rajasthan Royals / Oct  3 2020  3:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.89</span></button></td>
                      <td><button class="lay"><span class="odd">2.06</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">1.95</span></button></td>
                      <td><button class="lay"><span class="odd">2.14</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30035318" class="text-dark">Delhi Capitals v Kolkata Knight Riders / Oct  3 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.75</span></button></td>
                      <td><button class="lay"><span class="odd">1.87</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">2.14</span></button></td>
                      <td><button class="lay"><span class="odd">2.34</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30035330" class="text-dark">Mumbai Indians v Sunrisers Hyderabad / Oct  4 2020  3:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">1.74</span></button></td>
                      <td><button class="lay"><span class="odd">1.8</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">2.26</span></button></td>
                      <td><button class="lay"><span class="odd">2.36</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30035332" class="text-dark">Kings XI Punjab v Chennai Super Kings / Oct  4 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon"><img src="/front/img/icons/ic_fancy.png" class="fancy-icon"></span> 
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">2.04</span></button></td>
                      <td><button class="lay"><span class="odd">2.22</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">1.83</span></button></td>
                      <td><button class="lay"><span class="odd">1.97</span></button></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="game-name"><a href="/game-detail/30039288" class="text-dark">Royal Challengers Bangalore v Delhi Capitals / Oct  5 2020  7:30PM (IST)</a></div>
                        <div class="game-icons">
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                          <span class="game-icon">
                            <!---->
                          </span>
                        </div>
                      </td>
                      <td><button class="back"><span class="odd">2.02</span></button></td>
                      <td><button class="lay"><span class="odd">2.22</span></button></td>
                      <td><button class="back"><span class="odd">-</span></button></td>
                      <td><button class="lay"><span class="odd">-</span></button></td>
                      <td><button class="back"><span class="odd">1.83</span></button></td>
                      <td><button class="lay"><span class="odd">1.97</span></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="home-products-container">
        <div class="row row5">
          <div class="col-md-12">
            <a href="/casino/cricketv3" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/cricketv3.jpg" class="img-fluid"> 
                <div class="casino-name">5Five Cricket</div>
                <div class="new-launch-casino"><img src="//img/offer-patch.png"></div>
              </div>
            </a>
            <a href="/casino/ab2" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/andar-bahar2.jpg" class="img-fluid"> 
                <div class="casino-name">Andar Bahar 2</div>
              </div>
            </a>
            <a href="/casino/dt202" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/dt202.jpg" class="img-fluid"> 
                <div class="casino-name">20-20 Dragon Tiger 2</div>
              </div>
            </a>
            <a href="/casino/baccarat2" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/baccarat2.jpg" class="img-fluid"> 
                <div class="casino-name">Baccarat 2</div>
              </div>
            </a>
            <a href="/casino/baccarat" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/baccarat.png" class="img-fluid"> 
                <div class="casino-name">Baccarat</div>
              </div>
            </a>
            <a href="/casino/lucky7eu" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/lucky7eu.jpg" class="img-fluid"> 
                <div class="casino-name">Lucky 7 - B</div>
              </div>
            </a>
            <a href="/casino/teenpatti-list/teen6" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/teencasino.jpg" class="img-fluid"> 
                <div class="casino-name">Teenpatti 2.0</div>
              </div>
            </a>
            <a href="/casino/cc20" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/cc-20.jpg" class="img-fluid"> 
                <div class="casino-name">20-20 Cricket Match</div>
              </div>
            </a>
            <a href="/casino/cmeter" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/cmeter.jpg" class="img-fluid"> 
                <div class="casino-name">Casino Meter</div>
              </div>
            </a>
            <a href="/casino/war" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/war.jpg" class="img-fluid"> 
                <div class="casino-name">Casino War</div>
              </div>
            </a>
            <a href="/casino/dtl20" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/dtl.jpg" class="img-fluid"> 
                <div class="casino-name">20-20 DTL</div>
              </div>
            </a>
            <a href="/casino/teenpatti/test" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/teenpatti.jpg" class="img-fluid"> 
                <div class="casino-name">Test Teenpatti</div>
              </div>
            </a>
            <a href="/casino/teenpatti/open" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/teenpatti.jpg" class="img-fluid"> 
                <div class="casino-name">Open Teenpatti</div>
              </div>
            </a>
            <a href="/casino/teenpatti/oneday" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/teenpatti.jpg" class="img-fluid"> 
                <div class="casino-name">1 Day Teenpatti</div>
              </div>
            </a>
            <a href="/casino/teenpatti/t20" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/teenpatti.jpg" class="img-fluid"> 
                <div class="casino-name">20-20 Teenpatti</div>
              </div>
            </a>
            <a href="/casino/poker/6player" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/poker.jpg" class="img-fluid"> 
                <div class="casino-name">6 Player Poker</div>
              </div>
            </a>
            <a href="/casino/poker/oneday" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/poker.jpg" class="img-fluid"> 
                <div class="casino-name">1 Day Poker</div>
              </div>
            </a>
            <a href="/casino/poker/t20" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/poker.jpg" class="img-fluid"> 
                <div class="casino-name">20-20 Poker</div>
              </div>
            </a>
            <a href="/casino/ab20" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/andar-bahar.jpg" class="img-fluid"> 
                <div class="casino-name">Andar Bahar</div>
              </div>
            </a>
            <a href="/casino/worli" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/worli.jpg" class="img-fluid"> 
                <div class="casino-name">Worli Matka</div>
              </div>
            </a>
            <a href="/casino/worli2" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/worli.jpg" class="img-fluid"> 
                <div class="casino-name">Instant Worli</div>
              </div>
            </a>
            <a href="/casino/3cardj" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/3cardsJ.jpg" class="img-fluid"> 
                <div class="casino-name">3 Cards Judgement</div>
              </div>
            </a>
            <a href="/casino/card32a" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/32cardsA.jpg" class="img-fluid"> 
                <div class="casino-name">32 Cards A</div>
              </div>
            </a>
            <a href="/casino/card32b" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/32cardsB.jpg" class="img-fluid"> 
                <div class="casino-name">32 Cards B</div>
              </div>
            </a>
            <a href="/casino/aaa" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/aaa.jpg" class="img-fluid"> 
                <div class="casino-name">Amar Akbar Anthony</div>
              </div>
            </a>
            <a href="/casino/ddb" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/bollywood-casino.jpg" class="img-fluid"> 
                <div class="casino-name">Bollywood Casino</div>
              </div>
            </a>
            <a href="/casino/dt20" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/dt.jpg" class="img-fluid"> 
                <div class="casino-name">20-20 Dragon Tiger</div>
              </div>
            </a>
            <a href="/casino/dt6" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/dt.jpg" class="img-fluid"> 
                <div class="casino-name">1 Day Dragon Tiger</div>
              </div>
            </a>
            <a href="/casino/lottery" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/lottery.jpg" class="img-fluid"> 
                <div class="casino-name">Lottery</div>
              </div>
            </a>
            <a href="/casino/lucky7" class="">
              <div class="d-inline-block casinoicons">
                <img src="/front/img/casinoicons/img/lucky7.jpg" class="img-fluid"> 
                <div class="casino-name">Lucky 7 - A</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
