
@foreach($betModel as $key=>$data)
  <?php 
  $class = 'back';
    if($data->bet_side == 'lay'){
      $class = 'lay';
    }
  ?>
  <tr class="{{$class}}">
    <td>{{$key+1}}</td>
    <td>{{$data->gameName}}</td>
    <td>{{$data->sportName}}</td>
    <td>{{$data->userName}}</td>
    <td>{{$data->team_name}}</td>
    <td>{{$data->bet_side}}</td>
    <td>{{$data->bet_odds}}</td>
    <td>{{$data->bet_amount}}</td>
    <td>{{$data->created_at}}</td>
  </tr>
@endforeach

