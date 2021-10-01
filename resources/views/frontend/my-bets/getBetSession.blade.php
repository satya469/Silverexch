
<table class="table table-bordered">
    <tr>
        <th>Run Position</th>
<!--        <th>Lay</th>
        <th>Back</th>-->
        <th>P/L</th>
    </tr>
    @foreach($resultArr as $run=>$data)
    <?php 
    $color = "background:red;";
    if($data['profit'] >= 0){
      $color = 'background:green;color:white';
    }
    if($data['profit'] == 0){
       $color = '';
    }
    
    
    ?>
      <tr style="{{$color}}}">
        <th>{{ $run }}</th>
<!--        <th>{{ $data['profitLay'] }}</th>
        <th>{{ $data['profitBack'] }}</th>-->
        <th>{{ $data['profit'] }}</th>
      </tr>
    @endforeach
</table>