<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\StokeList;
use App\Models\StokDetail;

class StokListController extends BaseController
{
    public function stokListUpdate(){
        StokeList::truncate();

        $url = 'https://zerodha.harmistechnology.com/stockList';
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

            if ($response->failed()) {
                return $this->sendResponse(null, 'Failed to fetch data', false);
            }

            $data = $response->json();

            $stokListJsonPass = json_encode($data);

            StokeList::updateOrCreate([], ['value' => $stokListJsonPass]);

            return $this->sendResponse(null,'Data updated Successfully',true);
        } catch (\Throwable $th) {
          dd($th);
            return $this->sendResponse(null,'Internal server erro!',false);
        }
    }

    public function getStokList(){
        try {
            $stokData = StokeList::first();

            if(empty($stokData->value)){
                return $this->sendResponse(null,'Data Not Found',true);
            }

            $NiftyValue = json_decode($stokData->value);

            return $this->sendResponse($NiftyValue,'StokList Retrived SuccessFully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal server Error',false);
        }
    }

    public function StokDetailUpdate(){

        $urls = [
            'JSWSTEEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=JSWSTEEL',
            'INDUSINDBK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INDUSINDBK',
            'PEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PEL',
            'GUJGASLTD' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GUJGASLTD',
            'ABB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ABB',
            'GRANULES' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GRANULES',
            'COROMANDEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=COROMANDEL',
            'ICICIGI' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ICICIGI',
            'SIEMENS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SIEMENS',
            'BHARATFORG' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BHARATFORG',
            'SBICARD' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SBICARD',
            'CANFINHOME' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CANFINHOME',
            'PIIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PIIND',
            'GNFC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GNFC',
            'CROMPTON' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CROMPTON',
            'ADANIENT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ADANIENT',
            'BALRAMCHIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BALRAMCHIN',
            'LICHSGFIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LICHSGFIN',
            'AMBUJACEM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=AMBUJACEM',
            'ALKEM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ALKEM',
            'JINDALSTEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=JINDALSTEL',
            'CANBK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CANBK',
            'DEEPAKNTR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DEEPAKNTR',
            'MANAPPURAM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MANAPPURAM',
            'NAVINFLUOR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=NAVINFLUOR',
            'ACC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ACC',
            'BANDHANBNK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BANDHANBNK',
            'HAL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HAL',
            'BEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BEL',
            'ABCAPITAL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ABCAPITAL',
            'HINDCOPPER' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HINDCOPPER',
            'INDHOTEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INDHOTEL',
            'M%26MFIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=M%26MFIN',
            'PFC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PFC',
            'TATACONSUM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TATACONSUM',
            'TATAPOWER' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TATAPOWER',
            'ESCORTS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ESCORTS',
            'IDFC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IDFC',
            'BSOFT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BSOFT',
            'INDIACEM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INDIACEM',
            'ABBOTINDIA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ABBOTINDIA',
            'DIXON' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DIXON',
            'ADANIPORTS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ADANIPORTS',
            'DIVISLAB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DIVISLAB',
            'HINDALCO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HINDALCO',
            'IOC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IOC',
            'PIDILITIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PIDILITIND',
            'RECLTD' => 'https://www.nseindia.com/api/option-chain-equities?symbol=RECLTD',
            'ASHOKLEY' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ASHOKLEY',
            'COALINDIA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=COALINDIA',
            'OBEROIRLTY' => 'https://www.nseindia.com/api/option-chain-equities?symbol=OBEROIRLTY',
            'PNB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PNB',
            'BOSCHLTD' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BOSCHLTD',
            'INDIAMART' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INDIAMART',
            'APOLLOTYRE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=APOLLOTYRE',
            'JUBLFOOD' => 'https://www.nseindia.com/api/option-chain-equities?symbol=JUBLFOOD',
            'LALPATHLAB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LALPATHLAB',
            'PERSISTENT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PERSISTENT',
            'SRF' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SRF',
            'BAJAJFINSV' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BAJAJFINSV',
            'IRCTC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IRCTC',
            'M%26M' => 'https://www.nseindia.com/api/option-chain-equities?symbol=M%26M',
            'BANKBARODA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BANKBARODA',
            'CHOLAFIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CHOLAFIN',
            'CONCOR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CONCOR',
            'IEX' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IEX',
            'MFSL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MFSL',
            'TATACHEM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TATACHEM',
            'TECHM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TECHM',
            'VEDL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=VEDL',
            'KOTAKBANK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=KOTAKBANK',
            'L%26TFH' => 'https://www.nseindia.com/api/option-chain-equities?symbol=L%26TFH',
            'NESTLEIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=NESTLEIND',
            'POWERGRID' => 'https://www.nseindia.com/api/option-chain-equities?symbol=POWERGRID',
            'BIOCON' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BIOCON',
            'GODREJPROP' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GODREJPROP',
            'NAUKRI' => 'https://www.nseindia.com/api/option-chain-equities?symbol=NAUKRI',
            'SBIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SBIN',
            'TITAN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TITAN',
            'BAJFINANCE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BAJFINANCE',
            'COFORGE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=COFORGE',
            'EICHERMOT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=EICHERMOT',
            'TORNTPOWER' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TORNTPOWER',
            'GMRINFRA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GMRINFRA',
            'HCLTECH' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HCLTECH',
            'MCX' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MCX',
            'TATACOMM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TATACOMM',
            'TATAMOTORS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TATAMOTORS',
            'TATASTEEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TATASTEEL',
            'TORNTPHARM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TORNTPHARM',
            'TVSMOTOR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TVSMOTOR',
            'WIPRO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=WIPRO',
            'ZEEL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ZEEL',
            'DLF' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DLF',
            'HINDPETRO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HINDPETRO',
            'IPCALAB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IPCALAB',
            'NATIONALUM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=NATIONALUM',
            'PETRONET' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PETRONET',
            'TRENT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TRENT',
            'AARTIIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=AARTIIND',
            'CIPLA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CIPLA',
            'COLPAL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=COLPAL',
            'GLENMARK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GLENMARK',
            'IGL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IGL',
            'MCDOWELL-N' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MCDOWELL-N',
            'RELIANCE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=RELIANCE',
            'SAIL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SAIL',
            'ASIANPAINT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ASIANPAINT',
            'GAIL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GAIL',
            'HDFCLIFE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HDFCLIFE',
            'HAVELLS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HAVELLS',
            'RBLBANK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=RBLBANK',
            'ICICIBANK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ICICIBANK',
            'IDEA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IDEA',
            'LUPIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LUPIN',
            'METROPOLIS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=METROPOLIS',
            'MPHASIS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MPHASIS',
            'IDFCFIRSTB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IDFCFIRSTB',
            'SYNGENE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SYNGENE',
            'HDFCBANK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HDFCBANK',
            'ABFRL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ABFRL',
            'CUB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CUB',
            'EXIDEIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=EXIDEIND',
            'TCS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=TCS',
            'UPL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=UPL',
            'BAJAJ-AUTO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BAJAJ-AUTO',
            'FEDERALBNK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=FEDERALBNK',
            'HDFCAMC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HDFCAMC',
            'INDIGO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INDIGO',
            'MGL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MGL',
            'ZYDUSLIFE' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ZYDUSLIFE',
            'DALBHARAT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DALBHARAT',
            'IBULHSGFIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=IBULHSGFIN',
            'NMDC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=NMDC',
            'APOLLOHOSP' => 'https://www.nseindia.com/api/option-chain-equities?symbol=APOLLOHOSP',
            'BATAINDIA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BATAINDIA',
            'BHARTIARTL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BHARTIARTL',
            'BPCL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BPCL',
            'LTIM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LTIM',
            'PVR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PVR',
            'LTTS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LTTS',
            'GRASIM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GRASIM',
            'WHIRLPOOL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=WHIRLPOOL',
            'AMARAJABAT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=AMARAJABAT',
            'LAURUSLABS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LAURUSLABS',
            'AUROPHARMA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=AUROPHARMA',
            'MUTHOOTFIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MUTHOOTFIN',
            'HINDUNILVR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HINDUNILVR',
            'ICICIPRULI' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ICICIPRULI',
            'INTELLECT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INTELLECT',
            'MARICO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MARICO',
            'VOLTAS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=VOLTAS',
            'DRREDDY' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DRREDDY',
            'ITC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ITC',
            'RAMCOCEM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=RAMCOCEM',
            'BERGEPAINT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BERGEPAINT',
            'CUMMINSIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CUMMINSIND',
            'GODREJCP' => 'https://www.nseindia.com/api/option-chain-equities?symbol=GODREJCP',
            'JKCEMENT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=JKCEMENT',
            'AXISBANK' => 'https://www.nseindia.com/api/option-chain-equities?symbol=AXISBANK',
            'ATUL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ATUL',
            'DABUR' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DABUR',
            'INFY' => 'https://www.nseindia.com/api/option-chain-equities?symbol=INFY',
            'BALKRISIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BALKRISIND',
            'OFSS' => 'https://www.nseindia.com/api/option-chain-equities?symbol=OFSS',
            'POLYCAB' => 'https://www.nseindia.com/api/option-chain-equities?symbol=POLYCAB',
            'SRTRANSFIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SRTRANSFIN',
            'UBL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=UBL',
            'PAGEIND' => 'https://www.nseindia.com/api/option-chain-equities?symbol=PAGEIND',
            'CHAMBLFERT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=CHAMBLFERT',
            'LT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=LT',
            'MRF' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MRF',
            'RAIN' => 'https://www.nseindia.com/api/option-chain-equities?symbol=RAIN',
            'DELTACORP' => 'https://www.nseindia.com/api/option-chain-equities?symbol=DELTACORP',
            'HEROMOTOCO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HEROMOTOCO',
            'SUNPHARMA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SUNPHARMA',
            'ULTRACEMCO' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ULTRACEMCO',
            'NTPC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=NTPC',
            'HDFC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HDFC',
            'BRITANNIA' => 'https://www.nseindia.com/api/option-chain-equities?symbol=BRITANNIA', 
            'FSL' => 'https://www.nseindia.com/api/option-chain-equities?symbol=FSL',
            'SUNTV' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SUNTV',
            'MARUTI' => 'https://www.nseindia.com/api/option-chain-equities?symbol=MARUTI',
            'SHREECEM' => 'https://www.nseindia.com/api/option-chain-equities?symbol=SHREECEM',
            'ONGC' => 'https://www.nseindia.com/api/option-chain-equities?symbol=ONGC',
            'HONAUT' => 'https://www.nseindia.com/api/option-chain-equities?symbol=HONAUT',
    
        ];
        
          try {
            $headers = [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => 'https://www.nseindia.com/',
            ];
            $data = [];

            foreach($urls as $key => $url){
                $response = Http::withHeaders($headers)->timeout(60)->get($url);
               
                if ($response->successful()) {     
                    $data[$key] = $response->json();
                } else {
                    $data[$key] = ['Failed to fetch data'];
                }

                $attributes = ['key' => $key]; // Adjust according to your table schema
                $values = ['value' => json_encode($data[$key])];
    
                // Update or create record in the database
               StokDetail::updateOrCreate($attributes,$values);
              
            }
    
            return $this->sendResponse(null, 'Data Updated Successfully', true);
                
          } catch (\Throwable $th) {
          dd($th->getMessage());
            return $this->sendResponse(null, 'Internal Server Error', false);
          }
    }

    public function getStokDetail(Request $request){
        try {
            $symbol = $request->symbol;

            if(!isset($symbol) && empty($symbol)){
                return $this->sendResponse(null, 'symbol is required', false);
            }

            $stokDetail = StokDetail::where('key',$symbol)->first();

            if(isset($stokDetail)){
                $data = json_decode($stokDetail->value);
               return $this->sendResponse($data,'Data retrived SuccessFully',true);
            }else{
                return $this->sendResponse(null, 'Invalid symbol provided', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal server error',false);
        }
    }
}
