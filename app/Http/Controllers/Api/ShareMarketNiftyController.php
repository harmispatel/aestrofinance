<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\NiftyResource;
use App\Http\Resources\BankNiftyResource;
use App\Models\ShareMarketNifty;
use App\Models\BankNifty;
use App\Models\NiftyJson;
use App\Models\BankNiftyJson;

class ShareMarketNiftyController extends BaseController
{
    //Nifty

    public function niftyStoreUpdate()
    {
        $url = 'https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY';
    
        try {
            $headers = [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => 'https://www.nseindia.com/',
            ];
    
            $response = Http::withHeaders($headers)->get($url);
    
            if ($response->status() == 403) {
                return response()->json(['error' => 'Access forbidden. Please check your request headers and try again.'], 403);
            }
    
            $data = $response->json();
    
            if (!isset($data['records']['data'])) {
                return response()->json(['error' => 'Invalid response structure'], 500);
            }
    
            foreach ($data['records']['data'] as $record) {
                foreach (['CE', 'PE'] as $optionType) { // Loop through both CE and PE options
                    if (isset($record[$optionType])) {
                        $optionData = $record[$optionType];
                        $optionTypeKey = ($optionType === 'CE') ? 'CE' : 'PE';
    
                        // Add common checks for CE and PE options
                        if (
                            isset($optionData['strikePrice']) &&
                            isset($optionData['expiryDate']) &&
                            isset($optionData['openInterest']) &&
                            isset($optionData['identifier']) &&
                            isset($optionData['underlying']) &&
                            isset($optionData['changeinOpenInterest']) &&
                            isset($optionData['pchangeinOpenInterest']) &&
                            isset($optionData['totalTradedVolume']) &&
                            isset($optionData['impliedVolatility']) &&
                            isset($optionData['lastPrice']) &&
                            isset($optionData['change']) &&
                            isset($optionData['pChange']) &&
                            isset($optionData['totalBuyQuantity']) &&
                            isset($optionData['totalSellQuantity']) &&
                            isset($optionData['bidQty']) &&
                            isset($optionData['bidprice']) &&
                            isset($optionData['askQty']) &&
                            isset($optionData['askPrice']) &&
                            isset($optionData['underlyingValue'])
                        ) {
                            // Convert the expiry date to YYYY-MM-DD format
                            $expiryDate = \Carbon\Carbon::createFromFormat('d-M-Y', $optionData['expiryDate'])->format('Y-m-d');
    
                            ShareMarketNifty::updateOrCreate(
                                [
                                    'strike_price' => $optionData['strikePrice'],
                                    'expiry_date' => $expiryDate,
                                    'type' => $optionTypeKey
                                 ],
                                [
                                    'identifier' => $optionData['identifier'],
                                    'underlying' => $optionData['underlying'],
                                    'open_interest' => $optionData['openInterest'],
                                    'change_in_open_interest' => $optionData['changeinOpenInterest'],
                                    'pchange_in_open_interest' => $optionData['pchangeinOpenInterest'],
                                    'total_traded_volume' => $optionData['totalTradedVolume'],
                                    'implied_volatility' => $optionData['impliedVolatility'],
                                    'last_price' => $optionData['lastPrice'],
                                    'change' => $optionData['change'],
                                    'pchange' => $optionData['pChange'],
                                    'total_buy_quantity' => $optionData['totalBuyQuantity'],
                                    'total_sell_quantity' => $optionData['totalSellQuantity'],
                                    'bid_qty' => $optionData['bidQty'],
                                    'bid_price' => $optionData['bidprice'],
                                    'ask_qty' => $optionData['askQty'],
                                    'ask_price' => $optionData['askPrice'],
                                    'underlying_value' => $optionData['underlyingValue'],
                                ]
                            );
                        }
                    }
                }
            }
    
            return $this->sendResponse(null, 'Data updated Successfully', true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update data', 'details' => $e->getMessage()], 500);
        }
    }

    public function getNifty(){
        try {
            $niftyData = ShareMarketNifty::get();
           
            $data = new NiftyResource($niftyData);

         return $this->sendResponse($data,'Nifty Data retrived Successfully',true);
        } catch (\Throwable $th) {
          dd($th);
            return $this->sendResponse(null,'Internal server error',false);
        }
    }


    public function niftyJsonUpdate()
    {
        $niftyurl = 'https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY';
        $bankNiftyurl = 'https://www.nseindia.com/api/option-chain-indices?symbol=BANKNIFTY';
   
        try {
            $headers = [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => 'https://www.nseindia.com/',
            ];
            
            $niftyResponse = Http::withHeaders($headers)->get($niftyurl);
  
            $bankNiftyResponse = Http::withHeaders($headers)->get($bankNiftyurl);

            if ($niftyResponse->status() == 403 || $bankNiftyResponse->status() == 403) {
                return response()->json(['error' => 'Access forbidden. Please check your request headers and try again.'], 403);
            }
    
            if ($niftyResponse->failed() || $bankNiftyResponse->failed()) {
                return $this->sendResponse(null, 'Failed to fetch data', false);
            }

            $niftyData = $niftyResponse->json();
          
           $bankNiftyData = $bankNiftyResponse->json();

            $combineData = [
                'NIFTY' => $niftyData,
                'BANKNIFTY' => $bankNiftyData,
            ];

            $jsonEncodedData = json_encode($combineData);

            NiftyJson::updateOrCreate([], ['value' => $jsonEncodedData]);

            return $this->sendResponse(null, 'Data Updated Successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function getNiftyJson(Request $request){
        try {
            $symbol = $request->symbol;

            if(!isset($symbol) && empty($symbol)){
                return $this->sendResponse(null, 'symbol is required', false);
            }

            if (!$symbol || !in_array($symbol, ['NIFTY', 'BANKNIFTY'])) {
                return $this->sendResponse(null, 'Invalid symbol provided', false);
            }
            
            $niftyData = NiftyJson::first();

            if(empty($niftyData->value)){
                return $this->sendResponse(null,'Data Not Found',true);
            }

            $NiftyValue = json_decode($niftyData->value, true);
          
            if(!isset($NiftyValue[$symbol])){
                return $this->sendResponse(null, 'Requested symbol data not found', false);
            }

        return $this->sendResponse($NiftyValue[$symbol],'Nifty Data retrived Successfully',true);
        } catch (\Throwable $th) {
        
            return $this->sendResponse(null,'Internal server error',false);
        }
    }

//Bank Nifty

    public function bankNiftyStoreUpdate()
    {
        $url = 'https://www.nseindia.com/api/option-chain-indices?symbol=BANKNIFTY';
    
        try {
            $headers = [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => 'https://www.nseindia.com/',
            ];
    
            $response = Http::withHeaders($headers)->get($url);
    
            if ($response->status() == 403) {
                return response()->json(['error' => 'Access forbidden. Please check your request headers and try again.'], 403);
            }
    
            $data = $response->json();
    
            if (!isset($data['records']['data'])) {
                return response()->json(['error' => 'Invalid response structure'], 500);
            }
    
            foreach ($data['records']['data'] as $record) {
                foreach (['CE', 'PE'] as $optionType) { // Loop through both CE and PE options
                    if (isset($record[$optionType])) {
                        $optionData = $record[$optionType];
                        $optionTypeKey = ($optionType === 'CE') ? 'CE' : 'PE';
    
                        // Add common checks for CE and PE options
                        if (
                            isset($optionData['strikePrice']) &&
                            isset($optionData['expiryDate']) &&
                            isset($optionData['openInterest']) &&
                            isset($optionData['identifier']) &&
                            isset($optionData['underlying']) &&
                            isset($optionData['changeinOpenInterest']) &&
                            isset($optionData['pchangeinOpenInterest']) &&
                            isset($optionData['totalTradedVolume']) &&
                            isset($optionData['impliedVolatility']) &&
                            isset($optionData['lastPrice']) &&
                            isset($optionData['change']) &&
                            isset($optionData['pChange']) &&
                            isset($optionData['totalBuyQuantity']) &&
                            isset($optionData['totalSellQuantity']) &&
                            isset($optionData['bidQty']) &&
                            isset($optionData['bidprice']) &&
                            isset($optionData['askQty']) &&
                            isset($optionData['askPrice']) &&
                            isset($optionData['underlyingValue'])
                        ) {
                            // Convert the expiry date to YYYY-MM-DD format
                            $expiryDate = \Carbon\Carbon::createFromFormat('d-M-Y', $optionData['expiryDate'])->format('Y-m-d');
    
                            BankNifty::updateOrCreate(
                                [
                                    'strike_price' => $optionData['strikePrice'],
                                    'expiry_date' => $expiryDate,
                                    'type' => $optionTypeKey
                                 ],
                                [
                                    'identifier' => $optionData['identifier'],
                                    'underlying' => $optionData['underlying'],
                                    'open_interest' => $optionData['openInterest'],
                                    'change_in_open_interest' => $optionData['changeinOpenInterest'],
                                    'pchange_in_open_interest' => $optionData['pchangeinOpenInterest'],
                                    'total_traded_volume' => $optionData['totalTradedVolume'],
                                    'implied_volatility' => $optionData['impliedVolatility'],
                                    'last_price' => $optionData['lastPrice'],
                                    'change' => $optionData['change'],
                                    'pchange' => $optionData['pChange'],
                                    'total_buy_quantity' => $optionData['totalBuyQuantity'],
                                    'total_sell_quantity' => $optionData['totalSellQuantity'],
                                    'bid_qty' => $optionData['bidQty'],
                                    'bid_price' => $optionData['bidprice'],
                                    'ask_qty' => $optionData['askQty'],
                                    'ask_price' => $optionData['askPrice'],
                                    'underlying_value' => $optionData['underlyingValue'],
                                ]
                            );
                        }
                    }
                }
            }
    
            return $this->sendResponse(null, 'Data updated Successfully', true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update data', 'details' => $e->getMessage()], 500);
        }
    }

    public function getBankNifty(){
        try {
            $bankNiftyData = BankNifty::get();
           
          $data = new BankNiftyResource($bankNiftyData);

         return $this->sendResponse($data,'Nifty Data retrived Successfully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal server error',false);
        }
    }

    // public function bankNiftyJsonUpdate()
    // {
    //     $url = 'https://www.nseindia.com/api/option-chain-indices?symbol=BANKNIFTY';
        
    //     try {
    //         $headers = [
    //             'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
    //             'Accept' => 'application/json',
    //             'Referer' => 'https://www.nseindia.com/',
    //         ];
            
    //         $response = Http::withHeaders($headers)->get($url);

    //         if ($response->status() == 403) {
    //             return response()->json(['error' => 'Access forbidden. Please check your request headers and try again.'], 403);
    //         }

    //         if ($response->failed()) {
    //             return $this->sendResponse(null, 'Failed to fetch data', false);
    //         }

    //         $data = $response->json();

    //         $niftyJsonPass = json_encode($data);

    //         BankNiftyJson::updateOrCreate([], ['value' => $niftyJsonPass]);

    //         return $this->sendResponse(null, 'Data Updated Successfully', true);
    //     } catch (\Throwable $th) {
    //         return $this->sendResponse(null, 'Internal Server Error', false);
    //     }
    // }

    // public function getBankNiftyJson(){
    //     try {
    //         $niftyData = BankNiftyJson::first();

    //         if(empty($niftyData->value)){
    //             return $this->sendResponse(null,'Data Not Found',true);
    //         }

    //         $NiftyValue = json_decode($niftyData->value);

    //     return $this->sendResponse($NiftyValue,'BankNifty Data retrived Successfully',true);
    //     } catch (\Throwable $th) {
        
    //         return $this->sendResponse(null,'Internal server error',false);
    //     }
    // }

    
}
