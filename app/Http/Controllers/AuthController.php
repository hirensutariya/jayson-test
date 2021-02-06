<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Traits\ThrottlesLogins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{

   // use AuthenticatesUsers;
    use ThrottlesLogins;
    public $maxAttempts = 3;
    public $decayMinutes = 1;

    public function username()
    {
        return 'email';
    }

    public function loginPage()
    {
      return view( 'backend.login');
    }

    public function loginProccess(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191',
            'password' => 'required|max:191',
        ]);


        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            //Fire the lockout event.
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.

            $notification = ['message' => $this->sendLockoutResponse($request), 'type' => 'danger'];
            return redirect()->route('backend.user.login')->with($notification);

        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()
                ->intended(route('backend.dashboard'))
                ->with('status', 'You are Logged in as Admin!');
        } else {
            $this->incrementLoginAttempts($request);

            $notification = ['message' => "authentication failed", 'type' => 'danger'];
            return redirect()->route('backend.user.login')->with($notification);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('backend.user.login');
    }
}
