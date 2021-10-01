<?php $i=1; ?>
@if(is_array($betModel) && count($betModel) == 0)
<tr class="">
    <td colspan="9">Record Not Available</td>
</tr>
@else
@foreach($betModel as $key=>$data)
<?php 
$style = ($data->bet_side == 'lay')? '#faa9ba' : '#72bbef';
?>

  <tr class="" style="background: {{$style}}">
    <td><?= $i++ ?></td>
    <td>{{$data->matchName}}</td>
    @if($data->bet_type == 'ODDS' OR $data->bet_type == 'BOOKMAKER'  )
      <td>{{$data->team_name }}</td>
    @else
      <td>{{$data->team_name }}/{{$data->bet_oddsk}}</td>
    @endif
    <td>{{$data->eventType}}</td>
    <td>{{$data->bet_type}}</td>
    <td>{{$data->bet_side}}</td>
    <td>{{$data->bet_odds}}</td>
    <td>{{$data->bet_amount}}</td>
    <td>{{$data->created_at}}</td>
  </tr>
@endforeach
@endif
