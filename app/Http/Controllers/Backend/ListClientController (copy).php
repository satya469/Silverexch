<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Auth as AuthNew;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Frontend\MyBetsController;
class ListClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /*** CLIENT LIST ACTION **/
    public function checkLoginUser(Request $request){
        return '';
    }
             
    public function listclients()
    {
      
      $roleArr = array('administrator'=>'SUPER ADMIN','admin'=>'ADMIN','subadmin'=>'SMDL','supermaster'=>'MDL','master'=>'DL','user'=>'USER');
      $userId = Auth::id();
      $parentID = AuthNew::user()->id;
      $clients = User::where(['parent_id'=>AuthNew::user()->id])->orderBy('betActive', 'DESC')->get();
      $mainCalArr = array();
//      self::setChildUserData($parentID);
      $isParent = true;
      $mainCalArr = self::getMainCal($userId);
      return view('backend.list-client.list-client', compact('clients','parentID','roleArr','mainCalArr','isParent'));
    }
    
    public static function setButtonVal($userID){
      $buttonValueModel = ButtonValue::where(['user_id'=>$userID])->first();
      if(!isset($buttonValueModel->btnSetting)){
        $buttonValueModel = new ButtonValue();
        $buttonValueModel->user_id = $userID;
        $buttonValueModel->btnSetting = '{"label":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"],"price":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"]}';
        $buttonValueModel->save();
      }else if(empty($buttonValueModel->btnSetting)){
        $buttonValueModel->btnSetting = '{"label":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"],"price":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"]}';
        $buttonValueModel->save();
      }
    }
    
    public static function setChildUserData($userID){
      $childUser = AccountsController::getChildUserList($userID);
      foreach($childUser as $key=>$userObj){
        if(strtoupper($userObj->roles->first()->name) == 'USER'){
          self::setButtonVal($userObj->id);
        }
      }
    }
    
    /***** USER MAIN CAL FUNCTION ******/
    
    public static function getCreditReferance($userId,$parentID){
      $user = User::where(['id'=>$userId])->first();
      if(strtoupper($user->roles->first()->name) == 'ADMINISTRATOR'){
        $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$userId,'withdrawal_user_id'=>$parentID])->sum('amount');
        $widParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$userId,'deposite_user_id'=>$parentID])->sum('amount');
        return ($depParent-$widParent);
        
      }else{
        $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$userId,'withdrawal_user_id'=>$parentID,'balanceType'=>'DEPOSIT'])->sum('amount');
        $widParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$userId,'deposite_user_id'=>$parentID,'balanceType'=>'WITHDRAWAL'])->sum('amount');
        return ($depParent-$widParent);
      }
