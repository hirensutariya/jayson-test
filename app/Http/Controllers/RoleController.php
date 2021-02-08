<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Permission;
use Sentinel;

class RoleController extends Controller
{
    public function index()
    {
        return view('backend.user_management.role.index');
    }

    public function getRoles(Request $request)
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

        $role = new Role();
        // Total records
        $totalRecords = Role::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $role->countFilterRecords($searchValue);


        // Fetch records
        $records = $role->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "date" => Carbon::parse($record->created_at)->format('Y-m-d H:i:s'),
                "update" => Sentinel::getUser()->hasAccess('role.update'),
                "delete" => Sentinel::getUser()->hasAccess('role.delete'),
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
//        $pemissionList = Permission::get();
//        return view('backend.user_management.role.create',compact('pemissionList'));
        return view('backend.user_management.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

//        $permissions = array_keys($request->permissions);
//        $permissionsModel = Permission::whereIn('id',$permissions)->get();

		$role = new Role();
		$role->name = $request->name;
		$role->slug = Str::slug($request->name, '-');
		$role->save();
//		$role->permissions()->attach($permissionsModel);

        return redirect()->route('role.index')->with('success','Role create successfully');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        //$role = Role::with('permissions')->find($id);
        $role = Role::find($id);
//        $permissionList = Permission::get()->toArray();

//        return view('backend.user_management.role.edit',compact('role','permissionList'));
        return view('backend.user_management.role.edit',compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::find($id)->update([
            'name' => $request->name
        ]);

//        if(isset($request->permissions) && count($request->permissions)>0)
//        {
//            $permissions = array_keys($request->permissions);
//
//            $permissionsModel = Permission::whereIn('id',$permissions)->get();
//            DB::table('roles_permissions')->where('role_id',$id)->delete();
//            $newRole = Role::find($id);
//            $newRole->permissions()->attach($permissionsModel);
//        }
//        else
//        {
//            if(is_null($request->permissions))
//            {
//                DB::table('roles_permissions')->where('role_id',$id)->delete();
//            }
//        }

        return redirect()->route('role.index')->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        DB::table('role_users')->where('role_id',$id)->delete();

        $role->delete();

        return response()->json([
            'success' => 'Role Deleted Successfully!'
        ]);
    }
}
