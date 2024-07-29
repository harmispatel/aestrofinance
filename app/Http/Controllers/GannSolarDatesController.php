<?php

namespace App\Http\Controllers;

use App\Models\GannStokes;
use App\Models\StokeList;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GannSolarDatesController extends Controller
{
    public function index(Request $request)
    {
        try {

            if ($request->ajax()) {
                $GannData = GannStokes::query();

                if (isset($request->start_date_45) && !empty($request->start_date_45) && isset($request->end_date_45) && !empty($request->end_date_45)) {
                    $start_date_45 = Carbon::createFromFormat('d-m-Y', $request->start_date_45);
                    $end_date_45 = Carbon::createFromFormat('d-m-Y', $request->end_date_45);

                    $start_sql_format_45 = $start_date_45->format('Y-m-d');
                    $end_sql_format_45 = $end_date_45->format('Y-m-d');

                    $GannData->whereRaw("STR_TO_DATE(d_45, '%d/%m/%Y') >= ?", [$start_sql_format_45])
                             ->whereRaw("STR_TO_DATE(d_45, '%d/%m/%Y') <= ?", [$end_sql_format_45]);
                }

                if (isset($request->start_date_90) && !empty($request->start_date_90) && isset($request->end_date_90) && !empty($request->end_date_90)) {
                    $start_date_90 = Carbon::createFromFormat('d-m-Y', $request->start_date_90);
                    $end_date_90 = Carbon::createFromFormat('d-m-Y', $request->end_date_90);

                    $start_sql_format_90 = $start_date_90->format('Y-m-d');
                    $end_sql_format_90 = $end_date_90->format('Y-m-d');

                    $GannData->whereRaw("STR_TO_DATE(d_90, '%d/%m/%Y') >= ?", [$start_sql_format_90])
                             ->whereRaw("STR_TO_DATE(d_90, '%d/%m/%Y') <= ?", [$end_sql_format_90]);
                }

                if (isset($request->start_date_135) && !empty($request->start_date_135) && isset($request->end_date_135) && !empty($request->end_date_135)) {
                    $start_date_135 = Carbon::createFromFormat('d-m-Y', $request->start_date_135);
                    $end_date_135 = Carbon::createFromFormat('d-m-Y', $request->end_date_135);

                    $start_sql_format_135 = $start_date_135->format('Y-m-d');
                    $end_sql_format_135 = $end_date_135->format('Y-m-d');

                    $GannData->whereRaw("STR_TO_DATE(d_135, '%d/%m/%Y') >= ?", [$start_sql_format_135])
                             ->whereRaw("STR_TO_DATE(d_135, '%d/%m/%Y') <= ?", [$end_sql_format_135]);
                }

                if (isset($request->start_date_180) && !empty($request->start_date_180) && isset($request->end_date_180) && !empty($request->end_date_180)) {
                    $start_date_180 = Carbon::createFromFormat('d-m-Y', $request->start_date_180);
                    $end_date_180 = Carbon::createFromFormat('d-m-Y', $request->end_date_180);

                    $start_sql_format_180 = $start_date_180->format('Y-m-d');
                    $end_sql_format_180 = $end_date_180->format('Y-m-d');

                    $GannData->whereRaw("STR_TO_DATE(d_180, '%d/%m/%Y') >= ?", [$start_sql_format_180])
                             ->whereRaw("STR_TO_DATE(d_180, '%d/%m/%Y') <= ?", [$end_sql_format_180]);
                }

             $all_data = $GannData->get();

                return DataTables::of($all_data)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($gann) {
                        return '<div class="btn-group">
                    <a href=' . route("gannStokes.view", ["id" => encrypt($gann->id)]) . ' class="btn btn-sm btn-primary me-1"> <i class="bi bi-eye" aria-hidden="true"></i></a>
                    <a href=' . route("gannStokes.edit", ["id" => encrypt($gann->id)]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil-square" aria-hidden="true"></i></a>
                    <a onclick="deleteUsers(\'' . $gann->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                    </div>';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
            return view('admin.GannData.index');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function currentStockView($id){

        try {
            $id = decrypt($id);

            $ganstocks = GannStokes::find($id);

            return view('admin.currentweekstocks.current-stock',compact('ganstocks'));


        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function beforemonthmonth(Request $request)
    {
        try {
                $start = Carbon::now();
                $start_date = $start->format('d-m-Y');

                $end_date = date('d-m-Y', strtotime('-1 months', strtotime($start_date)));

                $start_date_db = Carbon::createFromFormat('d-m-Y', $start_date)->format('d/m/Y');
                $end_date_db = Carbon::createFromFormat('d-m-Y', $end_date)->format('d/m/Y');

                $GannBuyData = GannStokes::where(DB::raw("STR_TO_DATE(d_90, '%d/%m/%Y')"), '>=', DB::raw("STR_TO_DATE('$end_date_db', '%d/%m/%Y')"))
                ->where(DB::raw("STR_TO_DATE(d_90, '%d/%m/%Y')"), '<=', DB::raw("STR_TO_DATE('$start_date_db', '%d/%m/%Y')"))
                ->get();

                $GannSellData = GannStokes::where(DB::raw("STR_TO_DATE(d_45, '%d/%m/%Y')"), '>=', DB::raw("STR_TO_DATE('$end_date_db', '%d/%m/%Y')"))
                ->where(DB::raw("STR_TO_DATE(d_45, '%d/%m/%Y')"), '<=', DB::raw("STR_TO_DATE('$start_date_db', '%d/%m/%Y')"))
                ->get();

                return view('admin.beforemonthganstocks.beforemonth',compact('GannBuyData','GannSellData'));
            }
           catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create()
    {
        $stokes = StokeList::get();

        $stokNames = [];

        foreach ($stokes as $stoke) {
            $jsonData = json_decode($stoke->value, true);

            if (isset($jsonData['data']) && is_array($jsonData['data'])) {
                foreach ($jsonData['data'] as $stock) {
                    $stokNames[] = $stock['name'];
                }
            }
        }

        return view('admin.GannData.create', compact('stokNames'));
    }

    public function store(Request $request)
    {
        try {
            $input = $request->except('_token');

            $gannstokes = GannStokes::create($input);

            return redirect()->route('gannStokes.index')->with('message', 'Data Saved SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('gannStokes.index')->with('error', 'Something went wrong');
        }
    }

    public function view($id)
    {
        try {
            $id = decrypt($id);

            $GannData = GannStokes::find($id);

            return view('admin.GannData.view', compact('GannData'));
        } catch (\Throwable $th) {
            return redirect()->route('gannStokes.index')->with('error', 'Something went wrong');
        }
    }

    public function edit($id){
        try {
            $id = decrypt($id);

            $GannData = GannStokes::find($id);

            return view('admin.GannData.edit', compact('GannData'));
        } catch (\Throwable $th) {
            return redirect()->route('gannStokes.index')->with('error', 'Something went wrong');
        }
    }

    public function update(Request $request){
        try {
           $id = $request->id;
           $input = $request->except('_token');
           $GannData = GannStokes::findOrFail($id);
           if(isset($GannData)){
            // Update the Gann data with the input values
            $GannData->update($input);
            return redirect()->route('gannStokes.index')->with('message', 'GannData updated successfully.');
        }

        } catch (\Throwable $th) {
            return redirect()->route('gannStokes.index')->with('error', 'Something went wrong');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        try {

            $ganndata = GannStokes::find($id);

            $ganndata->delete();

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
    // public function calculate(Request $request)
    // {

    //     $request->validate([
    //         'start_date' => 'required|date',
    //     ]);

    //     $start_date = Carbon::createFromFormat('d-m-Y', $request->input('start_date'));
    //     $days = [
    //         30, 15, 15, 13, 18, 30, 15, 16, 30, 30,
    //         16, 15, 12, 18, 19, 12, 15, 15, 31
    //     ];

    //     $response = [];

    //     foreach ($days as $days_count) {
    //         // Calculate the next date based on the days count
    //         $next_date = $start_date->copy()->addDays($days_count);

    //         // Format next date as required
    //         $formatted_date = $next_date->format('d/m/Y');

    //         // Build the response string
    //         $response[] = "{$formatted_date}";

    //         // Update start_date for the next iteration
    //         $start_date = $next_date;
    //     }

    //     return response()->json($response);
    // }

}