//      $widParent += self::getAgentUpperLevel($userId);
//      return ($depParent-$widParent);
    } 
    
    
    
    public static function getUpperLevelTotDeposit($UserID){
      $user = User::where(['id'=>$UserID])->first();
      $depParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$UserID,'balanceType'=>'UPPER-LEVEL'])->sum('amount');
      return $depParent;
    }
    
    public static function getABBarPL($userID){
      $PLBalanceTot = 0;
      $user = User::where(['id'=>$userID])->first();
      
      if(strtoupper($user->roles->first()->name) == 'USER'){
        return self::getUserPL($userID);
      }
      
      $userParent = User::where(['id'=>$user->parent_id])->first();
      
      $userParentArr = User::where(['parent_id'=>$userID])->get();
      $patnershipArr = array();
      foreach($userParentArr as $key=>$val){
        $PLBalanceTotChaild = self::getMainChildPL($val->id);
        if(strtoupper($val->roles->first()->name) == 'USER'){
          $PLBalanceTotChaild = self::getUserAgentPL($val->id);
          $parentPer = $user->partnership;
        }else{
          $parentPer = (($user->partnership)-($val->partnership));
        }
//        dd($PLBalanceTotChaild);
        $PLBalanceTot += (($PLBalanceTotChaild*$parentPer)/100);
      }
      return $PLBalanceTot;
    }
    
    public static function getUserPL($userID){
      $user = User::where(['id'=>$userID])->first();
      $balanceTot = self::agentBalanceTotneW($userID);
      return ($balanceTot-$user->credit_ref);
    }
    
    public static function getDownLevelCreditReferance($userId){
      $depParent = DB::table('users')->where(['parent_id'=>$userId])->sum('credit_ref');
      return $depParent;
    }
    public static function getDownLevalUpperLeval($userID){
      $tot = 0;
      $user = User::where(['id'=>$userID])->first();
      $userData = User::where(['parent_id'=>$userID])->get();
//      $tot += (self::getAgentUpperLevel($userID));
      foreach($userData as $key=>$userData){
        $tot += (self::getAgentUpperLevel($userData->id));
//        $tot +=self::getDownLevalUpperLeval($userData->id);
      }
      return $tot;
    }

    
    public static function getMyProfit($userID){
      $downLevel = DB::table('upper_level_down_levels')->where(['user_id'=>$userID,'active'=>0])->sum('downLevel');
      return $downLevel;
    }

    public static function getAgentAvailableBalanceWithPL($userID){
      return DB::table('upper_level_down_levels')->where(['user_id'=>$userID,'active'=>1])->sum('downLevel');
    }
    public static function getUserParentPer($userID){
      $userModel = User::find($userID);
      $userData = array();
      /** get parent **/
      $parentID = $userModel->parent_id;
      $userData[$userID] = $userModel->partnership;
      $childPartnership = $userModel->partnership;
      $childID = $userID;
      while($parentID > 0){
        $userModelParent = User::find($parentID);
        $userModelChilds = User::find($childID);
        $userData[$parentID] = ($userModelParent->partnership-$userModelChilds->partnership);
        $childPartnership =  $userData[$parentID];
        $childID = $userModelParent->id;
        $parentID = $userModelParent->parent_id;
      }
      return $userData;
    }
    

   
    
    
    public static function getClientDetailsNew(){
      $isParent = true;
      $mainCalArr = self::getMainCal(Auth::user()->id);
      $options = view("backend.list-client.client-details",compact('mainCalArr','isParent'))->render();
      return $options;
    }

    public static function getTotDeposit($UserID){
      $user = User::where(['id'=>$UserID])->first();
      $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$UserID])->sum('amount');
      return $depParent;
    }
    
    public static function getDownLevelOccupyBalance($userId){
      $depParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$userId,'balanceType'=>'DEPOSIT'])->sum('amount');
      return $depParent;
    }
    
    
    
    
    
    public static function getMainBarPL($userID){
      $PLBalanceTot = 0;
      $user = User::where(['id'=>$userID])->first();
      
      $userParent = User::where(['id'=>$user->parent_id])->first();
      
      if(strtoupper($user->roles->first()->name) == 'USER'){
        return self::getUserPL($userID);
      }
      $PLBalanceTot = self::getMainChildPL($userID);
      if($user->parent_id == 0 || strtoupper($userParent->roles->first()->name) == 'ADMINISTRATOR'){
        $parentPer = (100-$user->partnership);
      }elseif($user->id == AuthNew::user()->id){
        $parentPer = $user->partnership;
        $parentPer = (100-$parentPer);
      }else{
        $parentPer = (($userParent->partnership)-($user->partnership));
      }
      
      
      return (($PLBalanceTot*$parentPer)/100);
     
    }
    
    
    
    public static function getMainChildPL($userID){
      $PLBalanceTot = 0;
      $user = User::where(['id'=>$userID])->first();
      $parentPer = $user->partnership;
      $parentUser = User::where(['parent_id'=>$userID])->get();
      foreach($parentUser as $key=>$childUser){
        if(strtoupper($childUser->roles->first()->name) == 'USER'){
          $PLBalanceTot += self::getUserAgentPL($childUser->id);
        }else{
          $PLBalanceTot += self::getMainChildPL($childUser->id);
        }
      }
//      dd($PLBalanceTot);
      return $PLBalanceTot;
    }

    /*************** CLIENT LIST FUNCTION *****************/
    public static function getUserAgentPL($userID){
      $user = User::where(['id'=>$userID])->first();
      $balanceTot = self::agentBalanceTot($userID);
      return ($balanceTot);
    }
    
   

    public static function agentBalanceTotneW($userID){
      $user = User::where(['id'=>$userID])->first();
      $depParent1 = DB::table('user_deposites')->where(['deposite_user_id'=>$user->id,'withdrawal_user_id'=>$user->parent_id,'balanceType'=>'DEPOSIT'])->sum('amount');
      $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$user->id,'withdrawal_user_id'=>$user->parent_id])->sum('amount');
      $depParent -=$depParent1;
      $widParent1 = DB::table('user_deposites')->where(['withdrawal_user_id'=>$user->id,'deposite_user_id'=>$user->parent_id,'balanceType'=>'WITHDRAWAL'])->sum('amount');
      $widParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$user->id,'deposite_user_id'=>$user->parent_id])->sum('amount');
      $widParent -=$widParent1;
      return ($depParent-$widParent);
    }
    
    public static function agentBalanceTot($userID){
      $user = User::where(['id'=>$userID])->first();
      $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$user->id,'withdrawal_user_id'=>$user->parent_id])->sum('amount');
      $widParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$user->id,'deposite_user_id'=>$user->parent_id])->sum('amount');
      return ($depParent-$widParent);
    }

    public static function agentPLTot($userID){
      $user = User::where(['id'=>$userID])->first();
      $sql = "SELECT 	SUM(`amount`) as Tot 
                      FROM `user_deposites` 
                      WHERE `deposite_user_id` != '".$user->parent_id."' AND `withdrawal_user_id` = '".$userID."'";
      
      $widParentJson = DB::select($sql);
      
      $sql = "SELECT 	SUM(`amount`) as Tot 
                      FROM `user_deposites` 
                      WHERE `withdrawal_user_id` != '".$user->parent_id."' AND `deposite_user_id` = '".$userID."'";
      $depParentJson = DB::select($sql);
      
      $widParent = $widParentJson[0]->Tot;
      $depParent = $depParentJson[0]->Tot;
      return ($depParent-$widParent);
    }

    public static function userBalanceTot($userID){
      $depTot = self::getTotDeposit($userID);
      $widTot = self::getTotWidthorw($userID);
      return ($depTot-$widTot);
    }
    
   
    public static function getTotWidthorw($UserID){
      $depParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$UserID,'balanceType'=>'WITHDRAWAL'])->sum('amount');
      return $depParent;
    }
    
   
    
    

    
    
    public static function getTotwidth($UserID,$parentID){
      $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$parentID,'withdrawal_user_id'=>$UserID])->sum('amount');
      return $depParent;
    }
    

    public static function getUpperLevelEx($UserID){
      $user = User::where(['id'=>$UserID])->first();
      if($user->parent_id == 0){
        return 0;
      }
//      return self::getExAmountPerByUser($user->parent_id,'UPPERLEVEL');
    }
    
    
    public static function getExAmountPerByChild($UserID){
      $exAmtByParent = 0;
      $user = User::where(['id'=>$UserID])->first();
      $parentPer = $user->partnership;
      $parentUser = User::where(['parent_id'=>$UserID])->get();
      foreach($parentUser as $uKey=>$childUsers){
        if(strtoupper($childUsers->roles->first()->name) == 'USER'){
          $exAmtByParent += MyBetsController::getExAmount('',$childUsers->id);
        }else{
          $exAmtByChild = self::getExAmountPerByChild($childUsers->id);
          if($childUsers->parent_id == AuthNew::user()->id){
            $childPer = $childUsers->partnership;
            $currentDiffPer = ($parentPer-$childPer);
            $exAmtByParent += (($exAmtByChild*$currentDiffPer)/100);
          }else{
            $exAmtByParent +=$exAmtByChild;
          }
        }
      }
      return $exAmtByParent;
     }

    public static function getUserPartnershipPer($userID,$downLinkper = 0,$parentCount = 0){
      $userModel = User::find($userID);
      $userData = array();
      $realCurrent = ($userModel->partnership-$downLinkper);
      if($parentCount == 1){
        $userData[$userID]['realCurrent'] = $userModel->partnership;
        $userData[$userID]['current'] = $userModel->partnership;
        $userData[$userID]['downlink'] = $downLinkper;
      }else{
        $userData[$userID]['realCurrent'] = $realCurrent;
        $userData[$userID]['current'] = $userModel->partnership;
        $userData[$userID]['downlink'] = $downLinkper;
      }
      
      
      if($userModel->parent_id != 0){
        $parentCount++;
        $data = self::getUserPartnershipPer($userModel->parent_id,$userModel->partnership,$parentCount);
        foreach($data as $user=>$users){
          $userData[$user] = $users;
        }
      }
      return $userData;
    } 

    
    
    

    public function userchangepassword(){
      if(strtoupper(Auth::user()->roles->first()->name) == 'ADMINISTRATOR'){
        return view('backend.changepasswordadmin');
      }else{
       return view('backend.changepassword');
      }
    }
    
    public function addnewprivilege(){
      
      return view('backend.list-client.addnewprivilege');
    }
    
    public function userchangepasswordstore(Request $request){
      
      $requestData = $request->all();
      $userId = Auth::user()->id;
      
      $m_pwd =  $requestData['old_password'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.userchangepassword')->withFlashSuccess('old Password Wrong');
      }
      
      if($requestData['new_password'] != $requestData['c_password']){
        return redirect()->route('admin.userchangepassword')->withFlashSuccess('Password Not Match');
      }
      $model = User::where(['id'=>$userId])->first();
      $model->password = Hash::make($requestData['new_password']);
      $model->isChangePassParent = 0;
      if($model->save()){
        return redirect()->route('frontend.auth.logout')->withFlashSuccess('User Password Updated successfully');
      }else{
        return redirect()->route('admin.userchangepassword')->withFlashSuccess('User Password Not Updated');
      }
    }
    public function userclientrows(Request $request){
      $roleArr = array('administrator'=>'SUPER ADMIN','admin'=>'ADMIN','subadmin'=>'SMDL','supermaster'=>'MDL','master'=>'DL','user'=>'USER');
      $requestData = $request->all();
      $userID = $requestData['userid'];
      $client = User::where(['uuid'=>$userID])->first();
      $parentID = $client->parent_id;
      $isParent = false;
      if($client->parent_id == Auth::user()->id){
      $isParent = true;
      }
      $options = view("backend.list-client.list-client-row",compact('client','parentID','roleArr','isParent'))->render();
      return $options;
    }
    
    
    function listchild($uuid){
      $roleArr = array('administrator'=>'SUPER ADMIN','admin'=>'ADMIN','subadmin'=>'SMDL','supermaster'=>'MDL','master'=>'DL','user'=>'USER');
      $client = User::where(['uuid'=>$uuid])->first();
      $parentID = AuthNew::user()->id;
      $clients = User::where(['parent_id'=>$client->id])->get();
      $isParent = false;
      return view('backend.list-client.list-client', compact('clients','parentID','roleArr','isParent'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addaccount()
    {
      
      $roles = array();
      $maxUser = 12;
      switch (Auth::user()->roles->first()->name){
        case 'administrator':{
          $userCount = self::getuserCount('admin');
          if($userCount < $maxUser){
            $roles['admin'] = 'ADMIN';
          }
          
          $userCount = self::getuserCount('subadmin');
          if($userCount < $maxUser){
            $roles['subadmin'] = 'SMDL';
          }
          $userCount = self::getuserCount('supermaster');
          if($userCount < $maxUser){
            $roles['supermaster'] = 'MDL';
          }
          $userCount = self::getuserCount('master');
          if($userCount < $maxUser){
            $roles['master'] = 'DL';
          }
          
          $roles['user'] = 'USER';
          break;
        }
        case 'admin':{
          $userCount = self::getuserCount('subadmin');
          if($userCount < $maxUser){
            $roles['subadmin'] = 'SMDL';
          }
          $userCount = self::getuserCount('supermaster');
          if($userCount < $maxUser){
            $roles['supermaster'] = 'MDL';
          }
          $userCount = self::getuserCount('master');
          if($userCount < $maxUser){
            $roles['master'] = 'DL';
          }
          $roles['user'] = 'USER';
          break;
        }
        case 'subadmin':{
          $userCount = self::getuserCount('supermaster');
          if($userCount < $maxUser){
            $roles['supermaster'] = 'MDL';
          }
          $userCount = self::getuserCount('master');
          if($userCount < $maxUser){
            $roles['master'] = 'DL';
          }
          $roles['user'] = 'USER';
          break;
        }
        case 'supermaster':{
          $userCount = self::getuserCount('master');
          if($userCount < $maxUser){
            $roles['master'] = 'DL';
          }
          $roles['user'] = 'USER';
          break;
        }
        case 'master':{
          $roles['user'] = 'USER';
          break;
        }
      }
      $loginUserModel = User::find(Auth::user()->id);
      return view('backend.list-client.add-account', compact('roles','loginUserModel'));
    }
    public static function getuserCount($roleName){
      $sql = "SELECT COUNT(r.id) as tot 
                      FROM `roles` r
                      JOIN model_has_roles mhr ON(mhr.role_id = r.id)
                      JOIN users u ON(u.id = mhr.model_id)
                      WHERE u.parent_id ='".Auth::user()->id."' AND r.name = '".$roleName."'
                      GROUP BY r.id";
      $roleCountArr = DB::select($sql);
      if(!isset($roleCountArr[0]->tot)){
        return 0;
      }
      return $roleCountArr[0]->tot;
    }

    public function checkusername(Request $request){
      $requestData = $request->all();
      
      $loginUser = User::where(['first_name'=>$requestData['username']])->first();
      if(isset($loginUser->id) && $loginUser->id > 0){
        return json_encode(array('status'=> false));
      }
      return json_encode(array('status'=> true));
    }

    public function deposit(Request $request)
    {
      $requestData = $request->all();
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $depositeUser = User::where(['uuid'=>$userID])->first();
      $loginUser = User::where(['id'=>$depositeUser->parent_id])->first();
      $mainCal = self::getMainCal($depositeUser->parent_id);
      
      $options = view("backend.list-client.deposite",compact('loginUser','depositeUser','mainCal'))->render();
      return $options;
    }
    
    public function withdraw(Request $request)
    {
      $requestData = $request->all();
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $depositeUser = User::where(['uuid'=>$userID])->first();
      $loginUser = User::where(['id'=>$depositeUser->parent_id])->first();
      //dd($loginUser);
      $mainCal = self::getMainCal($depositeUser->parent_id);
      
      $options = view("backend.list-client.withdraw",compact('loginUser','depositeUser','mainCal'))->render();
      return $options;
    }
    
    public function userlimit(Request $request)
    {
      $requestData = $request->all();
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $depositeUser = User::where(['uuid'=>$userID])->first();
      
      $options = view("backend.list-client.userlimit",compact('depositeUser'))->render();
      return $options;
    }
    
    public function userlimitstore(Request $request)
    {
      $requestData = $request->all();
      
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return json_encode(array('status'=>false,'message'=>'Master Password Wrong'));
      }
      
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $model = User::where(['uuid'=>$userID])->first();
      $model->exposelimit = $requestData['exposelimit'];
      if($model->save()){
        return json_encode(array('status'=>true,'message'=>'Exposure Limit Updated'));
      }else{
        return json_encode(array('status'=>false,'message'=>'Exposure Limit Not Updated'));
      }
    }
    
    public function usercredit(Request $request)
    {
      $requestData = $request->all();
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $depositeUser = User::where(['uuid'=>$userID])->first();
      
      $options = view("backend.list-client.usercredit",compact('depositeUser'))->render();
      return $options;
    }
    
    public function usercreditstore(Request $request)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return json_encode(array('status'=>false,'message'=>'Master Password Wrong'));
      }
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $criditRefLogin = self::getCreditReferance($user->id,$user->parent_id);
      if($criditRefLogin < $requestData['credit_ref']){
        return json_encode(array('status'=>false,'message'=>'Insuficent Credit Referance'));
      }
      $model = User::where(['uuid'=>$userID])->first();
      $model->credit_ref = $requestData['credit_ref'];
      if($model->save()){
        return json_encode(array('status'=>true,'message'=>'Credit Referance Limit Updated'));
      }else{
        return json_encode(array('status'=>false,'message'=>'Credit Referance Limit Not Updated'));
      }
    }
    
    public function userstatusview(Request $request){
      $requestData = $request->all();
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $depositeUser = User::where(['uuid'=>$userID])->first();
      
      $options = view("backend.list-client.userstatusview",compact('depositeUser'))->render();
      return $options;
    }
    public static function getActiveStatus($userID){
      $userModel = User::find($userID);
      if($userModel->active == 0){
        return true;
      }
      if($userModel->parent_id != 0){
        $data = self::getActiveStatus($userModel->parent_id);
        if($data){
          return true;
        }
      }
      return false;
    }
    public static function logoutChildUser($userID){
    
      $model = User::where(['parent_id'=>$userID])->get();
      $userArr = array();
      foreach($model as $key=>$user){
          $user->to_be_logged_out = 1;
          $user->save();
          $data = self::logoutChildUser($user->id);
      }
    } 
    public function userstatuschange(Request $request)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return json_encode(array('status'=>false,'message'=>'Master Password Wrong'));
      }
      $userID = $requestData['userid'];
      if(empty($userID)){
         return '';
      }
      $model = User::where(['uuid'=>$userID])->first();
      $model->active = $requestData['isActive'];
      $model->betActive = $requestData['isBetActive'];
      if($requestData['isActive'] != 1){
        $model->to_be_logged_out = 1;
        self::logoutChildUser($model->id);
      }
      if($model->save()){
        return json_encode(array('status'=>true,'message'=>'User Status Updated'));
      }else{
        return json_encode(array('status'=>false,'message'=>'User Status Not Updated'));
      }
    }
    
    public function updatePassword(Request $request){
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return json_encode(array('status'=>false,'message'=>'Master Password Wrong'));
      }
      $userID = $requestData['userid'];
      $model = User::where(['uuid'=>$userID])->first();
      $model->password = Hash::make($requestData['password']);
      $model->isChangePassParent = 1;
      if($model->save()){
        return json_encode(array('status'=>true,'message'=>'User Password Updated'));
      }else{
        return json_encode(array('status'=>false,'message'=>'User Password Not Updated'));
      }
    }

    public function minmaxbet($uuid)
    {
      $client = User::where(['uuid'=>$uuid])->first();
      return view('backend.list-client.minmaxbet', compact('client'));
    }
    public function minmaxstore(Request $request,$uuid)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.client.minmaxbet',$uuid)->withFlashSuccess('Master Password Wrong');
      }
      $model = User::where(['uuid'=>$uuid])->first();
      $model->last_name = $request->input('last_name');
      $model->phone = $request->input('phone');
      $model->minbet_cricket = $request->input('minbet_cricket');
      $model->minbet_football = $request->input('minbet_football');
      $model->minbet_tennic = $request->input('minbet_tennic');
      $model->maxbet_cricket = $request->input('maxbet_cricket');
      $model->maxbet_football = $request->input('maxbet_football');
      $model->maxbet_tennic = $request->input('maxbet_tennic');
      $model->delay_cricket = $request->input('delay_cricket');
      $model->delay_football = $request->input('delay_football');
      $model->delay_tennic = $request->input('delay_tennic');
      $model->save();
      
      return redirect()->route('admin.list-client')->withFlashSuccess('user min max bet updated successfully');
    }
    
    
    
    /*************** NEW CAL FUNCTION WITH PANKAJ BHAI  USER ROLE ****************/
    
    public static function getUserDepositeBalance($userID){
      $client = User::find($userID);
      $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id,'withdrawal_user_id'=>$client->parent_id])->sum('amount');
