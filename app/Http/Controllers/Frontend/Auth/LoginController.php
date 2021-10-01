<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use Auth;
use App\AdminSetting;
use App\Models\Auth\User;
use App\Http\Controllers\Frontend\HomeController;
/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
      return route(home_route());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }
    
    public function showAdminLoginForm()
    {
        return view('frontend.auth.admin-login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
//    public function username()
//    {
//        return config('access.users.username');
//    }
    public function username()
    {
        return 'first_name';
    }
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => PasswordRules::login(),
            'g-recaptcha-response' => ['required_if:captcha_status,true', 'captcha'],
        ], [
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @throws GeneralException
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Check to see if the users account is confirmed and active
        if (! $user->isConfirmed()) {
            auth()->logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
            }

            // Otherwise see if they want to resent the confirmation e-mail

            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', e($user->{$user->getUuidName()}))]));
        }
        
        if (! $user->isActive()) {
            auth()->logout();
            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }
        $adminSetting = AdminSetting::first();
        if ($adminSetting->maintanence == "1") {
          if(Auth::user()->roles->first()->name != 'administrator'){
            auth()->logout();
            throw new GeneralException($adminSetting->maintanence_message);
          }
        }
        
        event(new UserLoggedIn($user));
        $parentStatus = HomeController::getActiveStatus(Auth::user()->id);
        if($parentStatus){
           auth()->logout();
           throw new GeneralException('Lock By Admin Contact Your Uplink');
        }
        switch (Auth::user()->roles->first()->name){
            case 'administrator':{
              return redirect()->route('admin.dashboard');
              die();
              break;
            }
            case 'admin':
            case 'subadmin':
            case 'supermaster':
            case 'master':{
              if(Auth::user()->isChangePassParent == 1){
                return redirect()->route('admin.userchangepassword');
              }else{
                auth()->logoutOtherDevices($request->password);
                return redirect()->route('admin.dashboard');
                die();
              }
              break;
            }
            default :{
              if(Auth::user()->isChangePassParent == 1){
                return redirect()->route('frontend.userchangepassword');
              }else{
                auth()->logoutOtherDevices($request->password);
                return redirect()->route('frontend.index');
                die();
              }
              break;
            }
        }
        
//        $nameRole = Auth::user()->roles->first()->name;
//        if($nameRole === 'administrator'){
//          auth()->logout();
//          throw new GeneralException('You can not access to login');
//        }
//        if($nameRole === 'administrator'){
//          auth()->logout();
//          throw new GeneralException('You can not access to login');
//        }
//        
//        
//        /** Logout Other device **/
//        switch (Auth::user()->roles->first()->name){
//            case 'admin':
//            case 'subadmin':
//            case 'supermaster':
//            case 'master':{
//              auth()->logout();
//              throw new GeneralException('You can not access to login');
//              break;
//            }
//            default :{
//              return redirect()->route('frontend.index');
//              return redirect()->intended($this->redirectPath());
//              die();
//              break;
//            }
//        }

    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Remove the socialite session variable if exists
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }
        
        // Fire event, Log out user, Redirect
        event(new UserLoggedOut($request->user()));
        
        // Laravel specific logic
        $this->guard()->logout();
        $request->session()->invalidate();
        
        return redirect()->route('frontend.index');
    }
}
