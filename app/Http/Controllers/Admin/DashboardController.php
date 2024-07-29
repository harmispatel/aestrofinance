<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AmavasyaDate;
use App\Models\BhadraData;
use App\Models\CurrentNifty;
use App\Models\Degree;
use App\Models\Grah;
use App\Models\ImportantGrah;
use App\Models\ImportantValue;
use App\Models\Trayodashi;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard View
    public function index()
    {
        $currentDate = Carbon::now();

        $currentGrahDate = $currentDate->format('d-m-Y');

        $currentMudraDate = $currentDate->format('Y-m-d');

        $importantGrahs = ImportantGrah::where('date', $currentGrahDate)->with('grahWiseData')->get();

        $startTime = Carbon::parse('09:30 AM')->format('H:i:s');
        $endTime = Carbon::parse('03:30 PM')->format('H:i:s');

        $trayodashiStartTime = Trayodashi::whereDate('start_date_time', '>=', $currentMudraDate)->first();

        $trayodashiEndTime = Trayodashi::whereDate('end_date_time', '>=', $currentMudraDate)->first();

        $amavasyaStartTime = AmavasyaDate::whereDate('start_time', '>=', $currentMudraDate)->first();

        $amavasyaEndTime = AmavasyaDate::whereDate('end_time', '>=', $currentMudraDate)->first();

        $bhdraStartTime = BhadraData::whereDate('start_date_time', '>=', $currentMudraDate)->first();

        $bhdraEndTime = BhadraData::whereDate('end_date_time', '>=', $currentMudraDate)->first();

        $currentNifty = CurrentNifty::where('stock','NIFTY')->get();

        $grahnames = [];

        foreach ($importantGrahs as $impo) {
            $grahwise = $impo->grahWiseData;

            foreach ($grahwise as $grahname) {
                $grahid = $grahname->grah_id;
                $grahnames[] = Grah::where('id', $grahid)->value('name');

            }
        }

        $grahs = Grah::all();

        $stocks = CurrentNifty::select('stock')
        ->groupBy('stock')
        ->get();


        return view('admin.dashboard.dashboard', compact('stocks','amavasyaStartTime', 'amavasyaEndTime', 'trayodashiStartTime', 'trayodashiEndTime', 'grahs', 'currentNifty', 'bhdraStartTime', 'bhdraEndTime', 'importantGrahs', 'grahnames'));
    }

    public function importantValue(Request $request)
    {
        try {
            $nifty = $request->nifty;

            $stock = $request->stock;

            $currentDate = Carbon::now()->format('Y-m-d');

            // Loop through the results to get only grahWiseData

            $importantValues = ImportantValue::whereDate('date', $currentDate)->get();
            $importantGrah = ImportantGrah::whereraw("STR_TO_DATE(date, '%d-%m-%Y') = STR_TO_DATE('{$currentDate}','%Y-%m-%d')")->with('grahWiseData')->get();
            $grahnameas = [];

            $data = [];

            foreach ($importantValues as $impvalue) {
                $deg_absolute = $impvalue->deg_absolute;
                $grah_name = $impvalue->grah_name;

                //counting degree
                $range = 1;
                $degrees = Degree::pluck('degree');

                $degreeArray = $degrees->toArray();

                $nearestValue = null;
                $smallestDifference = PHP_INT_MAX;

                foreach ($degreeArray as $value) {

                    $difference = abs($value - $nifty);

                    if ($difference < $smallestDifference) {
                        $smallestDifference = $difference;
                        $nearestValue = $value;
                    }

                }

                $niftyprice = $nearestValue + $deg_absolute;

                foreach ($importantGrah as $impo) {
                    $grahwise = $impo->grahWiseData;
                    foreach ($grahwise as $grahname) {

                        $grahname = Grah::where('id', $grahname->grah_id)->value('name');

                        if (substr($grah_name, 0, 3) === substr($grahname, 0, 3)) {
                            break 2; // Exit both loops if match found
                        }

                    }

                }

                $results[] = [
                    'grah_name' => $grah_name,
                    'deg_absolute' => $deg_absolute,
                    'niftyprice' => $niftyprice,
                    'grahname' => $grahname,
                    'stock' => $stock
                ];
            }

            return response()->json($results);

        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function currentsavedata(Request $request)
    {
        try {

            $datas = $request->data;

            $currentDate = Carbon::now()->format('Y-m-d');

            $currentdata = CurrentNifty::whereDate('date', $currentDate)->first();

            if (empty($currentdata)) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                CurrentNifty::truncate();
            }

            foreach ($datas as $data) {

                $stock = $data['stocks'];

                $stockOld = CurrentNifty::where('stock', $stock)->delete();

            }


            foreach ($datas as $data) {
                $stock = $data['stocks'];

                CurrentNifty::create([
                    'date' => $currentDate,
                    'stock' => $stock,
                    'grah_name' => $data['gname'],
                    'deg_absolute' => $data['d_absolute'],
                    'nifty_price' => $data['n_price'],
                ]);
            }

            return response()->json(['success' => 'Data saved successfully']);

        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    // public function importantValue(Request $request)
    // {
    //     try {
    //         $nifty = $request->nifty;

    //         $currentDate = Carbon::now()->format('d-m-Y');
    //         $importantGrah = ImportantGrah::whereRaw("STR_TO_DATE(date, '%d-%m-%Y') = STR_TO_DATE('{$currentDate}', '%d-%m-%Y')")->with('grahWiseData')->get();

    //         $grahWiseDataArray = [];

    //         $currentDate = Carbon::now()->format('Y-m-d');
    //         // Loop through the results to get only grahWiseData
    //         foreach ($importantGrah as $important) {
    //             foreach ($important->grahWiseData as $grahname) {
    //                 $grahId = $grahname->grah_id;
    //                 $grahvalue = Grah::where('id', $grahId)->value('name');

    //                 $importantValue = ImportantValue::whereDate('date', $currentDate)
    //                     ->where('grah_name', 'LIKE', substr($grahvalue, 0, 3) . '%')
    //                     ->first();

    //                     $deg_absolute = $importantValue->deg_absolute;
    //                    $grah_name =  $importantValue->grah_name;

    //                //counting degree
    //                     $range = 1;
    //                     $degrees = Degree::pluck('degree');

    //                     $degreeArray = $degrees->toArray();

    //                     $nearestValue = null;
    //                     $smallestDifference = PHP_INT_MAX;

    //                     foreach ($degreeArray as $value) {

    //                         $difference = abs($value - $nifty);

    //                         if ($difference < $smallestDifference) {
    //                             $smallestDifference = $difference;
    //                             $nearestValue = $value;
    //                         }

    //                     }

    //                     $niftyprice = $nearestValue + $deg_absolute;

    //             }
    //         }

    //         return response()->json(['grah_name' => $grah_name ,'deg_absolute' => $deg_absolute, 'niftyprice' => $niftyprice]);

    //     } catch (\Throwable $th) {
    //         dd($th);

    //         return response()->json(['error' => 'An error occurred'], 500);
    //     }
    // }

    public function currentNifty()
    {
        try {

            $stocks = CurrentNifty::select('stock')
                ->groupBy('stock')
                ->get();

            return view('admin.currentnifty.currentnifty', compact('stocks'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Internal Server Error');
        }
    }

    public function currentNiftyStockWise(Request $request)
    {
        try {
            $stock = $request->stock;

            $currentDate = Carbon::now()->format('Y-m-d');
            $importantGrah = ImportantGrah::whereraw("STR_TO_DATE(date, '%d-%m-%Y') = STR_TO_DATE('{$currentDate}','%Y-%m-%d')")->with('grahWiseData')->get();

            $stockdata = CurrentNifty::where('stock', $stock)->get();

            $grah_names = [];

            foreach ($importantGrah as $impo) {
                $grahwise = $impo->grahWiseData;
                foreach ($grahwise as $grahname) {

                    $grahname = Grah::where('id', $grahname->grah_id)->value('name');

                    $grah_names[] = $grahname;

                }
            }

            $result = [
                'stockdata' => $stockdata,
                'grah_names' => $grah_names
            ];


            return response()->json($result);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
    // Admin Logout
    public function adminLogout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('admin.login');
    }
}