//      $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id])->sum('amount');
//      $depTot = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id])->sum('amount');
      $widTotParent = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id,'deposite_user_id'=>$client->parent_id])->sum('amount');
      $depParent = $depParent-$widTotParent;
      
      return $depParent;
    } 
    
    public static function getUserPLBalance($userID){
      $client = User::find($userID);
      $depParent = self::getUserDepositeBalance($userID);
      $pLTot = ($depParent-$client->credit_ref);
      
      return $pLTot;
    }
    
    public static function getUserAvalableBalance($userID){
      $depParent = self::getUserDepositeBalance($userID);
      $exposureTot = self::getExAmountPerByUser($userID);
      $avBTot = ($depParent-$exposureTot);
      
      return $avBTot;
    }
    
    public static function getExAmountPerByUser($UserID,$isParent = false){
      $exAmtByParent = 0;
      $user = User::where(['id'=>$UserID])->first();
      $userParent = User::where(['id'=>$user->parent_id])->first();
      if(strtoupper($user->roles->first()->name) == 'USER'){
        return MyBetsController::getExAmount('',$UserID);
      }
      if(!is_object($userParent)){
        return 0;
      }
      $exAmtByParent = self::getExAmountPerByChild($UserID);
      if(strtoupper($userParent->roles->first()->name) == 'ADMINISTRATOR'){
        $parentPer = (100-$user->partnership);
      }else{
        $parentPer = ($userParent->partnership-$user->partnership);
      }
      return (($exAmtByParent*$parentPer)/100);
    }
    
    /********************* GET DL CAL FUNCTION*************************/
    
    public static function getAgentUpperLevel($userID){
     return DB::table('upper_level_down_levels')->where(['user_id'=>$userID,'active'=>1])->sum('upperLevel');
    }
    
    public static function getProfitLossDL($userID,$isActive = 1){
        $upl = DB::table('upper_level_down_levels')->where(['user_id'=>$userID,'active'=>$isActive])->sum('upperLevel');
     
        return ($upl*(-1));
    }
    public static function getUPlevalMainCal($userID,$childID){
        $model = User::find($userID);
        $tot = 0;
        $childArr = \App\Http\Controllers\Backend\AccountsController::getChildUserListArr($childID);
        $uplArr = \App\UpperLevelDownLevel::where(['user_id'=>$userID,'active'=>1])->get();
//        dd($uplArr);
        
            foreach($uplArr as $k=>$upl){
                if(!in_array($upl->user_id,$childArr) ){
                    continue;
                }
                if($upl->downLevel >= 0){
                   $tot += $upl->downLevel;
                }else{
                   $tot -= abs($upl->downLevel); 
                }
                if($upl->downLevel >= 0){
                    $tot += $upl->downLevel;
                }else{
                    $tot -= abs($upl->downLevel); 
                }
            }
        return $tot;
    }
    public static function getGetUserUpperLevalAmount($userID,$childID,$isParent = false){
        
        $model = User::find($userID);
        $tot = 0;
        if(strtoupper($model->roles->first()->name) == 'ADMINISTRATOR' && $isParent == false){
            $modelChild = User::where(['parent_id'=>$userID])->get();
            foreach($modelChild as $key=>$childUser){
                if($childID != $childUser->id){
                    continue;
                }
                $uplArr = \App\UpperLevelDownLevel::where(['user_id'=>$childUser->id,'active'=>1])->get();
                foreach($uplArr as $k=>$upl){
                    if($upl->upperLevel >= 0){
                       $tot += $upl->upperLevel;
                    }else{
                       $tot -= abs($upl->upperLevel); 
                    }
                }
            }
        }else{
//        else if(strtoupper($model->roles->first()->name) == 'ADMINISTRATOR' && $isParent == true){
//            $childUserArr = AccountsController::getChildUserListArr($childID);
//                $uplArr = \App\UpperLevelDownLevel::where(['user_id'=>$userID,'active'=>1])->get();
//                foreach($uplArr as $k=>$upl){
//                    if(!in_array($upl->bet_user_id,$childUserArr)){
//                        continue;
//                    }
//                    if($upl->upperLevel >= 0){
//                       $tot += $upl->upperLevel;
//                    }else{
//                       $tot -= abs($upl->upperLevel); 
//                    }
//                    if($isParent){
//                        if($upl->downLevel >= 0){
//                           $tot += $upl->downLevel;
//                        }else{
//                           $tot -= abs($upl->downLevel); 
//                        }
//                    }
//                }
//        }else{
            $uplArr = \App\UpperLevelDownLevel::where(['user_id'=>$userID,'active'=>1])->get();
//            dd($uplArr);
            $childUserArr = AccountsController::getChildUserListArr($childID);
            foreach($uplArr as $k=>$upl){
                if(!in_array($upl->bet_user_id, $childUserArr)){
                    continue;
                }
                if($upl->upperLevel >= 0){
                   $tot += $upl->upperLevel;
                }else{
                   $tot -= abs($upl->upperLevel); 
                }
                if($isParent){
                    if($upl->downLevel >= 0){
                       $tot += $upl->downLevel;
                    }else{
                       $tot -= abs($upl->downLevel); 
                    }
                }
            } 
        }
        return $tot;
    }
    
    public static function getPLBalance($userID){
      $model = User::find($userID);
      $dep = self::getDepositeBalnceDL($userID);
      $plAmt = $dep-$model->credit_ref;
//      dd($dep."=".$plAmt);
      return $plAmt;
    }

    public static function getUserAvalableBalanceDL($userID){
      $depParent = self::getDepositeBalnceDL($userID);
      $exposureTot = self::getExAmountPerByUser($userID);
      $avBTot = ($depParent-$exposureTot);
      $avBTot -= self::getChildAvalableBalanceDL($userID);
      
      return $avBTot;
    }
    public static function getChildAvalableBalanceDL($userID){
      $model = User::where(['parent_id'=>$userID])->get();
      $avBTot = 0;
      foreach($model as $key=>$user){
        $depParent = self::getDepositeBalnceDL($user->id);
        $exposureTot = self::getExAmountPerByUser($user->id);
        $avBTot += ($depParent-$exposureTot);
      }
      return $avBTot;
    }

    public static function getDepositeBalnceDL($userID){
      $client = User::find($userID);
      $depParent = DB::table('user_deposites')->where(['deposite_user_id'=>$client->id,'withdrawal_user_id'=>$client->parent_id])->sum('amount');
      $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$client->id,'deposite_user_id'=>$client->parent_id])->sum('amount');
      $pldeposite = self::getProfitLossDL($userID,0);
      $depParent = $depParent-$widTot;
      $depParent += $pldeposite;
      $pl = self::getProfitLossDL($userID);
