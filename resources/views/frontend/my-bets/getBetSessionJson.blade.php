
  <?php 
  $response = array();
  $lay = $back =  0;
  $layK = $backK = 0;
  if(isset($myBetsModelLay['bet_odds']))
    $lay = $myBetsModelLay['bet_odds'];
  if(isset($myBetsModelBack['bet_odds']))
    $back = $myBetsModelBack['bet_odds'];
  if(isset($myBetsModelLay['bet_oddsk']))
    $layK = $myBetsModelLay['bet_oddsk'];
  if(isset($myBetsModelBack['bet_oddsk']))
    $backK = $myBetsModelBack['bet_oddsk'];
  
  if($lay < $back){
    $start = ($lay !=0) ? ($lay-1) : $back-1;
    $limit = ($back > $lay && $back !=0) ? ($back+1) : ($lay+1);
    for($i = $start;$i <= $limit; $i++ ){
      $className = "";
      $profitL = $profitB = 0;
      if($back > $i){
        $profitB = ($myBetsModelBack['bet_amount']*(-1));
      }else{
        $profitB = ($backK*10);
      }
      if($lay != 0){
        if($lay > $i){
          $profitL = $myBetsModelLay['bet_amount'];
        }else{
          $profitL = (($layK*10)*(-1));
        }
        $className = "back-color";
        if($i < $back){
          $className = "lay-color";
        }
        if($profitL < 0 && $profitB < 0){
           $profit = ((abs($profitL)+abs($profitB))*(-1));
        }else if($profitB < 0){
          if(abs($profitL) < abs($profitB)){
            $profit = ((($profitL)-(abs($profitB)))*(-1));
          }else{
            $profit = (($profitL)-(abs($profitB)));
          }
        }else if($profitL < 0){
          $profit = ((abs($profitL)-($profitB))*(-1));
        }else{
          if(empty($profitB)){
            $profit = $profitL;
          }else if(empty ($profitL)){
             $profit = $profitB;
          }else{
            $profit = (($profitL)-($profitB));
          }
        }
      }else{
        $className = "back-color";
        $profit = $profitB;
      }
      $response[$i] = array('side'=>$className,'profitL' => $profitL,'profitB'=>$profitB,'profit'=>$profit);
  
   }
    
  }else{
    $start = ($lay !=0) ? ($lay-1) : $back-1;
    $limit = ($back > $lay && $back !=0) ? ($back+1) : ($lay+1);
    for($i = $start;$i <= $limit; $i++ ){
      $className = "";
      $profit = $profitL = $profitB = 0;
      if($lay > $i){
        $profitL = $myBetsModelLay['bet_amount'];
      }else{
        $profitL = (($layK*10)*(-1));
      }
      if($back != 0 ){
        if($back > $i){
          $profitB = ($myBetsModelBack['bet_amount']*(-1));
        }else{
          $profitB = ($backK*10);
        }
        $className = "back-color";
        if($i < $back){
          $className = "lay-color";
        }
        if($profitL < 0 && $profitB < 0){
          $profit = ((abs($profitL)+abs($profitB))*(-1));
        }else if($profitB < 0){
          if(abs($profitL) < abs($profitB)){
            $profit = ((($profitL)-(abs($profitB)))*(-1));
          }else{
            $profit = (($profitL)-(abs($profitB)));
          }
        }else if($profitL < 0){
          $profit = ((abs($profitL)-($profitB))*(-1));
        }else{
          if(empty($profitB)){
            $profit = $profitL;
          }else if(empty ($profitL)){
             $profit = $profitB;
          }else{
            $profit = (($profitL)-($profitB));
          }
        }
      }else{
        $className = "lay-color";
        $profit = $profitL;
      }
      $response[$i] = array('side'=>$className,'profitL' => $profitL,'profitB'=>$profitB,'profit'=>$profit);

   }
    
  }
  
  echo json_encode($response);
  ?>