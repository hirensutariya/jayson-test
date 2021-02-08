<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Countries;
use Carbon\Carbon;
use Sentinel;

class CountriesController extends Controller
{
    public function index()
    {
        return view('backend.system.countries.index');
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

        $country = new Countries();
        // Total records
        $totalRecords = Countries::select('count(*) as allcount')->count();
        $totalRecordswithFilter = $country->countFilterRecords($searchValue);


        // Fetch records
        $records = $country->fetchFilterRecord($columnName,$columnSortOrder,$searchValue,$start,$rowperpage);
        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "code" => $record->code,
                "date" => Carbon::parse($record->created_at)->format('Y-m-d H:i:s'),
                "update" => Sentinel::getUser()->hasAccess('countries.update'),
                "delete" => Sentinel::getUser()->hasAccess('countries.delete'),
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
     * @return Response
     */
    public function create()
    {
        if (Sentinel::getUser()->hasAccess('countries.create'))
        {
            return view('backend.system.countries.create');
        }
        else
        {
            return "permission denial";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $country = new Countries();
        $checkExist =  $country->checkExist($request->all());
        if($checkExist){
            return redirect()->route('countries.create')->with('error','Country already exist.');


        }else{
            Countries::create($request->all());

            return redirect()->route('countries.index')->with('success','Country created successfully.');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $country = Countries::find($id);
        if ($country) {
            return view('backend.system.countries.edit', compact(['country']));
        } else {
            return view('backend.system.countries.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $share = Countries::find($id)->update([
            'name' => $request->get('name'),
            'code'=> $request->get('code')
        ]);

        return redirect()->route('countries.index')->with('success','Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $country = Countries::findOrFail($id);

        States::where('country_id',$id)->delete();

        $country->delete();

        return response()->json([
            'success' => 'Country Deleted Successfully!'
        ]);
    }

    public function apiGetCountries()
    {
        $countryList = Countries::get();
        return response()->json([
            'message' => 'countries details get successfully',
            'data' => $countryList
        ]);
    }

}
