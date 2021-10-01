@foreach($sports as $key=>$match)
  <tr role="row" class="even">

    <td class="notLink">
      <a style="background: none;color:#007bff;" href="javascript:void(0)">{{$match->match_name}} {{$match->match_date_time}}</a>
    </td>
    <td class="status">
      {{($match->active == 1)? 'Active': 'inActive' }}
    </td>
    <td>
      <a href="javascript:void(0)" onclick="changeStatus({{$match->id}},this);"> Click To {{( $match->active == 1)? 'InActive': 'Active' }}</a>
    </td>
    <td>
      <a href="javascript:void(0)"  onclick="changeStatusInplay({{$match->id}},this);"> {{( $match->inplay_status == 1)? 'Yes': 'No' }}</a>
    </td>
    <td>
        <a href="javascript:void(0)" onclick="setLimit({{$match->id}});"> Bet Limit</a>
    </td>
     @if($gameModel->name != 'CASINO')
    <td>
      <a href="javascript:void(0)" onClick="winnerSelect({{$match->id}},this);"> Winner Select</a>
    </td>
<!--                <td>
      <a href="javascript:void(0)"> Manage Fancy</a>
    </td>-->
    @endif
  </tr>
@endforeach