<?php 
use App\Http\Controllers\Backend\ListClientController;
$i=1;
$gtot = 0;
?>


@foreach($userModel as $key=>$data)
<?php 
$total = 0;
if($report == 1){
   $total = ListClientController::getDepositeBalnceDL($data->id);
}else{
    $total = $data->credit_ref;
}

$gtot +=  $total;
?>
<tr>
    <td><?= $i++ ?></td>
    <td>{{$data->first_name}}</td>
    <td>{{$total}}</td>
</tr>
@endforeach

 