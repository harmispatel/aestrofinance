<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trayodashi;
use DataTables;
use Carbon\Carbon;

class TrayodashiController extends Controller
{
    public function index(Request $request){

      
        try {
            if($request->ajax()){

            $trayodashi = Trayodashi::query();

            if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)){
                $startDate = date('Y-m-d', strtotime($request->start_date));     

                $endDate = date('Y-m-d', strtotime($request->end_date));
            
                   $trayodashi->whereDate('start_date_time','>=' ,$startDate)
                              ->whereDate('end_date_time','<=' ,$endDate);
            }

            if(isset($request->start_time) && !empty($request->start_time) && isset($request->end_time) && !empty($request->end_time))
            {
                 $start_time = date('H:i',strtoTime($request->start_time));
                 $end_time = date('H:i',strtoTime($request->end_time));

                 $trayodashi->whereTime('start_date_time','>=',$start_time)
                            ->whereTime('end_date_time','<=',$end_time);
                 
            } else{
                $currentdate = Carbon::now()->format('Y-m-d');

                $trayodashi->whereDate('start_date_time','>=',$currentdate);
            }

              $allData = $trayodashi->get();

            return DataTables::of($allData)
             ->addIndexColumn()
             ->addColumn('start_date_time', function($data){
                $start = Carbon::parse($data->start_date_time);

                $start_date_time = $start->format('d-m-Y H:i:s');

               return $start_date_time;
            })
            ->addColumn('end_date_time', function($data){
                $end = Carbon::parse($data->end_date_time);

                $end_date_time = $end->format('d-m-Y H:i:s');

               return $end_date_time;
            })
             ->addColumn('actions', function ($trayo) {
                return '<div class="btn-group"> 
        <a href=' . route("trayodashi.edit", ["id" => encrypt($trayo->id)]) . '  class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
        <a  onclick="deleteUsers(\'' . $trayo->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
        </div>';
            })
            ->rawColumns(['actions','start_date_time','end_date_time'])
                    ->make(true); 
                }

                return view('admin.trayodashi.index');

        } catch (\Throwable $th) {
           dd($th);
           return redirect()->route('trayodashi.index')->with('error','Internal server error');
        }
    }

    public function create(){
        return view('admin.trayodashi.create');
    }

    public function store(Request $request){
        $request->validate([
            'start_date_time' => 'required',
            'end_date_time' => 'required',
        ]);
        try {
             
            Trayodashi::create([
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
            ]);

            return redirect()->route('trayodashi.index')->with('message','Data Saved SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('trayodashi.index')->with('error','Internal Server Error');
        }
    }

    public function edit($id){
        try {
            $id = decrypt($id);

            $trayodashis =  Trayodashi::find($id);

            return view('admin.trayodashi.edit',compact('trayodashis'));
        } catch (\Throwable $th) {
            return redirect()->route('trayodashi.index')->with('error','Internal server error');
        }
    }

    public function update(Request $request){
        $request->validate([
            'start_date_time' => 'required',
            'end_date_time' => 'required',
        ]);

        try {
           $id = decrypt($request->id);

           $trayodashis =  Trayodashi::find($id);

            $trayodashis->update([
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
            ]);

            return redirect()->route('trayodashi.index')->with('message','Data Updated SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('trayodashi.index')->with('error','Internal server error');
        }
    }

    public function delete(Request $request){
        try {
            $id = $request->id;
            $trayodashis =  Trayodashi::find($id);

            $trayodashis->delete();

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
