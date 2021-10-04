@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  @include('frontend.game-list.leftSide')
  <!---->
  <div class="col-md-10 featured-box">
    <div>
      <!---->
      <div class="pb-4 mt-4">

        <div class="tab-content">
          <div class="tab-pane active">
            <div class="coupon-card coupon-card-first">
              <div class="card-content mobile-scroll" >
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
                            <input type="hidden" class="url" value="{{route("frontend.getdatatennis",$match->match_id)}}">
                            <input type="hidden" class="matchIDs" value="{{$match->match_id}}">
                          <a href="{{route('frontend.game-list.singles',$match->match_id)}}" class="text-dark">{{$match->match_name}}  {{$match->match_date_time}}</a>
                        </div>
                        <div class="game-icons">
                          <span class="game-icon">
                            @if($match->inplay_status == 1)
                              <span class="active dot"></span>
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
                          <span class="odd  back0no1">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay1">
                          <span class="odd lay0no1">-</span>
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
                        <button class="back2">
                          <span class="odd back1no1">-</span>
                        </button>
                      </td>
                      <td>
                        <button class="lay2">
                          <span class="odd lay1no1">-</span>
                        </button>
                      </td>
                    </tr>
                  @endforeach

                  </tbody>
                </table>
                 <div class="mobileView mobileViewOdds ">
                  @foreach($sports as $key => $match)
                    <div class="row bottom20 pb10 bbottom rows">
                      <div class="col-sm-8 pl0">
                        <div class="game-name">
                            <input type="hidden" class="url" value="{{route("frontend.getdatatennis",$match->match_id)}}">
                            <input type="hidden" class="matchIDs" value="{{$match->match_id}}">
                            <a href="{{route('frontend.game-list.singles',$match->match_id)}}" class="text-dark"><b>{{$match->match_name}}</b> <br> {{$match->match_date_time}}</a>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="game-icons">
                          <span class="game-icon">
                            @if($match->inplay_status == 1)
                              <span class="active dot"></span>
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

                          <span class="odd">-</span>

                      </div>
                      <div class="col-sm-2 lay text-center">

                          <span class="odd">-</span>

                      </div>
                      <div class="col-sm-2 back2 text-center">

                          <span class="odd back1no1">-</span>

                      </div>
                      <div class="col-sm-2 lay2 text-center">

                          <span class="odd lay1no1">-</span>
                        </button>
                      </div>
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
.gameList a{
  width: 210px;
}
</style>
@endpush
@push('after-scripts')
  <script type="text/javascript">
    var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
        isMobile = true;
        $('.destopview').remove();
    }else{
      $('.mobileView').remove();
    }

    $.noConflict();
    $( document ).ready(function() {
      setInterval(function(){ getData(); }, 10000);
    });
    // getData();
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
