<?php

namespace App\Http\Controllers;

use App\Models\Grah;
use App\Models\NightGrahWiseData;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use DateTime;

class NightGrahWiseDataController extends Controller
{
    public function index(Request $request){     
        try {         
            $grahs = Grah::all();
   
            if($request->ajax()){
                
                $grahwisedata = NightGrahWiseData::query();

                if($request->has('grahname_filter') && !empty($request->grahname_filter)){
                    $grahwisedata->where('grah_id',$request->grahname_filter);
                }

                if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)){
                    $startDate = date('d-m-Y', strtotime($request->start_date));
                    $endDate = date('d-m-Y', strtotime($request->end_date));
                
                    $grahwisedata->where(function ($query) use ($startDate, $endDate) {
                        $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= STR_TO_DATE('{$startDate}', '%d-%m-%Y')")
                              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= STR_TO_DATE('{$endDate}', '%d-%m-%Y')");
                    });
                }

                if($request->has('start_time') && $request->has('end_time') && !empty($request->start_time) && !empty($request->end_time)){
                    $startTime = date('H:i', strtotime($request->start_time));
                    $endTime = date('H:i', strtotime($request->end_time));
                
                    $grahwisedata->where(function ($query) use ($startTime, $endTime) {
                        $query->whereRaw("TIME_FORMAT(STR_TO_DATE(start_time, '%h:%i %p'), '%H:%i') >= '{$startTime}'")
                        ->whereRaw("TIME_FORMAT(STR_TO_DATE(end_time, '%h:%i %p'), '%H:%i') <= '{$endTime}'");
                    });
                }
                
                $allGrahWiseData = $grahwisedata->get();

               
                return DataTables::of($allGrahWiseData)
                       ->addIndexColumn()
                       ->addColumn('grah_id',function($grah){
                           $grahName = Grah::where('id',$grah->grah_id)->value('name');                   
                           return $grahName;
                       })
                       ->addColumn('actions', function ($grah) {
                        return '<div class="btn-group"> 
                <a href=' . route("nightgrahsdata.edit", ["nightgrahsdatum" => encrypt($grah->id)]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
                <a onclick="deleteUsers(\'' . $grah->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                </div>';
                    })
                    ->rawColumns(['actions','grah_id'])
                    ->make(true); 
            }

            return view('admin.nightGrahwiseData.index',compact('grahs'));
        } catch (\Throwable $th) {
           
            return redirect()->route('nightgrahsdata.index')->with('error','Internal server error');
        }
    }

    public function create(){
        $grahs = Grah::get();

        return view('admin.nightGrahwiseData.create',compact('grahs'));
    }

    public function store(Request $request){
        try {
            if ($request->has('grah_id') && $request->has('date') && $request->has('start_time') && $request->has('end_time')) {
                $start_times = $request->start_time;
                $end_times = $request->end_time;
                $grah_ids = $request->grah_id; // Corrected variable name
                $dates = $request->date; // Corrected variable name

                foreach ($start_times as $index => $start_time) {
                    if ($start_time !== null && $start_time !== '') {
                        $end_time = isset($end_times[$index]) ? $end_times[$index] : null;
                        $grah_id = isset($grah_ids[$index]) ? $grah_ids[$index] : null;
                        $date = isset($dates[$index]) ? $dates[$index] : null;

                        $start_time_formatted = DateTime::createFromFormat('H:i', $start_time)->format('h:i A'); 
                        $end_time_formatted = DateTime::createFromFormat('H:i', $end_time)->format('h:i A');
                        

                        $GrahValues = new NightGrahWiseData;
                        $GrahValues->grah_id = $grah_id;
                        $GrahValues->start_time = $start_time_formatted;
                        $GrahValues->end_time = $end_time_formatted;
                        $GrahValues->date = $date;
                        $GrahValues->save();
                    }
                }

            }

            return redirect()->route('nightgrahsdata.index')->with('message', 'Data Saved Successfully');

        } catch (\Throwable $th) {
            return redirect()->route('nightgrahsdata.index')->with('error','Internal server error');
        }
    }

    public function edit($id){
        try {
            
            $id = decrypt($id);
            $grahs = Grah::get();
            $grahWiseData = NightGrahWiseData::find($id);        

           return view('admin.nightGrahwiseData.edit',compact('grahs','grahWiseData'));
        } catch (\Throwable $th) {
            return redirect()->route('nightgrahsdata.index')->with('error','Internal server error');
        }
    }

    public function update(Request $request){
        $id = decrypt($request->id);
       
        try {
            $grahWiseData = NightGrahWiseData::find($id);
            $start_time = DateTime::createFromFormat('H:i', $request->start_time)->format('h:i A');
            $end_time = DateTime::createFromFormat('H:i', $request->end_time)->format('h:i A');

            $grahWiseData->update([
              'date' => $request->date,
              'grah_id' => $request->grah_id,
              'start_time' => $start_time,
              'end_time' => $end_time
            ]);

            return redirect()->route('nightgrahsdata.index')->with('message','Data Updated SuccessFully');

        } catch (\Throwable $th) {
            return redirect()->route('nightgrahsdata.index')->with('error','Internal server error');
        }
    }

    public function delete(Request $request){
       

        try {
            $id = $request->grahsdata;
            $grahWiseData = NightGrahWiseData::find($id);

            $grahWiseData->delete();

            return response()->json([
                'success' => 1,
                'message' => "Data deleted Successfully..",
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
    }
}
