<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {

        $permissions = [
            "create" => Sentinel::getUser()->hasAccess('user.create'),
            "update" => Sentinel::getUser()->hasAccess('user.update'),
            "delete" => Sentinel::getUser()->hasAccess('user.delete'),
        ];

        return view('backend.employee.index',compact('permissions'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
