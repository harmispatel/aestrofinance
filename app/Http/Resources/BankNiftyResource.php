<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankNiftyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $niftyDatas = isset($this->resource) ? $this->resource : [];
    
        $data = [];
        $filteredData = [
            'CE' => [],
            'PE' => []
        ];
        $expiryDates = [];
        $strikePrices = [];
    
        if (count($niftyDatas) > 0) {
            foreach ($niftyDatas as $nifty) {
                // Populate expiry dates and strike prices
                if (isset($nifty->expiry_date) && !in_array($nifty->expiry_date, $expiryDates)) {
                    $expiryDates[] = $nifty->expiry_date;
                }
                if (isset($nifty->strike_price) && !in_array($nifty->strike_price, $strikePrices)) {
                    $strikePrices[] = $nifty->strike_price;
                }
    
                $item = [];
                $item['strikePrice'] = isset($nifty->strike_price) ? $nifty->strike_price : '';
                $item['expiryDate'] = isset($nifty->expiry_date) ? $nifty->expiry_date : '';
                $type = isset($nifty->type) ? $nifty->type : ''; // Assuming there's a 'type' field to distinguish CE and PE
    
                $optionData = [
                    'strikePrice' => $item['strikePrice'],
                    'expiryDate' => $item['expiryDate'],
                    'underlying' => isset($nifty->underlying) ? $nifty->underlying : '',
                    'identifier' => isset($nifty->identifier) ? $nifty->identifier : '',
                    'openInterest' => isset($nifty->open_interest) ? $nifty->open_interest : '',
                    'changeinOpenInterest' => isset($nifty->change_in_open_interest) ? $nifty->change_in_open_interest : '',
                    'pchangeinOpenInterest' => isset($nifty->pchange_in_open_interest) ? $nifty->pchange_in_open_interest : '',
                    'totalTradedVolume' => isset($nifty->total_traded_volume) ? $nifty->total_traded_volume : '',
                    'impliedVolatility' => isset($nifty->implied_volatility) ? $nifty->implied_volatility : '',
                    'lastPrice' => isset($nifty->last_price) ? $nifty->last_price : '',
                    'change' => isset($nifty->change) ? $nifty->change : '',
                    'pChange' => isset($nifty->pchange) ? $nifty->pchange : '',
                    'totalBuyQuantity' => isset($nifty->total_buy_quantity) ? $nifty->total_buy_quantity : '',
                    'totalSellQuantity' => isset($nifty->total_sell_quantity) ? $nifty->total_sell_quantity : '',
                    'bidQty' => isset($nifty->bid_qty) ? $nifty->bid_qty : '',
                    'bidprice' => isset($nifty->bid_price) ? $nifty->bid_price : '',
                    'askQty' => isset($nifty->ask_qty) ? $nifty->ask_qty : '',
                    'askPrice' => isset($nifty->ask_price) ? $nifty->ask_price : '',
                    'underlyingValue' => isset($nifty->underlying_value) ? $nifty->underlying_value : '',
                ];
    
                if ($type === 'CE') {
                    $item['CE'] = $optionData;
                    $filteredData['CE'][] = $optionData;
                } elseif ($type === 'PE') {
                    $item['PE'] = $optionData;
                    $filteredData['PE'][] = $optionData;
                }
    
                $data[] = $item;
            }
        }
    
        $ceTotOI = array_sum(array_column($filteredData['CE'], 'openInterest'));
        $ceTotVol = array_sum(array_column($filteredData['CE'], 'totalTradedVolume'));
        $peTotOI = array_sum(array_column($filteredData['PE'], 'openInterest'));
        $peTotVol = array_sum(array_column($filteredData['PE'], 'totalTradedVolume'));
    
        return [
            'records' => [
                'expiryDates' => $expiryDates,
                'data' => $data,
                'timestamp' => now()->format('d-M-Y H:i:s'),
                'underlyingValue' => isset($niftyDatas[0]->underlying_value) ? $niftyDatas[0]->underlying_value : '',
                'strikePrices' => $strikePrices
            ],
            'filtered' => [
                'CE' => [
                    'data' => $filteredData['CE'],
                    'totOI' => $ceTotOI,
                    'totVol' => $ceTotVol
                ],
                'PE' => [
                    'data' => $filteredData['PE'],
                    'totOI' => $peTotOI,
                    'totVol' => $peTotVol
                ]
            ]
        ];
    
    }
}
