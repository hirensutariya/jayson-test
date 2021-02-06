<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $searchstr = $request->searchstr;
        $department = $request->department;

        $employeeList = Employee::with('department');

        if(isset($searchstr) && $searchstr != "")
        {
            $employeeList->where('first_name','LIKE',"$searchstr%");
        }

        if(isset($department) && $department != "")
        {
            $employeeList->where('department_id',$department);
        }

        //$employeeList = $employeeList->get();
        $employeeList = $employeeList->paginate(10);
        return response()->json([
            'message' => 'employee details get successfully',
            'data' => $employeeList
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|alpha',
            'middle_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'address' => 'required',
            'department_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'zipcode' => 'required|numeric',
            'birthdate' => 'required',
            'date_hired' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'success'=>false
            ]);
        } else{

            Employee::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'department_id' => $request->department_id,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'zipcode' => $request->zipcode,
                'birthdate' => $request->birthdate,
                'date_hired' => $request->date_hired,
            ]);

            return response()->json([
                'message' => 'employee details create successfully',
                'success' => true
            ]);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json([
            'message' => 'employee details get successfully',
            'data' => $employee
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|alpha',
            'middle_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'address' => 'required',
            'department_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'zipcode' => 'required|numeric',
            'birthdate' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'success'=>false
            ]);
        } else{

            Employee::find($id)->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'department_id' => $request->department_id,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'zipcode' => $request->zipcode,
                'birthdate' => $request->birthdate,
            ]);

            return response()->json([
                'message' => 'employee details update successfully',
                'success' => true
            ]);
        }
    }

    public function destroy($id)
    {
        $employee = Employee::find($id)->delete();
        return response()->json([
            'message' => 'employee delete successfully',
            'data' => $employee
        ]);
    }

    public function getAllEmployee()
    {
        $employee = Employee::orderBy('last_name')->get();
        return response()->json([
            'message' => 'get all employee successfully',
            'data' => $employee
        ]);
    }
}
