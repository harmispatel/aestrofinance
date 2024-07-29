<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AmavasyaDate;
use DataTables;
use Carbon\Carbon;

class AmavasyaController extends Controller
{
    public function index(Request $request){


        try {
            if($request->ajax()){

            $amavasya = AmavasyaDate::query();

            if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)){
                $startDate = date('Y-m-d', strtotime($request->start_date));

                $endDate = date('Y-m-d', strtotime($request->end_date));

                   $amavasya->whereDate('start_time','>=' ,$startDate)
                              ->whereDate('end_time','<=' ,$endDate);
            }
            elseif(isset($request->start_time) && !empty($request->start_time) && isset($request->end_time) && !empty($request->end_time))
            {
                 $start_time = date('H:i',strtoTime($request->start_time));
                 $end_time = date('H:i',strtoTime($request->end_time));

                 $amavasya->whereTime('start_time','>=',$start_time)
                            ->whereTime('end_time','<=',$end_time);

            }
            else{
                $currentdate = Carbon::now()->format('Y-m-d');

                $amavasya->whereDate('start_time','>=',$currentdate);
            }
             
              $allData = $amavasya->get();

            return DataTables::of($allData)
             ->addIndexColumn()
             ->addColumn('start_time', function($data){
                $start = Carbon::parse($data->start_time);

                $start_date_time = $start->format('d-m-Y H:i:s');

               return $start_date_time;
            })
            ->addColumn('end_time', function($data){
                $end = Carbon::parse($data->end_time);

                $end_date_time = $end->format('d-m-Y H:i:s');

               return $end_date_time;
            })
             ->addColumn('actions', function ($trayo) {
                return '<div class="btn-group">
        <a href=' . route("amavasya.edit", ["id" => encrypt($trayo->id)]) . '  class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
        <a  onclick="deleteAmavasyaDate(\'' . $trayo->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
        </div>';
            })
            ->rawColumns(['actions','start_time','end_time'])
                    ->make(true);
                }

                return view('admin.amavasya.index');

        } catch (\Throwable $th) {
            dd($th);
           return redirect()->route('amavasya.index')->with('error','Internal server error');
        }
    }

    public function create(){
        return view('admin.amavasya.create');
    }

    public function store(Request $request){
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        try {

            AmavasyaDate::create([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return redirect()->route('amavasya.index')->with('message','Amavasya Date Saved SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('amavasya.index')->with('error','Internal Server Error');
        }
    }

    public function edit($id){
        try {
            $id = decrypt($id);

            $amavasyaData =  AmavasyaDate::find($id);

            return view('admin.amavasya.edit',compact('amavasyaData'));
        } catch (\Throwable $th) {
            return redirect()->route('amavasya.index')->with('error','Internal server error');
        }
    }

    public function update(Request $request){
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
           $id = decrypt($request->id);

           $trayodashis =  AmavasyaDate::find($id);

            $trayodashis->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            return redirect()->route('amavasya.index')->with('message','Data Updated SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('amavasya.index')->with('error','Internal server error');
        }
    }


    public function delete(Request $request){
        try {
            $id = $request->id;
            $amavasyaRecord =  AmavasyaDate::find($id);

            $amavasyaRecord->delete();

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
