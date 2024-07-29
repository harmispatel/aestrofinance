<?php

namespace App\Http\Controllers;

use App\Models\BhadraData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BhadraDataController extends Controller
{
    public function grahDataView(Request $request)
    {
         $current = Carbon::now();

         $currentDate = $current->format('Y-m-d');

        
        $bhadraDatas = BhadraData::whereDate('start_date_time','>=',$currentDate)->whereDate('end_date_time','>=',$currentDate)->get();

        if ($request->ajax()) {

            try {
                return DataTables::of($bhadraDatas)
                    ->addIndexColumn()
                    ->addColumn('start_date_time', function($bhadra){
                        $start = Carbon::parse($bhadra->start_date_time);

                        $start_date_time = $start->format('d-m-Y H:i:s');

                       return $start_date_time;
                    })
                    ->addColumn('end_date_time', function($bhadra){
                        $end = Carbon::parse($bhadra->end_date_time);

                        $end_date_time = $end->format('d-m-Y H:i:s');

                       return $end_date_time;
                    })
                    ->addColumn('actions', function ($bhadra) {
                        return '<div class="btn-group">
                        <a onclick="deleteUsers(\'' . $bhadra->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                        </div>';
                    })
                    ->rawColumns(['actions','start_date_time','end_date_time'])
                    ->make(true);

            
            } catch (\Throwable $th) {
                return redirect()->route('bhadra.index')->with('error', 'Internal server error');
            }
           
        }
        return view('admin.bhadraData.bhadraDatas');
    }

    public function delete(Request $request){
        try {
            $id = $request->id;

          $bhadra = BhadraData::find($id);

          $bhadra->delete();

          return response()->json([
            'success' => 1,
            'message' => "Data deleted Successfully..",
          ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something went wrong",
              ]);
        }
    }
}
