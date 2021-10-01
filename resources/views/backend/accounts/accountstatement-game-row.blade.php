<?php 
  $i=1; 
  $clsoingBlance = 0;
  $optCR = $optDR = 0;
if($optBal >= 0 && !empty($optDate)){
  $clsoingBlance =  $optBal;
  $optDR = $optCR = '-';
  $closingBalColor = "color:green;";
}else{
    $closingBalColor = "color:red;";
  $optCR = $optDR = '-';
  $clsoingBlance =  ($optBal);
//  $clsoingBlance = 0;
}
?>
@if(!empty($optBal) && !empty($optDate))
<tr>
    
    <td class="text-center">{{ $optDate }}</td>
    <td style="color:green;" class="text-right">{{$optCR}}</td>
    <td style="color:red;" class="text-right">{{$optDR}}</td>
    <td class="text-right" style="{{$closingBalColor}}}">{{$clsoingBlance}}</td>
    <td>Opening Balance</td>
    <td></td>    
</tr>
@endif
@foreach($betModel as $key=>$data)
<?php 

$CR = $DR = 0;
if(isset($data->deposite_user_id) && $data->deposite_user_id == $userID){
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
    
    <td class="text-center">{{ date('d-m-Y',strtotime($data->created_at))}}</td>
    <td style="color:green;" class="text-right">{{$CR}}</td>
    <td style="color:red;" class="text-right">{{$DR}}</td>
    <td style="{{$closingBalColor}}}" class="text-right">{{$clsoingBlance}}</td>
    <td>
        <?php if(!empty($text)){ ?>
        <a href="javascript:void();" onclick="showBetData('{{$ids}}','{{$data->match_id}}','{{$data->id}}');">{{$text}}
        </a>
        <?php } ?>
    </td>
    <td>{{ $data->Username}}</td>    
</tr>



@endforeach