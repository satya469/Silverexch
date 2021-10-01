@foreach($myBetsModel as $key => $bet)
  <?php 
  if($bet['bet_side'] == 'back'){
    $className = "back-color";
  }else{
    $className = "lay-color";
  }
  ?>
  <tr class="{{$className}}">
      <th>{{$bet['team_name']}}</th>
      <td>{{$bet['bet_odds']}}</td>
      <td>{{$bet['bet_amount']}}</td>
  </tr>

@endforeach