<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Hash;

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
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    public function locked()
    {
        if (!session('lock-expires-at')) {
            return redirect('/');
        }

        if (session('lock-expires-at') > now()) {
            return redirect('/');
        }

        return view('lockscreens');
    }

    public function unlock(Request $request)
    {
        $check = Hash::check($request->input('password'), $request->user()->password);

        if(!$check){
            return redirect()->route('login.locked')->with('errors','Password salah!');
        }

        //session()->forget('lock-expires-at');
        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);

        return redirect(session('last_url') );
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('lock-expires-at');
        return redirect()->route('login');
    }

    public function username()
    {
        return 'nip';
    }

    public function authenticated(Request $request)
    {
        $validator = $request->validate([
            'nip' => 'required',
            'password' => 'required|min:5'
        ]);

        if (Auth::attempt($validator)) {
            return redirect('/home');
        }
    }
}
