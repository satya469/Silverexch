
@if(is_array($betModel) && count($betModel) == 0)
<tr class="">
    <td colspan="7">Record Not Available</td>
</tr>
@else
@foreach($betModel as $key=>$data)
<?php 
$style = ($data->bet_side == 'lay')? '#faa9ba' : '#72bbef';
$PL =0;
if($data->bet_side == 'lay'){
    $exp = explode('-',$data->bet_type);
  if(is_array($exp) && count($exp) == 2){
    if($data->team_name == $data->winner){
        $PL = (($data->bet_odds*$data->bet_amount)-$data->bet_amount)*(-1);
    }else{
        $PL = $data->bet_amount;
    }
  }else if($data->bet_type == 'ODDS' OR $data->bet_type == 'BOOKMAKER'){
    if($data->team_name == $data->winner){
      $PL = (($data->bet_odds*$data->bet_amount)-$data->bet_amount)*(-1);
    }else{
      $PL = $data->bet_amount;
    }
  }else{
    if($data->winner < $data->bet_odds){
      $PL = (($data->bet_oddsk*$data->bet_amount)/100);
    }else{
      $PL = $data->bet_amount*(-1);
    }
  }
}else{
  $exp = explode('-',$data->bet_type);
  if(is_array($exp) && count($exp) == 2){
    if($data->team_name == $data->winner){
      $PL = (($data->bet_odds*$data->bet_amount)-$data->bet_amount);
    }else{
      $PL = $data->bet_amount*(-1);
    }
  }else if($data->bet_type == 'ODDS' OR $data->bet_type == 'BOOKMAKER'){
    if($data->team_name == $data->winner){
      $PL = (($data->bet_odds*$data->bet_amount)-$data->bet_amount);
    }else{
      $PL = $data->bet_amount;
    }
  }else{
    if($data->winner >= $data->bet_odds){
      $PL = (($data->bet_oddsk*$data->bet_amount)/100);
    }else{
      $PL = $data->bet_amount*(-1);
    }
  }
}

?>

  <tr class="" style="background: {{$style}}">
    <td>{{$data->matchName}}</td>
    @if($data->bet_type == 'ODDS' OR $data->bet_type == 'BOOKMAKER'  )
      <td>{{$data->team_name }}</td>
    @else
      <td>{{$data->team_name }}/{{$data->bet_oddsk}}</td>
    @endif
    <td>{{$data->bet_side}}</td>
    <td>{{$data->bet_odds}}</td>
    <td>{{$data->bet_amount}}</td>
    <td>{{$PL}}</td>
    <td>{{$data->created_at}}</td>
  </tr>
@endforeach
@endif
