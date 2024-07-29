<?php

namespace App\Http\Controllers;

use App\Models\Intraday;
use App\Models\IntraValue;
use App\Services\AngelOneService;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IntradayController extends Controller
{

    protected $angelOneService;

    public function __construct(AngelOneService $angelOneService)
    {
        $this->angelOneService = $angelOneService;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $intraday = Intraday::query();

                if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
                    $startDate = date('Y-m-d', strtotime($request->start_date));
                    $endDate = date('Y-m-d', strtotime($request->end_date));
                
                    $intraday->whereDate('date', '>=', $startDate)
                              ->whereDate('date', '<=', $endDate);
                  
                }else{
                    $currentDate = Carbon::now();

                    $currentDate = $currentDate->format('Y-m-d');

                    $intraday->whereDate('date','>=',$currentDate);
                }

                $alldata = $intraday->get();

                return DataTables::of($intraday)
                    ->addIndexColumn()
                    ->addColumn('date', function ($intra) {
                        return date('d-m-y', strtotime($intra->date));
                    })
                    ->addColumn('actions', function ($intra) {
                        return '<div class="btn-group">
                                <a href=' . route("intraday.edit", ["id" => encrypt($intra->id)]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
                                <a onclick="deleteUsers(\'' . $intra->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                <a href=' . route("intraday.intraView", ["id" => encrypt($intra->id)]) . ' class="btn btn-sm btn-info me-1"> <i class="bi bi-eye" aria-hidden="true"></i></a>
                                </div>';
                    })
                    ->rawColumns(['actions', 'date'])
                    ->make(true);
            }
            return view('admin.intraday.index');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create()
    {
        return view('admin.intraday.create');
    }

    public function store(Request $request)
    {
        try {

            if (isset($request->date)) {
                $date = DateTime::createFromFormat('d-m-Y', $request->date);
                $formattedDate = $date->format('Y-m-d');

            } else {
                $formattedDate = $request->date;
            }

            $intraday = Intraday::create([
                'date' => $formattedDate,
            ]);

            if ($request->has('start_time') && $request->has('end_time') && $request->has('buy_or_sale') && $request->has('nifty_or_banknifty') && $request->has('featureby_or_optionby') && $request->has('quantity')) {
                $start_times = $request->start_time;
                $end_times = $request->end_time;
                $buy_or_sales = $request->buy_or_sale; // Corrected variable name
                $nifty_or_bankniftys = $request->nifty_or_banknifty; // Corrected variable name
                $featureby_or_optionbys = $request->featureby_or_optionby; // Corrected variable name
                $target_prices = $request->target_price; // Corrected variable name
                $quantitys = $request->quantity;

                foreach ($start_times as $index => $start_time) {
                    if ($start_time !== null && $start_time !== '') {
                        $end_time = isset($end_times[$index]) ? $end_times[$index] : '';
                        $buy_or_sale = isset($buy_or_sales[$index]) ? $buy_or_sales[$index] : [];
                        $nifty_or_banknifty = isset($nifty_or_bankniftys[$index]) ? $nifty_or_bankniftys[$index] : [];
                        $featureby_or_optionby = isset($featureby_or_optionbys[$index]) ? $featureby_or_optionbys[$index] : [];
                        $target_price = isset($target_prices[$index]) ? $target_prices[$index] : [];
                        $quantity = isset($quantitys[$index]) ? $quantitys[$index] : [];

                        $intraValues = new IntraValue;
                        $intraValues->intraday_id = $intraday->id;
                        $intraValues->start_time = $start_time;
                        $intraValues->end_time = $end_time;
                        $intraValues->buy_or_sale = $buy_or_sale;
                        $intraValues->nifty_or_banknifty = $nifty_or_banknifty;
                        $intraValues->featureby_or_optionby = $featureby_or_optionby;
                        $intraValues->quantity = $quantity;
                        $intraValues->target_price = $target_price;
                        $intraValues->save();
                    }
                }

            }

            return redirect()->route('intraday')->with('message', 'Question Saved Successfully');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('intraday')->with('error', 'Internal Server Error');
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        try {
            $intra = Intraday::find($id);
            $intraValues = IntraValue::where('intraday_id', $intra->id)->get();

            return view('admin.intraday.edit', compact('intra', 'intraValues'));
        } catch (\Throwable $th) {
            return redirect()->route('intraday')->with('error', 'Internal Server Error');
        }
    }

    public function update(Request $request)
    {
       
        $id = decrypt($request->id);
        
        try {
            $date = DateTime::createFromFormat('d-m-y', $request->date);
            $formattedDate = $date->format('Y-m-d');
          

            $intra = Intraday::find($id);
            if ($intra) {
                $intra->update([
                    'date' => $formattedDate,
                ]);

                // Fetch existing question options
                $existingIntraValues = IntraValue::where('intraday_id', $id)->get();

                // Keep track of existing option IDs
                $existingIntraIds = $existingIntraValues->pluck('id')->toArray();

                // Iterate through the submitted option data
                if ($request->has('start_time')) {
                    $start_times = $request->start_time;
                    $end_times = $request->end_time;
                    $buy_or_sales = $request->buy_or_sale;
                    $nifty_or_bankniftys = $request->nifty_or_banknifty;
                    $featureby_or_optionbys = $request->featureby_or_optionby;
                    $target_prices = $request->target_price;
                    $quantitys = $request->quantity;

                    foreach ($start_times as $index => $start_time) {
                        $end_time = isset($end_times[$index]) ? $end_times[$index] : '';
                        $buy_or_sale = isset($buy_or_sales[$index]) ? $buy_or_sales[$index] : '';
                        $nifty_or_banknifty = isset($nifty_or_bankniftys[$index]) ? $nifty_or_bankniftys[$index] : '';
                        $featureby_or_optionby = isset($featureby_or_optionbys[$index]) ? $featureby_or_optionbys[$index] : '';
                        $target_price = isset($target_prices[$index]) ? $target_prices[$index] : '';
                        $quantity = isset($quantitys[$index]) ? $quantitys[$index] : '';

                        // Check if the submitted option ID exists in the existing options
                        if (isset($request->intra_id[$index]) && in_array($request->intra_id[$index], $existingIntraIds)) {
                            // Update the existing option
                            $existingIntraValue = IntraValue::find($request->intra_id[$index]);
                            $updateData = [
                                'start_time' => $start_time,
                                'end_time' => $end_time,
                                'target_price' => $target_price,
                                'quantity' => $quantity,
                            ];

                            // Only update 'buy_or_sale', 'nifty_or_banknifty', 'featureby_or_optionby' if they are empty
                            if (empty($existingIntraValue->buy_or_sale)) {
                                $updateData['buy_or_sale'] = $buy_or_sale;
                            }
                            if (empty($existingIntraValue->nifty_or_banknifty)) {
                                $updateData['nifty_or_banknifty'] = $nifty_or_banknifty;
                            }
                            if (empty($existingIntraValue->featureby_or_optionby)) {
                                $updateData['featureby_or_optionby'] = $featureby_or_optionby;
                            }

                            $existingIntraValue->update($updateData);

                            // Remove the ID from the existing IDs array to track which IDs were not updated
                            $existingIntraIds = array_diff($existingIntraIds, [$request->intra_id[$index]]);
                        } else {
                            // Create a new option if the ID is not found or not provided
                            $intraValues = new IntraValue;
                            $intraValues->intraday_id = $intra->id;
                            $intraValues->start_time = $start_time;
                            $intraValues->end_time = $end_time;
                            $intraValues->buy_or_sale = $buy_or_sale;
                            $intraValues->nifty_or_banknifty = $nifty_or_banknifty;
                            $intraValues->featureby_or_optionby = $featureby_or_optionby;
                            $intraValues->target_price = $target_price;
                            $intraValues->quantity = $quantity;
                            $intraValues->save();
                        }
                    }

                    // Delete options that were not updated
                    IntraValue::whereIn('id', $existingIntraIds)->delete();
                }
            }

            return redirect()->route('intraday')->with('message', 'Data Updated Successfully');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('intraday')->with('error', 'Internal server error!');
        }
    }

    public function intraView($id)
    {
        $id = decrypt($id);
        try {
            $intra = Intraday::find($id);

            $intraValues = IntraValue::where('intraday_id', $id)->get();

            return view('admin.intraday.intraDataView', compact('intra', 'intraValues'));

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Internal server Error');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $intraday = Intraday::find($id);
            $intraday->delete();

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

    // public function placeOrder()
    // {

    //     $intradays = Intraday::with('intravalues')->get();

    //     foreach ($intradays as $intraday) {
            
    //         foreach ($intraday->intravalues as $trade) {

    //             // Calculate stop loss
    //             $stop_loss = $trade['target'] / 2;

    //             // Place order logic
    //             $orderData = [
    //                 'variety' => 'NORMAL',
    //                 'tradingsymbol' => $trade['nifty_or_banknifty'],
    //                 'symboltoken' => 'XXXX', // Replace with actual token
    //                 'transactiontype' => $trade['buy_or_sell'],
    //                 'exchange' => 'NSE',
    //                 'ordertype' => 'LIMIT',
    //                 'producttype' => $trade['option_or_future'],
    //                 'duration' => 'DAY',
    //                 'price' => $trade['target'],
    //                 'quantity' => $trade['quantity'],
    //                 'triggerprice' => $stop_loss, // Assuming this is your stop loss field
    //                 'start_time' => $trade['start_time'],
    //                 'end_time' => $trade['end_time'],
    //             ];

    //             $response = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . env('ANGEL_BROKING_ACCESS_TOKEN'),
    //                 'Content-Type' => 'application/json',
    //                 'Accept' => 'application/json',
    //                 'X-ClientCode' => env('ANGEL_BROKING_CLIENT_CODE'),
    //                 'X-API-Key' => env('ANGEL_BROKING_API_KEY'),
    //             ])->post(env('ANGEL_BROKING_API_ENDPOINT'), $orderData);

    //         }
    //     }

    //     return response()->json(['message' => 'Orders placed successfully']);
    // }

}
