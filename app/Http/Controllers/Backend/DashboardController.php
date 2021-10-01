<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminSetting;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
      return view('backend.dashboard');
    }
    
    public function adminsetting()
    {
      $model = AdminSetting::first();
      return view('backend.adminsetting', compact('model'));
    }
    
    public function adminsettingstore(Request $request)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.admin-setting')->withFlashSuccess('Master Password Wrong');
      }
      $model = AdminSetting::first();
      if(!is_object($model) || !$model->id){
        $model = new AdminSetting();
      }
      $model->admin_message = $request->input('admin_message');
      $model->user_message = $request->input('user_message');
      $model->maintanence = $request->input('maintanence');
      $model->maintanence_message = $request->input('maintanence_message');
      $model->save();
      
      $modelNew = AdminSetting::first();
      if($modelNew->maintanence == 1){
        $sql = "UPDATE `users` SET `to_be_logged_out`='1' WHERE `id` !='".Auth::user()->id."'";
        DB::table('users')
                ->where('id',"!=", Auth::user()->id)
                ->update(['to_be_logged_out' => 1]);
        /** ALL USER SESSION CLEAR **/
        $path = config('session.files');
        if (File::exists($path)) {
          $files =   File::allFiles($path);
          File::delete($files);
          error_log( count($files).' sessions flushed');
        } else {
          error_log('check your session path exists');
        }
      }
      return redirect()->route('admin.admin-setting')->withFlashSuccess('admin Setting save successfully');
    }
    
    public function managetv()
    {
      $model = AdminSetting::first();
      return view('backend.manageTV.addTVUrl', compact('model'));
    }
    
    public function managetvstore(Request $request)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.settingTvUrl')->withFlashSuccess('Master Password Wrong');
      }
      $model = AdminSetting::first();
      if(!is_object($model) || !$model->id){
        $model = new AdminSetting();
      }
      $model->TV_URL_1 = $request->input('TV_URL_1');
      $model->TV_URL_2 = $request->input('TV_URL_2');
      $model->TV_URL_3 = $request->input('TV_URL_3');
      $model->TV_URL_4 = $request->input('TV_URL_4');
      $model->save();
      
      return redirect()->route('admin.settingTvUrl')->withFlashSuccess('Tv URl save successfully');
    }
    
    public function privilege()
    {
      return view('backend.accounts.privilege');
    }
    
    public function privilegestore(Request $request)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.admin-setting')->withFlashSuccess('Master Password Wrong');
      }
      $model = AdminSetting::first();
      if(!is_object($model) || !$model->id){
        $model = new AdminSetting();
      }
      $model->admin_message = $request->input('admin_message');
      $model->user_message = $request->input('user_message');
      $model->maintanence = $request->input('maintanence');
      $model->maintanence_message = $request->input('maintanence_message');
      $model->save();
      
      return redirect()->route('admin.admin-setting')->withFlashSuccess('admin Setting save successfully');
    }
}
