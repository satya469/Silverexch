@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  @include('frontend.game-list.leftSide')
  <!---->
  <div class="col-md-10 featured-box" >
    <div>
      <!---->
      <div class="pb-4 mt-4">

        <div class="tab-content">
          <div class="tab-pane active">
            <div class="coupon-card coupon-card-first">
              <div class="card-content mobile-scroll">
                <table class="table coupon-table destopview">
                  <thead>
                    <tr>
                      <th style="width: 63%;">Game</th>
                      <th colspan="2">1</th>
                      <th colspan="2">X</th>
                      <th colspan="2">2</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($sports as $key => $match)
                    <tr class="rows">
                      <td>
                        <div class="game-name">
                            <input type="hidden" class="url" value="{{route("frontend.getdatasoccer",$match->match_id)}}">
                            <input type="hidden" class="matchIDs" value="{{$match->match_id}}">
                          <a href="{{route('frontend.game-list.singles',$match->match_id)}}" class="text-dark">{{$match->match_name}}  {{$match->match_date_time}}</a>
                        </div>
                        <div class="game-icons">
                          <span class="game-icon">
                            @if($match->inplay_status == 1)
                              <span class="dot"></span>
                            @endif
                          </span>
                          <span class="game-icon">
                            @if($match->tv_status == 1)
                              <i class="fas fa-tv v-m icon-tv"></i>
                            @endif
                          </span>
                          <span class="game-icon">
                            @if($match->fancy_status == 1)
                              <img src="/front/img/icons/ic_fancy.png" class="fancy-icon">
                            @endif
                          </span>
                          <span class="game-icon">
                            @if($match->bookmaker_status == 1)
                              <img src="/front/img/icons/ic_bm.png" class="bookmaker-icon">
                            @endif
                          </span>

                        </div>
                      </td>
                      <td>
                        <button class="back1">
                          <span class="odd  back0no1"></span>
                        </button>
                      </td>
                      <td>
                        <button class="lay1">
                          <span class="odd lay0no1"></span>
                        </button>
                      </td>
                      <td>
                        <button class="back1">
                        <span class="odd  back2no1"></span>
                        </button>
                      </td>
                      <td>
                        <button class="lay1">
                        <span class="odd lay2no1"></span>
                        </button>
                      </td>
                      <td>
                        <button class="back2">
                          <span class="odd back1no1"></span><br>
                          <span class="odd back1no2"></span>
                        </button>
                      </td>
                      <td>
                        <button class="lay2">
                          <span class="odd lay1no1"></span><br>
                          <span class="odd lay1no2"></span>
                        </button>
                      </td>
                    </tr>
                  @endforeach

                  </tbody>
                </table>
                <div class="mobileView mobileViewOdds">
                  @foreach($sports as $key => $match)
                    <div class="row bottom20 pb10 bbottom rows">
                      <div class="col-sm-8 pl0">
                        <div class="game-name">
                            <input type="hidden" class="url" value="{{route("frontend.getdatasoccer",$match->match_id)}}">
                            <input type="hidden" class="matchIDs" value="{{$match->match_id}}">
                            <a href="{{route('frontend.game-list.singles',$match->match_id)}}" class="text-dark"><b>{{$match->match_name}}</b> <br> {{$match->match_date_time}}</a>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="game-icons">
                          <span class="game-icon">
                            @if($match->inplay_status == 1)
                              <span class="dot"></span>
                            @endif
                          </span>
                          <span class="game-icon">
                            @if($match->tv_status == 1)
                              <i class="fas fa-tv v-m icon-tv"></i>
                            @endif
                          </span>
                          <span class="game-icon">
                            @if($match->fancy_status == 1)
                              <img src="/front/img/icons/ic_fancy.png" class="fancy-icon">
                            @endif
                          </span>
                          <span class="game-icon">
                            @if($match->bookmaker_status == 1)
                              <img src="/front/img/icons/ic_bm.png" class="bookmaker-icon">
                            @endif
                          </span>
                        </div>
                      </div>

                      <div class="col-sm-4 text-center">1</div>
                      <div class="col-sm-4 text-center">X</div>
                      <div class="col-sm-4 text-center">2</div>

                      <div class="col-sm-2 back1 text-center">

                          <span class="odd  back0no1">-</span>

                      </div>
                      <div class="col-sm-2 lay1 text-center">

                          <span class="odd lay0no1">-</span>

                      </div>
                      <div class="col-sm-2 back text-center">

                          <span class="odd back2no1">-</span>

                      </div>
                      <div class="col-sm-2 lay text-center">

                          <span class="odd lay2no1">-</span>

                      </div>
                      <div class="col-sm-2 back2 text-center">

                          <span class="odd back1no1">-</span>

                      </div>
                      <div class="col-sm-2 lay2 text-center">

                          <span class="odd lay1no1">-</span>
                        </button>                      </div>
                    </div>
                  @endforeach

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('frontend.game-list.gameBottom')
    </div>
  </div>
</div>


@endsection
@push('after-styles')
<style>
  .coupon-table button {
    width: 100%;
    min-width: 40px;
    height: 35px;
    margin: 0;
    text-align: center;
    display: inline-block;
    padding: 0;
    color: #273a47;
    border: 0;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}
</style>
@endpush
@push('after-scripts')
  <script type="text/javascript">
    $( document ).ready(function() {
      setInterval(function(){ getData(); }, 10000);
    });
    getData();
    function getData(){
      $('.url').each(function(){
        var rootThis = this;
        var url = $( this ).val();
        $.ajax({
          url: url,
          dataType: 'json',
          type: "get",
          success: function(data){
            $.each(data.odd, function(i, item) {
//              alert(item.BackPrice1+"="+item.LayPrice1);
              $(rootThis).closest('.rows').find('.back'+i+'no1').text(item.b1);
//              $(rootThis).closest('tr').find('.back'+i+'no2').text(item.BackSize1+'k');
              $(rootThis).closest('.rows').find('.lay'+i+'no1').text(item.l1);
//              $(rootThis).closest('tr').find('.lay'+i+'no2').text(item.LayPrice1+'k');
            });
          }
        });
      });
    }

  </script>
@endpush
