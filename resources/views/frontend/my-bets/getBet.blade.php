<?php
if((is_object($myBetsModel) && count($myBetsModel)> 0)){
?>
   @foreach($myBetsModel as $key => $bet)
        <?php 
        if($bet['bet_side'] == 'back'){
          $className = "back-color";
        }else{
          $className = "lay-color";
        }
        ?>
        <tr class="{{$className}}">
            <th>{{$bet['team_name']}}
            <?php if($bet['bet_type'] == 'SESSION'){ ?>
                // {{$bet['bet_oddsk']}}
            <?php } ?>
            </th>
            <td>{{$bet['bet_odds']}}</td>
            <td>{{$bet['bet_amount']}}</td>
        </tr>
    @endforeach 
<?php }else{ ?>
    <tr>
        <td colspan="3" class="text-center">No Records Found</td>
    </tr>
<?php } ?>