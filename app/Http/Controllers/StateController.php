<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\States;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.system.states.index');
    }

    public function getCountries(Request $request)
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

        $state = new States();
        // Total records
        $totalRecords = States::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $state->countFilterRecords($searchValue);


        // Fetch records
        $allState = $state->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($allState as $state) {
            $data_arr[] = array(
                "id" => $state->id,
                "country" => $state->country,
                "name" => $state->name,
                "date" => Carbon::parse($state->created_at)->format('Y-m-d H:i:s')
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
        $countries = Countries::all();
        return view('backend.system.states.create',compact(['countries']));
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
            'name' => 'required',
        ]);
        $state = new States();
        $checkExist =  $state->checkStateExist($request->all());
        if($checkExist){
            return redirect()->route('states.create')->with('error','State already exist of selected country.');

        }else{

            States::create(["country_id"=>$request->country,"name"=>$request->name]);

            return redirect()->route('states.index')->with('success','State created successfully.');

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
        $state = States::find($id);

        if($state){
            $countries = Countries::all();
            return view('backend.system.states.edit',compact(['state','countries']));
        }else{
            return view('backend.system.states.index');
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
        $getCountry = Countries::find($request->country);

        States::find($id)->update([
            'name' => $request->get('name'),
            'country_id'=> $getCountry->id
        ]);
        return redirect()->route('states.index')
            ->with('success','States updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $state = States::findOrFail($id);

        Cities::where('state_id',$id)->delete();

        $state->delete();

        return response()->json([
            'success' => 'State Deleted Successfully!'
        ]);
    }

    public function getCountryWiseStates(Request $request)
    {
        $getAllState = States::where('country_id',$request->id)->pluck("name","id");
        return response()->json($getAllState);

    }
    public function apiGetStates(Request $request)
    {
        $countryId = (int) $request->country_id;
        $stateList = States::where('country_id',$countryId)->get();
        return response()->json([
            'message' => 'states details get successfully',
            'data' => $stateList
        ]);
    }
}
