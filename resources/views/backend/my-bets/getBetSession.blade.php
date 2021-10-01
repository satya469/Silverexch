
<table class="table table-bordered" border="1">
    <tr>
        <th style="border:1px solid #dadada;">Run</th>
        <th style="border:1px solid #dadada;">P/L</th>
    </tr>
    @foreach($resultArr as $run=>$data)
    <?php 
    $pl = 0;
    if(isset($data['profit']) && $data['profit'] !=0){
      $pl = ($data['profit']*(-1));
    }
    $color = "background:red";
    if($pl >= 0){
      $color = 'background:green;color:white';
    }
    if($pl == 0){
       $color = '';
    }
    ?>
      <tr class="">
        <th style="border:1px solid #dadada;{{$color}}">{{ $run }}</th>
        <th style="border:1px solid #dadada;{{$color}}">{{ $pl }}</th>
      </tr>
    @endforeach
</table>