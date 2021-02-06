<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\States;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.system.cities.index');
    }

    public function getCities(Request $request)
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

        $city = new Cities();
        // Total records
        $totalRecords = Cities::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $city->countFilterRecords($searchValue);


        // Fetch records
        $allCities = $city->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($allCities as $city) {

            $data_arr[] = array(
                "id" => $city->id,
                "state" => $city->state->name,
                "name" => $city->name,
                "date" => Carbon::parse($city->created_at)->format('Y-m-d H:i:s')
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
        return view('backend.system.cities.create',compact(['countries']));
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
        $city = new Cities();
        $checkExist =  $city->checkStateExist($request->all());
        if($checkExist){
            return redirect()->route('cities.create')->with('error','City already exist of selected country.');

        }else{

            Cities::create(["state_id"=>$request->state,"name"=>$request->name]);
            return redirect()->route('cities.index')->with('success','City created successfully.');

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
        $city = Cities::find($id);

        if($city){
            $states = States::all();
            $getStateByCountry = States::find($city->state->id);
            $countries = Countries::all();

            return view('backend.system.cities.edit',compact(['states','city','countries','getStateByCountry']));
        }else{
            return view('backend.system.cities.index');
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
        $findState= States::find($request->state);

        Cities::find($id)->update([
            'name' => $request->get('name'),
            'state_id'=> $findState->id
        ]);
        return redirect()->route('cities.index')
            ->with('success','City updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $city = Cities::findOrFail($id);

        $city->delete();

        return response()->json([
            'success' => 'City Deleted Successfully!'
        ]);
    }

    public function apiGetCities(Request $request)
    {
        $stateId = (int) $request->state_id;
        $cityList = Cities::where('state_id',$stateId)->get();
        return response()->json([
            'message' => 'cities details get successfully',
            'data' => $cityList
        ]);
    }
}
