<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Intraday;
use App\Services\AngelOneService;
use Exception;
use Illuminate\Support\Facades\Log;

class AngelOneController extends BaseController
{
    protected $angelOneService;

    public function __construct(AngelOneService $angelOneService)
    {
        $this->angelOneService = $angelOneService;
    }

    public function placeOrder()
    {
        try {
            $intradays = Intraday::with('intravalues')->first();

            foreach ($intradays as $intraday) {
                foreach ($intraday->intravalues as $trade) {

                    // Calculate stop loss
                    $stop_loss = $trade['target_price'] / 2;

                    $tradingsymbol = null;
                    $symboltoken = null;

                    // Determine trading symbol based on nifty_or_banknifty
                    if ($trade->nifty_or_banknifty === 'Nifty') {
                        $tradingsymbol = 'NIFTY';
                        try {
                            $symboltoken = $this->angelOneService->getSymbolToken($tradingsymbol);
                        } catch (Exception $e) {
                            Log::error('Error fetching symbol token: ' . $e->getMessage());
                            // Handle the exception as per your application's requirement
                        }
                       
                    } elseif ($trade->nifty_or_banknifty === 'BankNifty') {
                        $tradingsymbol = 'BANKNIFTY';
                        try {
                            $symboltoken = $this->angelOneService->getSymbolToken($tradingsymbol);
                        } catch (Exception $e) {
                            Log::error('Error fetching symbol token: ' . $e->getMessage());
                            // Handle the exception as per your application's requirement
                        }
               
                    } elseif ($trade->nifty_or_banknifty === 'Both') {
                        // Handle both nifty and banknifty scenario
                        // Option 1: Place separate orders for NIFTY and BANKNIFTY

                        try {
                            $niftyToken = $this->angelOneService->getSymbolToken('NIFTY');
                        } catch (Exception $e) {
                            Log::error('Error fetching symbol token: ' . $e->getMessage());
                            // Handle the exception as per your application's requirement
                        }

                        try {
                            $bankNiftyToken = $this->angelOneService->getSymbolToken('BANKNIFTY');
                        } catch (Exception $e) {
                            Log::error('Error fetching symbol token: ' . $e->getMessage());
                            // Handle the exception as per your application's requirement
                        }

                        $niftyOrderData = [
                            'variety' => 'NORMAL',
                            'tradingsymbol' => 'NIFTY',
                            'symboltoken' => $niftyToken, // Replace with actual token for NIFTY
                            'transactiontype' => strtoupper($trade->buy_or_sale),
                            'exchange' => 'NSE',
                            'ordertype' => 'LIMIT',
                            'producttype' => $trade->featureby_or_optionby,
                            'duration' => 'DAY',
                            'price' => $trade->target_price,
                            'quantity' => $trade->quantity,
                            'triggerprice' => $trade->target_price / 2,
                            'start_time' => $trade->start_time, // Example start time for buy
                            'end_time' => $trade->end_time, // Example end time for sell
                        ];

                        $bankNiftyOrderData = [
                            'variety' => 'NORMAL',
                            'tradingsymbol' => 'BANKNIFTY',
                            'symboltoken' => $bankNiftyToken, // Replace with actual token for BANKNIFTY
                            'transactiontype' => strtoupper($trade->buy_or_sale),
                            'exchange' => 'NSE',
                            'ordertype' => 'LIMIT',
                            'producttype' => $trade->featureby_or_optionby,
                            'duration' => 'DAY',
                            'price' => $trade->target_price,
                            'quantity' => $trade->quantity,
                            'triggerprice' => $trade->target_price / 2,
                            'start_time' => $trade->start_time, // Example start time for buy
                            'end_time' => $trade->end_time, // Example end time for sell
                        ];

                        // Call AngelOneService to place orders for both NIFTY and BANKNIFTY
                        $niftyResponse = $this->angelOneService->placeOrder($niftyOrderData);
                        $bankNiftyResponse = $this->angelOneService->placeOrder($bankNiftyOrderData);

                        continue;
                    }

                    // Place order logic for single symbol trades
                    $orderData = [
                        'variety' => 'NORMAL',
                        'tradingsymbol' => $tradingsymbol,
                        'symboltoken' => $symboltoken, // Replace with actual token
                        'transactiontype' => strtoupper($trade['buy_or_sale']),
                        'exchange' => 'NSE',
                        'ordertype' => 'LIMIT',
                        'producttype' => $trade['featureby_or_optionby'],
                        'duration' => 'DAY',
                        'price' => $trade['target_price'],
                        'quantity' => $trade['quantity'],
                        'triggerprice' => $stop_loss, // Assuming this is your stop loss field
                        'start_time' => $trade['start_time'],
                        'end_time' => $trade['end_time'],
                    ];

                    $response = $this->angelOneService->placeOrder($orderData);

                    // Log success or failure
                    if ($response && isset($response['status']) && $response['status'] === 'success') {
                        Log::info('Order placed successfully for ' . $tradingsymbol);
                    } else {
                        Log::error('Failed to place order for ' . $tradingsymbol);
                    }
                }
            }

            return response()->json(['message' => 'Orders placed successfully']);
        } catch (Exception $e) {
            Log::error('Error placing order: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to place orders.']);
        }
    }
}
