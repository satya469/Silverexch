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
$tot = 0;
?>

@foreach($arr1 as $key=>$gamesData)
  @foreach($gamesData as $key1=>$games)
<?php 
    $color = "green";
    if($mainCal[$key][$key1] < 0){
        $color = "red";
        $tot -= abs($mainCal[$key][$key1]);
    }else{
        $tot += $mainCal[$key][$key1];
    } 
?>
    <tr>
      <td>{{$key}}</td>
      <td><span style="background-color: var(--theme2-bg);color:#fff;padding: 3px;">{{$games}}</span></td>
      <td style="color :{{$color}};">
        {{$mainCal[$key][$key1]}}
      </td>
    </tr>
    @endforeach
@endforeach

@foreach($arr as $key=>$games)
<?php 
    $color = "green";
    if($mainCal[$key]['ODDS_BOOKMEKER'] < 0){
        $color = "red";
        $tot -= abs($mainCal[$key]['ODDS_BOOKMEKER']);
    }else{
        $tot += $mainCal[$key]['ODDS_BOOKMEKER'];
    }  
    ?>
<tr>
    <td>{{$games}}</td>
    <td><span style="background-color: var(--theme2-bg);color:#fff;padding: 3px;">{{$games}}</span></td>
    <td style="color :{{$color}};">{{$mainCal[$key]['ODDS_BOOKMEKER']}}</td>
</tr>
@endforeach
<tr>
    <td></td>
    <td>TOTAL</td>
    <td>{{$tot}}</td>
</tr>
