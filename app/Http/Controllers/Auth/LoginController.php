<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Institute;
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


    public function farmerlogin(){
        return view('auth.farmerLogin');
    }

    public function broadCastlogin(){
        return view('auth.broadcastLogin');
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
                return redirect("block-stock-details");
            }else if(Auth::user()->role_id==10){
                return redirect("district-stock-details");
            }else if(Auth::user()->role_id==8){
                return redirect("division-stock-details");
            }else if(Auth::user()->role_id==7){
                return redirect("zone-stock-details");
            }else if(Auth::user()->role_id==4){
                return redirect("farmer-dashboard");
            }else if(Auth::user()->role_id==3){
                return redirect("maitri-dashboard");
            }else if(Auth::user()->role_id==11){
                return redirect("broadcaster-dashboard");
            }else if(Auth::user()->role_id==12){
                return redirect("dfs-stock-form");
            }else if(Auth::user()->role_id==13){
                return redirect("admin-stock-form");
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



    public function instituteLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        // Find the Institute record by email
        $institute = Institute::where('email', $credentials['email'])->first();
        // Check password using Hash
        if ($institute && Hash::check($credentials['password'], $institute->password)) {
            // Add variable to the Institute model instance
            // Log the institute in using the webInstitute guard
            Auth::guard('institute_auth')->login($institute);
            // Login success: redirect to institute dashboard
            return redirect()->route('institute-dashboard');
        }else{

            return redirect()->route('login', ['isInstitute' => true])->with('error', 'You have entered invalid credentials');
        }

        // Login failed: redirect back to login with error
        return redirect("login")->with('error', 'You have entered invalid credentials');
    }
}
