<?php
use App\Models\Auth\User;
?>
<style>
    .coupon-table tr td{
      padding: 10px;
    }
    
</style>
<?php if($isViewMoreBets == true){ ?>
<div style="overflow: scroll;">
    <table class="table coupon-table table-bordered" >
        <thead>
           <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">User Name</th>
                <th style="text-align: center;">Nation</th>
                <th style="text-align: center;">Bet Type</th>
                <th style="text-align: center;">Amount</th>
                <th style="text-align: center;">User Rate</th>
                <th style="text-align: center;">Place Date</th>
                <th style="text-align: center;">Match Date</th>
                <th style="text-align: center;">IP</th>
                <th style="text-align: center;">Browser Details</th>
                @if(Auth::user()->roles->first()->name == 'administrator')
                    <th style="text-align: center;"> Action </th>
                @endif
            </tr>
        </thead>
    <tbody>
        <?php 
    $i = 1;
    if(isset($mybetsModel[0])){
        foreach($mybetsModel as $key=>$betVal){
     
      
      $userModel = User::find($betVal->user_id);
      $name = '';
      if(isset($userModel->first_name)){
          $name = $userModel->first_name;
      }
      
      ?>
    
      @if($betVal->bet_side == 'lay')
        <?php $styleVal = 'background: rgb(250, 169, 186) none repeat scroll 0% 0%;' ; ?>
      @else
       <?php $styleVal = 'background: rgb(114, 187, 239) none repeat scroll 0% 0%;'; ?>
      @endif
        <tr style="{{$styleVal}}">
            <td style="text-align: center;"><?= $i++ ?></td>
            <td style="text-align: center;">{{$name }} </td>
            <td style="text-align: center;"> {{$betVal->team_name}}</td>
            <td style="text-align: center;"> {{$betVal->bet_side }}  </td>
            <td style="text-align: center;"> {{$betVal->bet_amount }}  </td>
            <td style="text-align: center;"> {{$betVal->bet_odds}}  </td>
            <td style="text-align: center;"> {{$betVal->created_at }}  </td>
            <td style="text-align: center;"> {{$sportModel->match_date_time}}  </td>
            <td style="text-align: center;"> {{$betVal->ip_address}}  </td>
            <td style="text-align: center;"> <span title="{{$betVal->browser_details}}">details</span>  </td>
            @if(Auth::user()->roles->first()->name == 'administrator' && $isDeleteShow)
                @if($betVal->isDeleted == 0)
                    <td style="text-align: center;"><a href="javascript:void(0);" onclick="deleteMyBets('{{$betVal->id}}');" ><i  style="color: red;" class="fa fa-trash"></i></a></td>
                @else
                    <td style="text-align: center;"><a href="javascript:void(0);" onclick="rollbackMyBets('{{$betVal->id}}');" ><i  style="color: green;" class="fa fa-undo"></i></a></td>
                @endif
            @endif
      </tr>
   
    <?php } }else{ ?>
   <tr >
       <td style="text-align: left;" colspan="10">No Record Found</td>

      </tr>
   <?php } ?>
  </tbody>
</table>
</div>

<?php }else{ ?>
<table class="table coupon-table table-bordered">
   <thead>
      <tr>
         <th style="text-align: center;"> User Name</th>
         <th style="text-align: center;"> Team Name</th>
         <th style="text-align: center;"> Odds</th>
         <th style="text-align: center;"> Stake</th>
         @if(Auth::user()->roles->first()->name == 'administrator' && $isDeleteShow)
         <th style="text-align: center;"> Action </th>
         @endif
      </tr>
   </thead>
  <tbody>
    @foreach($mybetsModel as $key=>$betVal)
      <?php 
      
      $userModel = User::find($betVal->user_id);
      $name = '';
      if(isset($userModel->first_name)){
          $name = $userModel->first_name;
      }
      ?>
      @if($betVal->bet_side == 'lay')
        <?php $styleVal = 'background: rgb(250, 169, 186) none repeat scroll 0% 0%;' ; ?>
      @else
       <?php $styleVal = 'background: rgb(114, 187, 239) none repeat scroll 0% 0%;'; ?>
      @endif
      <tr style="{{$styleVal}}">
         <td style="text-align: center;">{{$name }} </td>
         <td style="text-align: center;"> {{$betVal->team_name}}
         <?php if($betVal->bet_type == 'SESSION'){ 
          echo " // ";
          
          ?>
            
            {{$betVal->bet_oddsk}}
        <?php } ?>
         </td>
         <td style="text-align: center;"> {{$betVal->bet_odds}}  </td>
         <td style="text-align: center;"> {{$betVal->bet_amount }}  </td>
         @if(Auth::user()->roles->first()->name == 'administrator' && $isDeleteShow)
          @if($betVal->isDeleted == 0)
          <td style="text-align: center;"><a href="javascript:void(0);" onclick="deleteMyBets('{{$betVal->id}}');" ><i  style="color: red;" class="fa fa-trash"></i></a></td>
          @else
          <td style="text-align: center;"><a href="javascript:void(0);" onclick="rollbackMyBets('{{$betVal->id}}');" ><i  style="color: green;" class="fa fa-undo"></i></a></td>
          @endif
         @endif
      </tr>
   @endforeach
  </tbody>
</table>
<?php } ?>            
