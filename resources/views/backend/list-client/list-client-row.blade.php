<?php 
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Frontend\MyBetsController;
use App\Http\Controllers\Backend\ListClientController;
//if($client->parent_id != Auth::user()->id){
//  $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id,'withdrawal_user_id'=>$client->parent_id])->sum('amount');
//  $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id])->sum('amount');
////  $exposureTot = MyBetsController::getExAmount('',$client->id);
//  
//  $exposureTot = ListClientController::getExAmountPerByUser($client->id);
//          
//  $widTot1 = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->parent_id,'withdrawal_user_id'=>$client->id])->sum('amount');
//  
//  $avBTot = ($depParent-($exposureTot+$widTot));
//  
//  $pLTot = (($depParent-$widTot)-$client->credit_ref);
//  
//  $depParent = ($depParent-$widTot1);
//  
//}else{
//  $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id,'withdrawal_user_id'=>$client->parent_id])->sum('amount');
//  
//  $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id])->sum('amount');
//  $depTot = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id])->sum('amount');
// 
//  $widTotParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id,'deposite_user_id'=>$client->parent_id])->sum('amount');
//  $depParent = $depParent-$widTotParent;
//  $tot = ($depTot-$widTot);
////  $exposureTot = MyBetsController::getExAmount('',$client->id);
//  
// 
//  $pLTot = (($depParent)-$client->credit_ref);
//  
//}

if($client->roles->first()->name == 'user'){
  $depParent = ListClientController::userBalanceTot($client->id);
  $exposureTot = ListClientController::getExAmountPerByUser($client->id);
  $pLTot = (($depParent)-$client->credit_ref);
  $avBTot = ($depParent-$exposureTot);
}else{
  $depParent = ListClientController::agentBalanceTot($client->id);
  $upL = ListClientController::getAgentUpperLevel($client->id);
  $depParent -= ($upL*(-1));
//  $depParent -= ListClientController::getUpperLevelTotDeposit($client->id);
  $exposureTot = ListClientController::getExAmountPerByUser($client->id);
  $pLTot = (($depParent)-$client->credit_ref);
  
  $userCal = ListClientController::agentPLTot($client->id);        
  if($userCal > 0){
    $avBTot = ($depParent-$userCal);
  }else{
    $avBTot = ($depParent-abs($userCal));
  }
}

    switch(strtoupper($client->roles->first()->name)){
      case 'ADMINISTRATOR':{
        
        $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id,'withdrawal_user_id'=>$client->parent_id])->sum('amount');
        
        $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id])->sum('amount');
        $depTot = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id])->sum('amount');
        
        $widTotParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id,'deposite_user_id'=>$client->parent_id])->sum('amount');
        $depParent = $depParent-$widTotParent;
        $tot = ($depTot-$widTot);
        
        
        break;
      }
      case 'MASTER':
      case 'SUPERMASTER':
      case 'SUBADMIN':
        case 'ADMIN':{
              $depParent = ListClientController::getDepositeBalnceADMIN($client->id);
              $pLTot = ListClientController::getPLBalanceADMIN($client->id);
              $exposureTot = ListClientController::getExAmountPerByUser($client->id);
              $avBTot = ListClientController::getUserAvalableBalanceADMIN($client->id);
              break;
        }
        case 'SUBADMIN132':{
            $depParent = ListClientController::getDepositeBalnceDL($client->id);
            $pLTot = ListClientController::getPLBalance($client->id);
            $exposureTot = ListClientController::getExAmountPerByUser($client->id);
            $avBTot = ListClientController::getUserAvalableBalanceDL($client->id);
            break;
        }
        case 'SUPERMASTER123':{
            $depParent = ListClientController::getDepositeBalnceDL($client->id);
            $pLTot = ListClientController::getPLBalance($client->id);
            $exposureTot = ListClientController::getExAmountPerByUser($client->id);
            $avBTot = ListClientController::getUserAvalableBalanceDL($client->id);
            break;
        }
        case 'MASTER123':{
            $depParent = ListClientController::getDepositeBalnceDL($client->id);
            $pLTot = ListClientController::getPLBalance($client->id);
            $exposureTot = ListClientController::getExAmountPerByUser($client->id);
            $avBTot = ListClientController::getUserAvalableBalanceDL($client->id);
            break;
        }
        case 'USER':{
            $depParent = ListClientController::getUserDepositeBalance($client->id);
            $pLTot = ListClientController::getUserPLBalance($client->id);
            $exposureTot = ListClientController::getExAmountPerByUser($client->id);
            $avBTot = ListClientController::getUserAvalableBalance($client->id);
            break;
        }
    }





?>
  
      <td class="uname">
        @if($client->roles->first()->name == 'user')
          <a href="javascript:void(0);" class="username">{{$client->first_name}}</a>
        @else
          <a href="{{ route('admin.client.listchild',$client->uuid)}}" title="{{$client->first_name}}" class="username">{{$client->first_name}}</a>
        @endif
      </td>
      <td class="crf text-right">{{ ListClientController::getNumberFormet($client->credit_ref)}}</td>
      <td class="general text-right">{{ ListClientController::getNumberFormet($depParent) }}</td>
      <td class="crf text-right">{{ ListClientController::getNumberFormet($pLTot) }}</td>
      <td class="expose text-right">{{ ListClientController::getNumberFormet($exposureTot) }}</td>
      <td class="abalance text-right">{{ ListClientController::getNumberFormet($avBTot) }}</td>
      <td class="ustatus">
        <label class="form-check-label">
        @if($client->active == '1')    
        <input class="form-check-input" type="checkbox" disabled="" checked="'checked'">
        @else
        <input class="form-check-input" type="checkbox" disabled="">
        @endif
        <span class="checkmark"></span>
        </label>
      </td>
      <td class="bstatus">
        <label class="form-check-label">
        @if($client->betActive == '1')    
        <input class="form-check-input" type="checkbox" disabled="" checked="'checked'">
        @else
        <input class="form-check-input" type="checkbox" disabled="">
        @endif
        <span class="checkmark"></span>
        </label>
      </td>
      <td class="exlimit text-right">{{ ListClientController::getNumberFormet($client->exposelimit) }}</td>
      <td class="comm">
        @if($client->roles->first()->name == 'user')
        <p>0</p>
        @else
        <p>{{$client->partnership}}</p>
        @endif
      </td>
      <td class="atype text-center">
          @if(isset($roleArr[$client->roles->first()->name]))
          {{ $roleArr[$client->roles->first()->name] }}
          @else
          <?php echo strtoupper($client->roles->first()->name); ?>
          @endif
      </td>
      <td class="text-right">
        0.00
      </td>
      <td class="actions text-left">
        <a href="javascript:void(0)" onclick="setUserToDeposit('{{$client->uuid}}',this);">D</a>
        <a href="javascript:void(0)" onclick="setUserToWithdraw('{{$client->uuid}}',this);">W</a>
        @if($isParent == true)   
        @if($client->parent_id == $parentID)
        @if($client->roles->first()->name == 'user')
        <a href="javascript:void(0)" onclick="setUserToLimit('{{$client->uuid}}',this);">L</a>
        @else
        <a href="javascript:void(0),">L</a>
        @endif
        <a href="javascript:void(0)" onclick="setUserToCredit('{{$client->uuid}}',this);">C</a>
        <a href="#" data-toggle="modal" onclick="setUserToPassword('{{$client->uuid}}',this);" data-target="#modal-password">P</a>
        <a href="javascript:void(0)" onclick="setUserToStatus('{{$client->uuid}}',this)">S</a>
        @endif
        @endif
      </td>
              