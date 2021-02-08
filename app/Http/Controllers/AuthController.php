<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Traits\ThrottlesLogins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Sentinel;


class AuthController extends Controller
{

   // use AuthenticatesUsers;
    use ThrottlesLogins;
    public $maxAttempts = 3;
    public $decayMinutes = 1;

    public function username()
    {
        $field = (filter_var(request()->email, FILTER_VALIDATE_EMAIL) || !request()->email) ? 'email' : 'username';
        request()->merge([$field => request()->email]);
        return $field;
    }

    public function loginPage()
    {
        // $role = Sentinel::getRoleRepository()->createModel()->create([
        //     'name' => 'Super Admin',
        //     'slug' => 'super-admin',
        // ]);

        // $user = Sentinel::registerAndActivate([
        //     'first_name'    => 'Super Admin',
        //     'last_name'    => 'Super Admin',
        //     'username'    => 'superadmin',
        //     'email'    => 'superadmin@gmail.com',
        //     'password' => 'admin@123',
        // ]);

        // $role->users()->attach($user);

        // $user->permissions = [
        //     "countries.view" => true,
        //     "countries.create" => true,
        //     "countries.update" => true,
        //     "countries.delete" => true,

        //     "states.view" => true,
        //     "states.create" => true,
        //     "states.update" => true,
        //     "states.delete" => true,

        //     "cities.view" => true,
        //     "cities.create" => true,
        //     "cities.update" => true,
        //     "cities.delete" => true,

        //     "departments.view" => true,
        //     "departments.create" => true,
        //     "departments.update" => true,
        //     "departments.delete" => true,

        //     "employee.view" => true,
        //     "employee.create" => true,
        //     "employee.update" => true,
        //     "employee.delete" => true,

        //     "user.view" => true,
        //     "user.create" => true,
        //     "user.update" => true,
        //     "user.delete" => true,

        //     "role.view" => true,
        //     "role.create" => true,
        //     "role.update" => true,
        //     "role.delete" => true,

        //     "permission.view" => true,
        //     "permission.create" => true,
        //     "permission.update" => true,
        //     "permission.delete" => true,
        // ];

        // $user->save();


        // $role = Sentinel::getRoleRepository()->createModel()->create([
        //     'name' => 'User',
        //     'slug' => 'user',
        // ]);

        // $user = Sentinel::registerAndActivate([
        //     'first_name'    => 'User First Name',
        //     'last_name'    => 'User Last Name',
        //     'username'    => 'username',
        //     'email'    => 'user@gmail.com',
        //     'password' => 'user@123',
        // ]);

        // $role->users()->attach($user);

        // $user->permissions = [];

        // $user->save();

        return view( 'backend.login');
    }

    public function loginProccess(Request $request)
    {
        $request->validate([
            'username' => 'required|max:191',
            'password' => 'required|max:191',
        ]);

        $userList = User::where(['email'=>$request->username])->get();
        if(!empty($userList) && count($userList)>0)
        {
            $user = $userList->first();

            $credentials = [
                'email'    => $request->username,
                'password' => $request->password,
            ];

//            if(Hash::check($request->password, $user->password))
//            {
                try {
                    Sentinel::authenticate($credentials);

                    if( Sentinel::check() )
                    {
                        $notification = ['message'=>"user authenticate successfully",'type'=>'danger'];
                        return redirect()->route('backend.dashboard');
                    }
                    else
                    {
                        $notification = ['message'=>"authentication failed",'type'=>'danger'];
                        return redirect()->route('backend.user.login')->with($notification);
                    }
                } catch (\Exception $e){
                    $notification = ['message'=>$e->getMessage(),'type'=>'danger'];
                    return redirect()->route('backend.user.login')->with($notification);
                }

//            }
//            else
//            {
//                $notification = ['message'=>"credentials wrong",'type'=>'danger'];
//                return redirect()->route('backend.user.login')->with($notification);
//            }
        }
        else
        {
            $notification = ['message'=>"record not found",'type'=>'danger'];
            return redirect()->route('backend.user.login')->with($notification);
        }


        // //check if the user has too many login attempts.
        // if ($this->hasTooManyLoginAttempts($request)) {
        //     //Fire the lockout event.
        //     $this->fireLockoutEvent($request);

        //     //redirect the user back after lockout.

        //     $notification = ['message' => $this->sendLockoutResponse($request), 'type' => 'danger'];
        //     return redirect()->route('backend.user.login')->with($notification);

        // }
        // $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // if(auth()->attempt(array($fieldType => $request->username, 'password' => $request->password))){

        //     return redirect()
        //         ->intended(route('backend.dashboard'))
        //         ->with('status', 'You are Logged in as Admin!');
        // } else {
        //     $this->incrementLoginAttempts($request);

        //     $notification = ['message' => "authentication failed", 'type' => 'danger'];
        //     return redirect()->route('backend.user.login')->with($notification);
        // }
    }

    public function logout(Request $request)
    {
        Sentinel::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('backend.user.login');
    }
}
