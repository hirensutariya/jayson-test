<?php

namespace App\Http\Controllers;


use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.user_management.user.index');
    }

    public function getUsers(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $user = new User();
        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $user->countFilterRecords($searchValue);


        // Fetch records
        $records = $user->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "username" => $record->username,
                "firstname" => $record->first_name,
                "lastname" => $record->last_name,
                "email" => $record->email,
                "date" => Carbon::parse($record->created_at)->format('Y-m-d H:i:s')
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    public function create()
    {
        $permissionList = Permission::get();
        $roleList = Role::get();
        return view('backend.user_management.user.create',compact(['roleList','permissionList']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make('123456789')
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role
        ]);

        return redirect()->route('user.index')->with('success','User create successfully');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $user = User::with('role')->find($id);
        $permissionList = Permission::get();
        $roleList = Role::get();
        return view('backend.user_management.user.edit',compact('user','roleList','permissionList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);

        $user = User::find($id)->update([
            'username' => $request->username,
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email
        ]);


        $userRole = UserRole::where('user_id',$id)->get();
        if(isset($userRole) && count($userRole)>0)
        {
            UserRole::where('user_id',$id)->update([
                'role_id' => $request->role
            ]);
        }
        else
        {
            UserRole::create([
                'user_id' => $id,
                'role_id' => $request->role
            ]);
        }

        return redirect()->route('user.index')->with('success','User details updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'success' => 'User Deleted Successfully!'
        ]);
    }

    public function changePasswordPage()
    {
        return view('backend.user_management.user.change_password');
    }

    public function changePasswordProcess(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
        ]);

        $userId = Auth::user()->id;
        $user = User::find($userId);

        if(Hash::check($request->old_password, $user->password))
        {
            $user->password = Hash::make($request->password);
            if($user->save())
            {
                Auth::logout();
                $request->session()->flush();
                $request->session()->regenerate();
                $notification = ['message'=>"Password change successfully!",'type'=>'success'];
                return redirect()->route('backend.user.login')->with($notification);
            }
        }
        else
        {
            $notification = ['message'=>"Old Password was incorrect!",'type'=>'danger'];
            return redirect()->route('backend.user.change.password')->with($notification);
        }
    }

    public function Permission()
    {
        $permissionName = 'View Country';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Create Country';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Update Country';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Delete Country';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'View State';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Create State';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Update State';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Delete State';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'View City';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Create City';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Update City';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Delete City';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'View Department';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Create Department';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Update Department';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Delete Department';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'View Employee';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Create Employee';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Update Employee';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $permissionName = 'Delete Employee';
        $permission = new Permission();
        $permission->name = $permissionName;
        $permission->slug = Str::slug($permissionName, '-');
        $permission->save();

        $allPermission = Permission::all();
        $roleName = 'Super Admin';
        $role = new Role();
        $role->name = $roleName;
        $role->slug = Str::slug($roleName, '-');
        $role->save();
        $role->permissions()->attach($allPermission);

        $user = new User();
        $user->username = 'superadmin';
        $user->first_name = 'superadmin';
        $user->last_name = 'superadmin';
        $user->email = 'superadmin@gmail.com';
        $user->password = bcrypt('admin@123');
        $user->save();
        $user->roles()->attach($role);
        $user->permissions()->attach($allPermission);
    }
}
