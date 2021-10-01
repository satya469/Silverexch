
<table class="table table-bordered">
    <tr>
        <th>Run</th>
        <th>Lay</th>
        <th>Back</th>
        <th>P/L</th>
    </tr>
    @if(isset($ResultArr['lay']))
      @foreach($ResultArr['lay'] as $run=>$val)
        <?php 
        $pL = 0;
        $profitB = isset($ResultArr['back'][$run]) ? $ResultArr['back'][$run] : 0;

        $profitL =  $val;
        if($profitB < 0 && $profitL < 0){
          $pL = (abs($profitB)+abs($profitL))*(-1);
        }else if($profitB >= 0 && $profitL >= 0){
          $pL = ($profitB+$profitL);
        }else if($profitB >= 0 && $profitL <= 0){
          $pL = ($profitB - abs($profitL));
        }else if($profitB <= 0 && $profitL >= 0){
          if($profitL >= abs($profitB)){
            $pL = ($profitL-abs($profitB));
          }else{
           $pL = ($profitL-abs($profitB));
          }
        }
        ?>
      <tr class="">
        <th>{{ $run }}</th>
        <th>{{ $profitL }}</th>
        <th>{{ $profitB }}</th>
        <th>{{ $pL }}</th>
      </tr>
    @endforeach
    
    @elseif(isset($ResultArr['back']))
    
    @foreach($ResultArr['back'] as $run=>$val)
      <?php 
      $pL = 0;
      $profitL = isset($ResultArr['lay'][$run]) ? $ResultArr['lay'][$run] : 0;
      $profitB =  $val;
      if($profitB < 0 && $profitL < 0){
        $pL = (abs($profitB)+abs($profitL))*(-1);
      }else if($profitB > 0 && $profitL > 0){
        $pL = ($profitB+$profitL);
      }else if($profitB > 0 && $profitL < 0){
        $pL = ($profitB - abs($profitL));
      }else if($profitB < 0 && $profitL > 0){
        if($profitL > abs($profitB)){
          $pL = ($profitL-abs($profitB));
        }else{
         $pL = ($profitL-abs($profitB));
        }

      }
      ?>
     <tr class="">
        <th>{{ $run }}</th>
        <th>{{ $profitL }}</th>
        <th>{{ $profitB }}</th>
        <th>{{ $pL }}</th>
      </tr>
    @endforeach
    
    @endif
</table>