//      dd($depParent."==".$widTot."==".$pl."==".$pldeposite);
      if($pl > 0){
        $depParent += $pl;
      }else{
        $depParent -=abs($pl);
      }
      return $depParent;
    }
    
    /************** MAIN CLIENT DETAIL CAL ***************/
    
     public static function getMainCal($userId){
      $loginModel  = User::find($userId);
      /* USER MASTER BALANCER */
      $mainCalArr['MasterBalance'] = self::getCreditReferance($loginModel->id,$loginModel->parent_id);

      /*** USER CREDIT LIMIT ****/
      $mainCalArr['CreditReferance'] = $loginModel->credit_ref;
      
      /*** Down level Occupy Balance ****/
      
      $mainCalArr['DownLevelOccupyBalance'] = self::getUserDownLevelBalance($userId);
      
      /** USER UPPER LEVEL AMOUNT**/
      
      if(Auth::user()->roles->first()->name == 'administrator'){
        $mainCalArr['UpperLevel'] =  '0';
        
      }else{
//        $mainCalArr['UpperLevel'] =  self::getProfitLossDL($loginModel->id);
        $mainCalArr['UpperLevel'] =  self::getGetUserUpperLevalAmount($loginModel->parent_id,$loginModel->id,true);
//        dd($mainCalArr);
        /*** MASTER BALANCE SUB UPPER LEVEL BALANCE ****/
        if($mainCalArr['UpperLevel'] >= 0){
          $mainCalArr['MasterBalance'] += $mainCalArr['UpperLevel'];
        }else{
            if($mainCalArr['UpperLevel'] != 0){
                $mainCalArr['MasterBalance'] -= abs($mainCalArr['UpperLevel']);
            }
        }
//        $mainCalArr['MasterBalance'] = $mainCalArr['MasterBalance'];
          
        $mainCalArr['UpperLevel'] = ($mainCalArr['MasterBalance']-$mainCalArr['CreditReferance']);
        
      }
      if($mainCalArr['UpperLevel'] == 0){
        $plTot = self::getAgentAvailableBalanceWithPL($loginModel->id);
        if(Auth::user()->roles->first()->name == 'administrator'){
//          $plTot = ($plTot-$loginModel->myProfitLoss);
          $mainCalArr['AvailableBalanceWithProfitLoss'] = $plTot;
          $mainCalArr['MyProfitLoss'] = self::getMyProfit($userId);
        }else{
          $mainCalArr['AvailableBalanceWithProfitLoss'] = $plTot;
          $mainCalArr['MyProfitLoss'] = self::getMyProfit($userId);
        }
      }else{
        $ABPLamt = self::getAgentAvailableBalanceWithPL($userId);
        $mainCalArr['AvailableBalanceWithProfitLoss'] =  $ABPLamt;
        $mainCalArr['MyProfitLoss'] = self::getMyProfit($userId);
      }
      $mainCalArr['MyProfitLoss'] = ($mainCalArr['MyProfitLoss']*(-1));
      $mainCalArr['DownLevelCreditReferance'] = self::getDownLevelCreditReferance($userId);
      
      $mainCalArr['AvailableBalance'] = ($mainCalArr['MasterBalance']-$mainCalArr['DownLevelOccupyBalance']);
      
      
      /**** DOWN LEVEL PROFIT BALANCE ******/
      
      $DownLevelProfitLoss = ($mainCalArr['DownLevelCreditReferance']-$mainCalArr['DownLevelOccupyBalance']);
      
      $mainCalArr['DownLevelProfitLoss'] = $DownLevelProfitLoss;
      
      if($loginModel->parent_id > 0){
        $parentUserModel  = User::find($loginModel->parent_id);
        $patnership = ($parentUserModel->partnership-$loginModel->partnership);
        $patnership = $loginModel->partnership;
        $mainCalArr['FixedLoss'] = (($mainCalArr['CreditReferance']*($patnership))/100);
      }else{
        $mainCalArr['FixedLoss'] = 0;
      }
      $mainCalArr['FixedLoss'] = 0;
      
      return $mainCalArr;
    }
    
    public static function getUserDownLevelBalance($userID){
      $tot = 0;
      $parentUser = User::where(['parent_id'=>$userID])->get();
      foreach($parentUser as $uKey=>$childUsers){
        $tot += self::getDepositeBalnceDL($childUsers->id);
      }
      return $tot;
    }
}
