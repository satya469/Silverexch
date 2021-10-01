<?php
$arr = array(
    'LiveTeenPati'=>'Live TeenPatti',
    'AndarBahar'=>'Andar Bahar',
    'Poker'=>'Poker',
    'UpDown7'=>'7 Up & Down',
    'CardScasin032'=>'32 Cards Casino',
    'TeenPati20'=>'TeenPatti T20',
    'AmarAkbarAnthony'=>'Amar Akbar Anthony',
    'DragOnTiger'=>'DragonTiger'
    
);
$arr1 = array(
    'Cricket'=>array('ODDS_BOOKMEKER'=>'MATCH','SESSION'=>'FANCY'),
    'Tennis'=>array('ODDS_BOOKMEKER'=>'MATCH'),
    'Soccer'=>array('ODDS_BOOKMEKER'=>'MATCH','SESSION'=>'FANCY'),
    
);

?>

@foreach($arr1 as $key=>$gamesData)
  @foreach($gamesData as $key1=>$games)
    <tr>
      <td>{{$key}}</td>
      <td><span style="background-color: var(--theme2-bg);color:#fff;padding: 3px;">{{$games}}</span></td>
      <td>
        {{$mainCal[$key][$key1]}}
      </td>
    </tr>
    @endforeach
@endforeach

@foreach($arr as $key=>$games)

<tr>
    <td>{{$games}}</td>
    <td><span style="background-color: var(--theme2-bg);color:#fff;padding: 3px;">{{$games}}</span></td>
    <td>{{$mainCal[$key]['ODDS_BOOKMEKER']}}</td>
</tr>
@endforeach

