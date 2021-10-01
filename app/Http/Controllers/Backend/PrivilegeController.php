<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Privilege;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Auth\Role;
use Auth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;

class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sql = "SELECT p.*,u.first_name as userName 
                      FROM `privileges` p 
                      LEFT JOIN users u ON (p.user_id = u.id)";
      $privilegeModel = DB::select($sql);
      return view('backend.privilege.index', compact('privilegeModel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $requestData = $request->all();
      $userModeOld = User::where(['first_name'=>$requestData['userName']])->first();
      if(isset($userModeOld) && $userModeOld->id > 0){
        return json_encode(array('status'=>false,'message'=>'User Name Allready Exist'));
      }else{
        $userModel = new User();
        $userModel->first_name = $requestData['userName'];
        $userModel->password = Hash::make($requestData['password']);
        $userModel->confirmed = 1;
        $userModel->save();
        $userID = $userModel->id;
        
        $role = Role::select("id")->where("name", "administrator")->first();
        $userModel->roles()->attach($role);

//        $sql = "INSERT INTO `model_has_permissions` (`permission_id`,`model_type`,`model_id`) VALUES ('1','App/\Models/\Auth/\User',".$userID.")";
//        DB::select($sql);

        $privilegeModel = new Privilege();
        $privilegeModel->user_id = $userID;
        $privilegeModel->parent_id = Auth::user()->id;
        if($privilegeModel->save()){
          return json_encode(array('status'=>true,'message'=>'User Create Successfully'));
        }else{
          return json_encode(array('status'=>false,'message'=>'User Not Created'));
        }
      }
    }
    
    public function storeprivilege(Request $request)
    {
      $requestData = $request->all();
      
      $userModeOld = Privilege::find($requestData['id']);
      if(isset($requestData['listClient'])){
        $userModeOld->listOfClient = $requestData['listClient'];
      }
      if(isset($requestData['mainMarket'])){
        $userModeOld->mainMarket = $requestData['mainMarket'];
      }
      if(isset($requestData['namageFancy'])){
        $userModeOld->manageFancy = $requestData['namageFancy'];
      }
      if(isset($requestData['fancyHistory'])){
        $userModeOld->fancyHistory = $requestData['fancyHistory'];
      }
      if(isset($requestData['matchHistory'])){
        $userModeOld->matchHistory = $requestData['matchHistory'];
      }
      if($userModeOld->save()){
        return json_encode(array('status'=>true,'message'=>'Status Change Successfully'));
      }else{
        return json_encode(array('status'=>false,'message'=>'Status Change Fails'));
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editprivilege(Request $request)
    {
       $requestData = $request->all();
       $model = Privilege::find($requestData['id']);
       $userModel = User::find($model->user_id);
       return json_encode(array('status'=>true,'name'=>$userModel->first_name));
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $requestData = $request->all();
      $userModel = User::where(['first_name'=>$requestData['userName']])->first();
      if(isset($userModel) && $userModel->id > 0){
        return json_encode(array('status'=>false,'message'=>'User Name  Allready Exist'));
      }else{
        $model = Privilege::find($requestData['id']);
        $userModel = User::find($model->user_id);
        $userModel->first_name = $requestData['userName'];
        if(!empty($requestData['id'])){
          $userModel->password = Hash::make($requestData['password']);
        }
        $userModel->save();
        return json_encode(array('status'=>true,'message'=>'User Updated Successfully'));
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $requestData = $request->all();
      if(isset($requestData['id'])){
        $privilegeModel = Privilege::find($requestData['id']);
        $userID = $privilegeModel->user_id;
        if($privilegeModel->delete()){
          $sqlPassHistory = "DELETE FROM password_histories WHERE `user_id`='".$userID."'";
          DB::select($sqlPassHistory);
          $sql = "DELETE FROM users WHERE `id`='".$userID."'";
          $privilegeModel = DB::select($sql);
          return json_encode(array('status'=>true,'message'=>'User Deleted Successfully'));
        }else{
          return json_encode(array('status'=>false,'message'=>'User Deleted Fails'));
        }
      }
    }
}
