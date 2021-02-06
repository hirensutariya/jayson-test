<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.system.departments.index');
    }

    public function getDepartments(Request $request)
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

        $department= new Department();
        // Total records
        $totalRecords = Department::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $department->countFilterRecords($searchValue);

        // Fetch records
        $departmentList = $department->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($departmentList as $department) {
            $data_arr[] = array(
                "id" => $department->id,
                "name" => $department->name,
                "date" => Carbon::parse($department->created_at)->format('Y-m-d H:i:s')
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.system.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $department = new Department();
        $checkExist =  $department->checkDepartmentExist($request->all());
        if($checkExist){
            return redirect()->route('departments.create')->with('error','Department already exist.');


        }else{
            Department::create($request->all());

            return redirect()->route('departments.index')->with('success','Department created successfully.');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        if($department){
            return view('backend.system.departments.edit',compact(['department']));
        }else{
            return view('backend.system.departments.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Department::find($id)->update([
            'name' => $request->get('name')
        ]);


        return redirect()->route('departments.index')
            ->with('success','Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();

        return response()->json([
            'success' => 'Department Deleted Successfully!'
        ]);
    }


    public function apiGetDepartments()
    {
        $departmentList = Department::get();
        return response()->json([
            'message' => 'department details get successfully',
            'data' => $departmentList
        ]);
    }
}
