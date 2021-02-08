<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Permission;
use Sentinel;

class PermissionController extends Controller
{
    public function index()
    {
        return view('backend.user_management.permission.index');
    }

    public function getPermissions(Request $request)
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

        $permission = new Permission();
        // Total records
        $totalRecords = Permission::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $permission->countFilterRecords($searchValue);


        // Fetch records
        $records = $permission->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "date" => Carbon::parse($record->created_at)->format('Y-m-d H:i:s'),
                "update" => Sentinel::getUser()->hasAccess('permission.update'),
                "delete" => Sentinel::getUser()->hasAccess('permission.delete'),
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
        return view('backend.user_management.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $slug = Str::slug($request->name, '-');
        Permission::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->route('permission.index')->with('success','Permission create successfully');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('backend.user_management.permission.edit',compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Permission::find($id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('permission.index')->with('success','Permission updated successfully');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return response()->json([
            'success' => 'Permission Deleted Successfully!'
        ]);
    }
}
