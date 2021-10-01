<?php 
  $i=1; 
  $clsoingBlance = 0;
  $optCR = $optDR = 0;
if($optBal >= 0){
  $clsoingBlance = $optCR = $optBal;
  $optDR = '-';
}else{
  $optCR = '-';
  $clsoingBlance = $optDR = ($optBal*(-1));
  $clsoingBlance = 0;
}
?>
@if((!empty($optBal) && !empty($optDate)) || ($optBal == 0 && !empty($optDate)))
<tr>
    <td><?= $i++ ?></td>
    <td>{{ $optDate }}</td>
    <td style="color:green;" class="text-right">{{$optCR}}</td>
    <td style="color:red;" class="text-right">{{$optDR}}</td>
    <td class="text-right">{{$clsoingBlance}}</td>
    <td>Opening Balance</td>
        
</tr>
@endif
@foreach($betModel as $key=>$data)
<?php 

$CR = $DR = 0;
if(isset($data->deposite_user_id) && $data->deposite_user_id == Auth::user()->id){
  $CR = (int)$data->amount;
  $DR = '-';
  $clsoingBlance = (int)$clsoingBlance+(int)$CR;
}else{
  $DR = (int)($data->amount*(-1));
  $CR = '-';
  $clsoingBlance = (int)$clsoingBlance-(int)$data->amount;
}
$closingBalColor = "color:green;";
if($clsoingBlance < 0){
  $closingBalColor = "color:red;";
}
$text = $data->details;
$ids = $data->deposite_user_id.",".$data->withdrawal_user_id;
?>
<tr>
    <td><?= $i++ ?></td>
    <td>{{ $data->created_at}}</td>
    <td style="color:green;" class="text-right">{{$CR}}</td>
    <td style="color:red;" class="text-right">{{$DR}}</td>
    <td style="{{$closingBalColor}}}" class="text-right">{{$clsoingBlance}}</td>
    <td><a href="javascript:void(0);" onclick="showBetData('{{$ids}}','{{$data->match_id}}','{{$data->id}}');" >{{$text}}</a></td>
        
</tr>



@endforeach