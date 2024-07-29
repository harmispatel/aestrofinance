<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GannStokes;
use DB;

class CurrentWeekStockController extends Controller
{
    public function index(){
        try {
            $startOfWeek = now()->startOfWeek()->format('Y-m-d');
            $endOfWeek = now()->endOfWeek()->format('Y-m-d');
    
            // Query to retrieve data based on conditions
            $currentWeekBuyData = GannStokes::where(function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween(DB::raw("STR_TO_DATE(d_90, '%d/%m/%Y')"), [$startOfWeek, $endOfWeek]);
            })->get();
    
            $currentWeekSellData = GannStokes::where(function ($query) use ($startOfWeek, $endOfWeek) {
                $query->WhereBetween(DB::raw("STR_TO_DATE(d_45, '%d/%m/%Y')"), [$startOfWeek, $endOfWeek]);
            })->get();


           return view('admin.currentweekstocks.index',compact('currentWeekBuyData','currentWeekSellData'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('currentweekstock')->with('error', 'Internal server error');
        }
    }
}
