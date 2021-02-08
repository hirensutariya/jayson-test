<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Sentinel;

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
                "date" => Carbon::parse($record->created_at)->format('Y-m-d H:i:s'),
                "update" => Sentinel::getUser()->hasAccess('user.update'),
                "delete" => Sentinel::getUser()->hasAccess('user.delete'),
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
        return view('backend.user_management.user.create',compact('roleList','permissionList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

//        $user = User::create([
//            'username' => $request->username,
//            'first_name' => $request->firstname,
//            'last_name' => $request->lastname,
//            'email' => $request->email,
//            'password' => Hash::make($request->password)
//        ]);


        $user = Sentinel::registerAndActivate([
            'username' => $request->username,
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password
        ]);


        $spermissionList = [];
        foreach($request->selected_permissions as $spermission){
            $spermissionList[$spermission] = true;
        }

        $permissionList = Permission::select('slug')->get();
        $dbpermissionList = [];
        foreach($permissionList as $key => $dbpermission){
            $dbpermissionList[$dbpermission->slug] = false;
        }

        $result = array_merge($dbpermissionList, $spermissionList);

        $role = Sentinel::findRoleByName($request->role);
        $role->users()->attach($user);

        $user->permissions = $result;

        $user->save();

        return redirect()->route('user.index')->with('success','User create successfully');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        // $user = User::find($id);
        $user = Sentinel::findById($id);
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

        $spermissionList = [];
        if( $request->selected_permissions != "")
        {
            foreach($request->selected_permissions as $spermission){
                $spermissionList[$spermission] = true;
            }
        }

        $permissionList = Permission::select('slug')->get();
        $dbpermissionList = [];
        foreach($permissionList as $key => $dbpermission){
            $dbpermissionList[$dbpermission->slug] = false;
        }

        $result = array_merge($dbpermissionList, $spermissionList);

        $user = User::find($id)->update([
            'username' => $request->username,
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email
        ]);

        $user = Sentinel::findById($id);


        if(!empty($user->roles) && count($user->roles)>0)
        {
            $role = Sentinel::findRoleById($user->roles->first()->pivot->role_id);
            $role->users()->detach($user);
        }

        $newrole = Sentinel::findRoleByName($request->role);
        $newrole->users()->attach($user);

        $user->permissions = $result;

        $user->save();

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
}
