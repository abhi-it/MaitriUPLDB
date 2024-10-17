<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('email', 'password');
        
        $UserKey = '';
		if(\Session::has('UserKey'))
		{
			$UserKey =  \Session::get('UserKey');
		}

        $credentials['password'] = $_POST['password'];
        $passwordIs = strstr($credentials['password'], $UserKey, true);
        $credentials['password'] = base64_decode($passwordIs);
        if (Auth::attempt($credentials)) {
            if(Auth::user()->role_id == 5){
                return redirect("deo-stock-details");
            }else if(Auth::user()->role_id==9){
                return redirect("block-inventory");
            }else if(Auth::user()->role_id==10){
                return redirect("district-inventory");
            }else if(Auth::user()->role_id==8){
                return redirect("division-inventory");
            }else if(Auth::user()->role_id==7){
                return redirect("zone-inventory");
            }else if(Auth::user()->role_id==4){
                return redirect("farmer-dashboard");
            }else if(Auth::user()->role_id==3){
                return redirect("maitri-dashboard");
            }else{
                return redirect("dashboard");
            }
        }
        return redirect("login")->withSuccess('You have entered invalid credentials');
    }
    
    protected function redirectTo()
    {
		return '/dashboard';
        
        /*if (auth()->user()->role == 'Admin') {
            
        }
        else if (auth()->user()->role == 'Superadmin') {
            return '/dashboard';
        }
        return '/home';*/
    }
}
