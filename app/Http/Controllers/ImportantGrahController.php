<?php

namespace App\Http\Controllers;

use App\Models\Grah;
use App\Models\ImportantGrah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ImportantGrahController extends Controller
{
    public function ImportantGrah(Request $request)
    {
        $grahs = Grah::all();
        try {
            if ($request->ajax()) {
                $importantGrah = ImportantGrah::with('grahWiseData');

                if ($request->has('grahname_filter') && !empty($request->grahname_filter)) {
                    $importantGrah->whereHas('grahWiseData', function ($query) use ($request) {
                        $query->where('grah_id', $request->grahname_filter);
                    });
                }

                if ($request->has('start_time') && $request->has('end_time') && !empty($request->start_time) && !empty($request->end_time)) {
                    $startTime = date('H:i', strtotime($request->start_time));
                    $endTime = date('H:i', strtotime($request->end_time));

                    $importantGrah->whereHas('grahWiseData', function ($query) use ($startTime, $endTime) {
                        $query->whereRaw("TIME_FORMAT(STR_TO_DATE(start_time, '%h:%i %p'), '%H:%i') >= '{$startTime}'")
                            ->whereRaw("TIME_FORMAT(STR_TO_DATE(end_time, '%h:%i %p'), '%H:%i') <= '{$endTime}'");
                    });
                }

                if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
                    $startDate = date('d-m-Y', strtotime($request->start_date));
                    $endDate = date('d-m-Y', strtotime($request->end_date));

                    $importantGrah->whereHas('grahWiseData', function ($query) use ($startDate, $endDate) {
                        $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= STR_TO_DATE('{$startDate}', '%d-%m-%Y')")
                            ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= STR_TO_DATE('{$endDate}', '%d-%m-%Y')");
                    });

                } else {
                    // $data = $importantGrah->where(DB::raw("STR_TO_DATE(date, '%d-%m-%Y')"), '>=', DB::raw("CURDATE()"))
                    // ->orderByRaw("STR_TO_DATE(date, '%d-%m-%Y') ASC");

                    // Fetch the data from the database
                    // Fetch the data from the database
                    $importantGrah = $importantGrah
                        ->whereHas('grahWiseData', function ($query) {
                            $query->where(DB::raw("STR_TO_DATE(date, '%d-%m-%Y')"), '>=', DB::raw("CURDATE()"))
                                ->whereRaw("TIME_FORMAT(STR_TO_DATE(CONCAT('1970-01-01 ', start_time), '%Y-%m-%d %h:%i %p'), '%H:%i') >= '00:00'");
                        })->get();

                    // Sort the collection in PHP
                    $importantGrah = $importantGrah->map(function ($item) {
                        // Access grahWiseData relationship and its start_time
                        $item->start_time = strtotime(date('Y-m-d ') . $item->grahWiseData->first()->start_time); // Assuming grahWiseData is a collection, use first() to get the first item

                        return $item;
                    })->all(); // Use all() to convert back to a simple array

                    // Sort the array using usort based on start_time
                    usort($importantGrah, function ($a, $b) {
                        return $a->start_time <=> $b->start_time;
                    });

                    // If you want to convert back to a collection after sorting, you can use collect()
                    $importantGrah = collect($importantGrah);

                    $importantGrah = $importantGrah->values()->all();

                }

                // $data now contains the sorted collection based on start_time ascending
                if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
                    $allImportantData = $importantGrah->get();

                }

                return DataTables::of($importantGrah)
                    ->addIndexColumn()
                    ->addColumn('id', function ($impoGrah) {

                        $id = $impoGrah->grahWiseData->first()->id ?? '';

                        return $id;
                    })
                    ->addColumn('date', function ($impoGrah) {

                        $date = $impoGrah->grahWiseData->first()->date ?? '';

                        return $date;
                    })
                    ->addColumn('grah_name', function ($impoGrah) {

                        $grah_id = $impoGrah->grahWiseData->first()->grah_id ?? '';

                        $grahName = Grah::where('id', $grah_id)->value('name') ?? '';

                        return $grahName;
                    })
                    ->addColumn('start_time', function ($impoGrah) {

                        $startTime = $impoGrah->grahWiseData->first()->start_time ?? '';

                        return $startTime;
                    })
                    ->addColumn('end_time', function ($impoGrah) {
                        $endTime = $impoGrah->grahWiseData->first()->end_time ?? '';

                        return $endTime;
                    })
                    ->addColumn('actions', function ($impoGrah) {
                        return '<div class="btn-group">
               <a onclick="deleteUsers(\'' . $impoGrah->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
               </div>';
                    })
                    ->rawColumns(['grah_name', 'start_time', 'end_time', 'date', 'id', 'actions'])
                    ->make(true);

            }

            return view('admin.importantGrah.index', compact('grahs'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('importantGrah.index')->with('error', 'Internal server error');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $importantGrah = ImportantGrah::find($id);

            $importantGrah->delete();

            return response()->json([
                'success' => 1,
                'message' => "Data deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
    }
}
