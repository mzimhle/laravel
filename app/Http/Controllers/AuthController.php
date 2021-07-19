<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Library\Classes\SMS;
use App\Rules\RSAnumber;

class AuthController extends Controller
{ 
	private $sms;
    /**
     * Constructor for this class
     *
     */	
    public function __construct(SMS $sms)
    {
		$this->sms = $sms;
	}
    /**
     * The page to display before loggin in.
     *
     */	
    public function index()
    {
        return view('index');
    }
    /**
     * The page to display before loggin in.
     *
     */	
    public function login()
    {
        return view('login');
    }
    /**
     * Landing page to display registration
     *
     */
    public function register()
    {
        return view('register');
    }
    /**
     * Landing page to display registration
     *
     */
    public function forgot()
    {
        return view('forgot');
    }	
    /**
     * The page to submit to via the login form.
     *
     */
    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = $request->only('email', 'password');
		// N.B.
		// Email will be used to get the row, then aferwards the received row's password will be checked against hashed password.
		// The second parameter for attempt is to store the "remember me" token.
        if (Auth::attempt($credentials, 1)) {
			// We want to avoid Session Fixation, check https://en.wikipedia.org/wiki/Session_fixation
			$request->session()->regenerate();
			// Lets go to the home page.
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    /**
     * Submission page for registration
     *
     */	
    public function submitRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admin',
			'cellphone' => ['required', 'unique:admin', new RSAnumber],
            'password' => 'required',
			'password_retype' => 'required|same:password',
        ]);

        $data = $request->all();
		// Insert data.
		$admin = Admin::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'cellphone' => $data['cellphone'],
			'password_clear' => $data['password'],
			'password' => Hash::make($data['password'])		
		]);		
		// check if we got a user created.
		if($admin) {
			// Send out an SMS to the admin.
			$this->sms->smsAdmin($admin);
		}
		
        return redirect("/")->withSuccess('You have signed-in');
    }
    /**
     * Submission page for registration
     *
     */	
    public function submitForgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

		$admin = Admin::where('email', $request->input('email'))->first();
		//Check if the user exists
		if (!$admin) {
			return redirect()->back()->withErrors(['email' => trans('Admin does not exist')]);
		}
		// P.S. YOU CANNOT UNHASH A PASSWORD
		return redirect()->back()->with('message', 'Your password is '.$admin->password);
    }
    /**
     * Logout page
     *
     */	
    public function logout(Request $request) {
        Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
        return Redirect('login');
    }	
}
