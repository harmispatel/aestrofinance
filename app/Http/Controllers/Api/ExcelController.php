<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\AmavasyaDate;
use App\Models\BhadraData;
use App\Models\Grah;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\GrahViseData;
use App\Models\ImportantGrah;
use App\Models\GannStokes;
use App\Models\Degree;
use App\Models\ImportantValue;
use App\Models\Intraday;
use App\Models\Trayodashi;
use App\Models\IntraValue;
use App\Models\NightGrahWiseData;
use Carbon\Carbon;
use DB;
use Google_Client;
use Google_Service_Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ExcelController extends BaseController
{

    protected $baseUrl = 'https://query1.finance.yahoo.com/v7/finance/download/';
    public function getHighestClose(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $symbol = $request->input('symbol');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $period1 = strtotime($startDate);
        $period2 = strtotime($endDate);

        $url = $this->baseUrl . $symbol . '?period1=' . $period1 . '&period2=' . $period2 . '&interval=1d&events=history&includeAdjustedClose=true';

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $this->parseCsv($response->body());
            $highestCloseDate = $this->getHighestCloseDate($data);
            return response()->json([
                'success' => true,
                'date' => $highestCloseDate,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch data from Yahoo Finance',
        ], 500);
    }

    protected function parseCsv($csvString)
    {
        $lines = explode(PHP_EOL, $csvString);
        $header = str_getcsv(array_shift($lines));
        $data = [];

        foreach ($lines as $line) {
            if (!empty(trim($line))) {
                $row = str_getcsv($line);
                $data[] = array_combine($header, $row);
            }
        }

        return $data;
    }

    protected function getHighestCloseDate($data)
    {
        $highestClose = -INF;
        $highestCloseDate = null;

        foreach ($data as $row) {
            if (isset($row['Close']) && $row['Close'] > $highestClose) {
                $highestClose = $row['Close'];
                $highestCloseDate = $row['Date'];
            }
        }

        return $highestCloseDate;
    }

    public function getTrayodashi(){
          try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Trayodashi::truncate();

            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'Trayodashi-2024';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            $data = [];
            foreach($values as $value){
                $daterange = $value[0];

                list($startDateStr,$endDateStr) = explode(' - ',$daterange);

                Trayodashi::create([
                     'start_date_time' => $startDateStr,
                     'end_date_time' => $endDateStr
                ]);


            }

            return $this->sendResponse(null,'Data Saved SuccessFully',true);

          } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal Server Error',false);
          }
    }


    public function importantValue(Request $request)
    {
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            ImportantValue::truncate();

            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'mpanchang-2024';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            // Define the chunk size
            $chunkSize = 14;

            // Calculate the total number of chunks needed
            $totalChunks = ceil(count($values) / $chunkSize);

            // Process each chunk
            for ($chunkIndex = 0; $chunkIndex < $totalChunks; $chunkIndex++) {
                // Calculate the starting index of the current chunk
                $startIndex = $chunkIndex * $chunkSize;

                // Slice the array to get the current chunk
                $chunkValues = array_slice($values, $startIndex, $chunkSize);

                // Check if the chunk has at least one row
                if (empty($chunkValues) || !isset($chunkValues[0][0])) {
                    continue; // Skip this chunk if it's empty or doesn't have a date
                }

                $date = $chunkValues[0][0];

                $date = Carbon::createFromFormat('d-m-Y',$date);

                $date = $date->format('Y-m-d');


                for ($i = 2; $i < count($chunkValues); $i++) {
                    // Ensure each row has enough columns
                    if (count($chunkValues[$i]) >= 3) {
                        $grah_name = $chunkValues[$i][0];
                        $degree = $chunkValues[$i][1];
                        $degree_absolute = $chunkValues[$i][2];

                        ImportantValue::create([
                            'date' => $date,
                            'grah_name' => $grah_name,
                            'degree' => $degree,
                            'deg_absolute' => $degree_absolute,
                        ]);
                    }
                }

            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);

        } catch (\Throwable $th) {
            dd($th);
            return $this->sendResponse(null, 'Internal server error', false);
        }
    }

    public function ganStockPrice(Request $request){
        try {
            $client = new Client();

            $stock = $request->stock;
            // Define the URL
            $startDate = strtotime($request->input('start_date')); // Convert to Unix timestamp
            $endDate = strtotime($request->input('end_date'));  // Example end date

            // Define the URL with valid timestamps
            $url = "https://query1.finance.yahoo.com/v7/finance/download/{$stock}?period1={$startDate}&period2={$endDate}";

            // Send the GET request
            $response = $client->get($url);
            $data = $response->getBody()->getContents();

            $lines = explode(PHP_EOL, $data);
            $header = null;
            $csvData = [];

            foreach ($lines as $line) {
                if (!empty($line)) {
                    $row = str_getcsv($line);
                    if ($header === null) {
                        $header = $row;
                    } else {
                        $csvData[] = array_merge($header, $row);
                    }
                }
            }

            if(empty($csvData)){
                $this->sendResponse(null, 'Data Not Found', false);
            }else{
                foreach ($csvData as $data) {

                    $date = Carbon::createFromFormat('Y-m-d', $data[7])->format('d-m-Y');

                    //d_0 Data
                    $d_0 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_0, '%d-%m-%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_0->isEmpty()) {
                        foreach ($d_0 as $record) {
                            $record->update([
                                'price_high_0' => $data[9],
                                'price_low_0' => $data[10],
                                'close_0' => $data[11],
                            ]);
                        }
                    }
                    //d_30 Data
                    $d_30 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_30, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_30->isEmpty()) {
                        foreach ($d_30 as $record) {
                            $record->update([
                                'price_high_30' => $data[9],
                                'price_low_30' => $data[10],
                                'close_30' => $data[11],
                            ]);
                        }
                    }

                    //d_45 Data
                    $d_45 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_45, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    // Update d_45 if records exist
                        if (!$d_45->isEmpty()) {
                            foreach ($d_45 as $record) {
                                $record->update([
                                    'price_high_45' => $data[9],
                                    'price_low_45' => $data[10],
                                    'close_45' => $data[11],
                                ]);
                            }
                        }

                    //d_60 Data
                    $d_60 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_60, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_60->isEmpty()) {
                        foreach ($d_60 as $record) {
                            $record->update([
                                'price_high_60' => $data[9],
                                'price_low_60' => $data[10],
                                'close_60' => $data[11],
                            ]);
                        }
                    }

                    //d_72 Data
                    $d_72 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_72, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_72->isEmpty()) {
                        foreach ($d_72 as $record) {
                            $record->update([
                                'price_high_72' => $data[9],
                                'price_low_72' => $data[10],
                                'close_72' => $data[11],
                            ]);
                        }
                    }

                    //d_90 Data
                    $d_90 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_90, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_90->isEmpty()) {
                        foreach ($d_90 as $record) {
                            $record->update([
                                'price_high_90' => $data[9],
                                'price_low_90' => $data[10],
                                'close_90' => $data[11],
                            ]);
                        }
                    }

                    //d_120 Data
                    $d_120 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_120, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_120->isEmpty()) {
                        foreach ($d_120 as $record) {
                            $record->update([
                                'price_high_120' => $data[9],
                                'price_low_120' => $data[10],
                                'close_120' => $data[11],
                            ]);
                        }
                    }

                    //d_135 Data
                    $d_135 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_135, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_135->isEmpty()) {
                        foreach ($d_135 as $record) {
                            $record->update([
                                'price_high_135' => $data[9],
                                'price_low_135' => $data[10],
                                'close_135' => $data[11],
                            ]);
                        }
                    }

                    //d_150 Data
                    $d_150 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_150, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_150->isEmpty()) {
                        foreach ($d_150 as $record) {
                            $record->update([
                                'price_high_150' => $data[9],
                                'price_low_150' => $data[10],
                                'close_150' => $data[11],
                            ]);
                        }
                    }

                    //d_180 Data
                    $d_180 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_180, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_180->isEmpty()) {
                        foreach ($d_180 as $record) {
                            $record->update([
                                'price_high_180' => $data[9],
                                'price_low_180' => $data[10],
                                'close_180' => $data[11],
                            ]);
                        }
                    }

                    //d_210 Data
                    $d_210 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_210, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_210->isEmpty()) {
                        foreach ($d_210 as $record) {
                            $record->update([
                                'price_high_210' => $data[9],
                                'price_low_210' => $data[10],
                                'close_210' => $data[11],
                            ]);
                        }
                    }

                    //d_225 Data
                    $d_225 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_225, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_225->isEmpty()) {
                        foreach ($d_225 as $record) {
                            $record->update([
                                'price_high_225' => $data[9],
                                'price_low_225' => $data[10],
                                'close_225' => $data[11],
                            ]);
                        }
                    }

                    //d_240 Data
                    $d_240 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_240, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_240->isEmpty()) {
                        foreach ($d_240 as $record) {
                            $record->update([
                                'price_high_240' => $data[9],
                                'price_low_240' => $data[10],
                                'close_240' => $data[11],
                            ]);
                        }
                    }

                    //d_252 Data
                    $d_252 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_252, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_252->isEmpty()) {
                        foreach ($d_252 as $record) {
                            $record->update([
                                'price_high_252' => $data[9],
                                'price_low_252' => $data[10],
                                'close_252' => $data[11],
                            ]);
                        }
                    }

                    //d_270 Data
                    $d_270 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_270, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_270->isEmpty()) {
                        foreach ($d_270 as $record) {
                            $record->update([
                                'price_high_270' => $data[9],
                                'price_low_270' => $data[10],
                                'close_270' => $data[11],
                            ]);
                        }
                    }

                    //d_288 Data
                    $d_288 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_288, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_288->isEmpty()) {
                        foreach ($d_288 as $record) {
                            $record->update([
                                'price_high_288' => $data[9],
                                'price_low_288' => $data[10],
                                'close_288' => $data[11],
                            ]);
                        }
                    }

                    //d_300 Data
                    $d_300 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_300, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_300->isEmpty()) {
                        foreach ($d_300 as $record) {
                            $record->update([
                                'price_high_300' => $data[9],
                                'price_low_300' => $data[10],
                                'close_300' => $data[11],
                            ]);
                        }
                    }

                    //d_315 Data
                    $d_315 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_315, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_315->isEmpty()) {
                        foreach ($d_315 as $record) {
                            $record->update([
                                'price_high_315' => $data[9],
                                'price_low_315' => $data[10],
                                'close_315' => $data[11],
                            ]);
                        }
                    }

                    //d_330 Data
                    $d_330 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_330, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_330->isEmpty()) {
                        foreach ($d_330 as $record) {
                            $record->update([
                                'price_high_330' => $data[9],
                                'price_low_330' => $data[10],
                                'close_330' => $data[11],
                            ]);
                        }
                    }

                    //d_360 Data
                    $d_360 = GannStokes::where('stokes', 'LIKE', substr($stock, 0, 3) . '%')->whereRaw("STR_TO_DATE(d_360, '%d/%m/%Y') = STR_TO_DATE('{$date}', '%d-%m-%Y')")->get();

                    if (!$d_360->isEmpty()) {
                        foreach ($d_360 as $record) {
                            $record->update([
                                'price_high_360' => $data[9],
                                'price_low_360' => $data[10],
                                'close_360' => $data[11],
                            ]);
                        }
                    }

                }

              return $this->sendResponse(null,'Data Update SuccessFully',true);

            }


        } catch (\Throwable $th) {
          dd($th);
          return $this->sendResponse(null,'Some thing went wrong',false);
        }
    }

    public function degree(Request $request)
    {
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Degree::truncate();

            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'degree';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            foreach($values as $index => $degree){

                Degree::create([
                    'degree' => $degree[0]
                ]);
            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);

        } catch (\Throwable $th) {
            dd($th);
            return $this->sendResponse(null, 'Internal server error', false);
        }
    }

    public function getAmavashya() {
        try {
            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheet name
            $sheet = 'amavashya-2024';
            $range = $sheet;
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            // Check if the values are empty or not
            if (empty($values)) {
                return response()->json(['success' => false, 'message' => 'No data found in the sheet.']);
            }

            // Process the values
            foreach ($values as $index => $row) {

                // Extract values from the row
                $amavasya = $row[0] ?? null;
                $date = $row[1] ?? null;
                $start_time = $row[2] ?? null;
                $end_time = $row[4] ?? null;

                // Initialize the AmavasyaDate model
                $amavasyaDate = new AmavasyaDate();

                // Validate and format date and times
                try {
                    $amavasyaDate->start_time = $start_time ? Carbon::createFromFormat('F j, Y - g:i A', $start_time)->format('Y-m-d H:i:s') : null;
                    $amavasyaDate->end_time = $end_time ? Carbon::createFromFormat('F j, Y - g:i A', $end_time)->format('Y-m-d H:i:s') : null;
                    $amavasyaDate->save();
                } catch (\Exception $e) {
                    Log::error('Error processing row ' . ($index + 1) . ': ' . $e->getMessage());
                    // Continue to the next iteration
                    continue;
                }
            }

            return response()->json(['success' => true, 'message' => 'Data processed successfully.']);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $th->getMessage()]);
        }
    }
    // public function importantValue(Request $request)
    // {
    //     try {
    //         // Enable foreign key checks
    //         DB::statement('SET FOREIGN_KEY_CHECKS=1');

    //         $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
    //         $client = new Google_Client();
    //         $client->setDeveloperKey($developer_key);
    //         $client->setAuthConfig(base_path('sheet_credentials.json'));
    //         $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
    //         $service = new Google_Service_Sheets($client);
    //         $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

    //         // Specify the sheets you want to retrieve data from
    //         $sheet = 'mpanchang-2024';
    //         $range = $sheet; // You can adjust the range as needed
    //         $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    //         $values = $response->getValues();

    //         // Define the chunk size
    //         $chunkSize = 14;
    //         $data = [];
    //         // Calculate the total number of chunks needed
    //         $totalChunks = ceil(count($values) / $chunkSize);

    //         // Process each chunk
    //         for ($chunkIndex = 0; $chunkIndex < $totalChunks; $chunkIndex++) {
    //             // Calculate the starting index of the current chunk
    //             $startIndex = $chunkIndex * $chunkSize;

    //             // Slice the array to get the current chunk
    //             $chunkValues = array_slice($values, $startIndex, $chunkSize);

    //             // Check if the chunk has data

    //             // Extract the date from the first row of the chunk
    //             $date_value = $chunkValues[0]; // Assuming the date is in the first column of the first row
    //             $date_parse = Carbon::parse($date_value);
    //             $date = $date_parse->format('Y-m-d');
    //             $data[] = $date;
    //             // Loop through the rest of the rows in the chunk
    //             foreach ($chunkValues as $index => $value) {
    //                 // Skip the first row as it contains the date
    //                 if ($index === 0) {
    //                     continue;
    //                 }

    //                 // Save data to the database
    //                 ImportantValue::create([
    //                     'date' => $date,
    //                     'grah_name' => $value[0],
    //                     'degree' => $value[1],
    //                     'deg_absolute' => $value[2],
    //                 ]);

    //             }

    //             dd($data);
    //         }

    //         return $this->sendResponse(null, 'Data Saved Successfully', true);

    //     } catch (\Throwable $th) {

    //         dd($th);
    //         return $this->sendResponse(null, 'Internal server error', false);
    //     }
    // }

    public function extractDataIntraday()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Truncate tables
            Intraday::truncate();
            IntraValue::truncate();

            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            $importantGrahData = ImportantGrah::get();

            $processedDates = [];

            foreach ($importantGrahData as $data) {
                $grahWiseData = GrahViseData::find($data->grah_wise_id);

                if ($grahWiseData) {
                    $date = $grahWiseData->date;
                    $formattedDate = date('Y-m-d', strtotime($date));

                    // Check if date has already been processed
                    if (!isset($processedDates[$formattedDate])) {
                        $processedDates[$formattedDate] = true;

                        // Create Intraday record
                        $intraday = Intraday::create([
                            'date' => $formattedDate,
                            // Add other fields as needed
                        ]);

                    }

                    // Format and create IntraValue record
                    $startTime = date('H:i:s', strtotime($grahWiseData->start_time . ' -15 minutes'));
                    $endTime = date('H:i:s', strtotime($grahWiseData->end_time . ' -15 minutes'));

                    IntraValue::create([
                        'intraday_id' => $intraday->id,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        // Add other fields as needed
                    ]);
                }
            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    //day hora

    public function dayHoraGrahWiseData()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Truncate tables
            GrahViseData::truncate();

            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'Sheet1';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            // Store the values in an array, associating them with the sheet name
            $sheet = $values;
            unset($sheet[0]);

            $items = array_values($sheet);

            // Predefined grah names array
            $grahname = [
                'Mars - Aggressive',
                'Sun - Vigorous',
                'Moon - Gentle',
                'Saturn - Sluggish',
                'Jupiter - Fruitful',
                'Mercury - Quick',
                'Venus - Beneficial',
            ];

            if (count($items) > 0) {
                foreach ($items as $item) {
                    if (isset($item[1], $item[2])) {
                        $date = $item[1];
                        $normalizedDate = date('d-m-Y', strtotime($date));
                        $grahnames_str = $item[2];

                        // Remove "Day Hora" and "Night Hora" from the string
                        $grahnames_str = preg_replace('/Day Hora\d{2}:\d{2} [AP]M/', '', $grahnames_str);

                        $extracted_data = [];

                        // Pattern to match grah name followed by time range
                        $pattern = '/(' . implode('|', $grahname) . ')(\d{2}:\d{2} [AP]M to \d{2}:\d{2} [AP]M)/';

                        // Perform regex matching day hora
                        preg_match_all($pattern, $grahnames_str, $matches, PREG_SET_ORDER);

                        foreach ($matches as $match) {

                            $grah_name = $match[1];
                            $time_range = $match[2];

                            // Extract start time and end time from time range
                            preg_match('/(\d{2}:\d{2} [AP]M) to (\d{2}:\d{2} [AP]M)/', $time_range, $time_matches);
                            $start_time = $time_matches[1];

                            $end_time = $time_matches[2];

                            $grah_id = Grah::where('name', $grah_name)->value('id');

                            if ($grah_id) {
                                // Insert into database using GrahWiseData model
                                GrahViseData::create([
                                    'date' => $normalizedDate,
                                    'grah_id' => $grah_id,
                                    'start_time' => $start_time,
                                    'end_time' => $end_time,
                                ]);
                            }
                        }
                    }
                }
            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal server error', false);
        }
    }

    //night hora

    public function nightHoraGrahWiseData()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Truncate tables
            NightGrahWiseData::truncate();

            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'Sheet1';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            // Store the values in an array, associating them with the sheet name
            $sheet = $values;
            unset($sheet[0]);

            $items = array_values($sheet);

            // Predefined grah names array
            $grahname = [
                'Mars - Aggressive',
                'Sun - Vigorous',
                'Moon - Gentle',
                'Saturn - Sluggish',
                'Jupiter - Fruitful',
                'Mercury - Quick',
                'Venus - Beneficial',
            ];

            if (count($items) > 0) {
                foreach ($items as $item) {
                    if (isset($item[1], $item[2])) {
                        $date = $item[1];
                        $normalizedDate = date('d-m-Y', strtotime($date));
                        $night_grahname = $item[3];

                        // Remove "Day Hora" and "Night Hora" from the string
                        $night_grahname = preg_replace('/Night Hora\d{2}:\d{2} [AP]M/', '', $night_grahname);

                        $extracted_data = [];

                        // Pattern to match grah name followed by time range
                        $pattern = '/(' . implode('|', $grahname) . ')(\d{2}:\d{2} [AP]M to \d{2}:\d{2} [AP]M)/';

                        // Perform regex matching day hora
                        preg_match_all($pattern, $night_grahname, $matches, PREG_SET_ORDER);

                        foreach ($matches as $match) {

                            $grah_name = $match[1];

                            $time_range = $match[2];

                            // Extract start time and end time from time range
                            preg_match('/(\d{2}:\d{2} [AP]M) to (\d{2}:\d{2} [AP]M)/', $time_range, $time_matches);
                            $start_time = $time_matches[1];
                            $end_time = $time_matches[2];

                            $grah_id = Grah::where('name', $grah_name)->value('id');

                            if ($grah_id) {
                                // Insert into database using GrahWiseData model
                                NightGrahWiseData::create([
                                    'date' => $normalizedDate,
                                    'grah_id' => $grah_id,
                                    'start_time' => $start_time,
                                    'end_time' => $end_time,
                                ]);
                            }
                        }
                    }
                }
            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);
        } catch (\Throwable $th) {
            dd($th);
            return $this->sendResponse(null, 'Internal server error', false);
        }
    }

    public function bhadraData(Request $request)
    {
        BhadraData::truncate();

        try {
            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'Sheet4';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            unset($values[0]);
            unset($values[1]);
            unset($values[2]);
            unset($values[3]);

            $results = [];

            $skip = false; // Flag to determine whether to skip or include the value

            foreach ($values as $index => $value) {
                if (!$skip) {
                    $results[] = $value; // Add value to result if not skipping
                }

                $skip = !$skip; // Toggle the skip flag
            }

            foreach ($results as $index => $value) {
                $startString = "Bhadra Starts From";
                $startIndex = strpos($value[3], $startString);

                if ($startIndex !== false) {
                    $startDate = substr($value[3], $startIndex + strlen($startString));
                    $startDate = trim($startDate);
                    $bhadraData[$index]['startdateandtime'] = $startDate;
                }

                $endString = "Bhadra Ends";
                $endIndex = strpos($value[3], $endString);

                if ($endIndex !== false) {
                    $endDate = substr($value[3], $endIndex + strlen($endString));
                    $endDate = trim($endDate);
                    $bhadraData[$index]['enddateandtime'] = $endDate;
                }
            }

            foreach ($bhadraData as $index => $value) {

                if ($index % 2 == 0) { // Check if index is even (start date)
                    // Ensure next index exists and is the end date
                    if (isset($bhadraData[$index + 1])) {
                        // Format start date/time
                        $startDateTime = $value['startdateandtime'];
                        preg_match('/([A-Za-z]+)\s+\((\d{1,2})\s+([A-Za-z]+)\s+(\d{4})\) at (\d{1,2}):(\d{2})\s+(AM|PM)/', $startDateTime, $matches);
                        $monthName = $matches[3];
                        $monthNumber = date('m', strtotime($monthName . ' 1 2000'));
                        $startDate = Carbon::createFromDate($matches[4], $monthNumber, $matches[2])
                            ->setTime($matches[5], $matches[6])
                            ->setTimezone('UTC'); // Adjust timezone as needed
                        $formattedStartDateTime = $startDate->format('Y-m-d H:i:s');

                        // Format end date/time
                        $endDateTime = $bhadraData[$index + 1]['enddateandtime'];
                        preg_match('/([A-Za-z]+)\s+\((\d{1,2})\s+([A-Za-z]+)\s+(\d{4})\) at (\d{1,2}):(\d{2})\s+(AM|PM)/', $endDateTime, $endMatches);
                        $endMonthName = $endMatches[3];
                        $endMonthNumber = date('m', strtotime($endMonthName . ' 1 2000'));
                        $endDate = Carbon::createFromDate($endMatches[4], $endMonthNumber, $endMatches[2])
                            ->setTime($endMatches[5], $endMatches[6])
                            ->setTimezone('UTC'); // Adjust timezone as needed
                        $formattedEndDateTime = $endDate->format('Y-m-d H:i:s');

                        // Store as pair
                        BhadraData::create([
                            'start_date_time' => $formattedStartDateTime,
                            'end_date_time' => $formattedEndDateTime,
                        ]);
                    }
                }
            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);

        } catch (\Throwable $th) {
            dd($th);
            return $this->sendResponse(null, 'some thing went wrong', false);
        }

    }

    public function currentDateGrah(Request $request)
    {
        try {
              if($request->date){
                $date = $request->date;
              }else{
                $date = Carbon::now();
                $date = $date->format('Y-m-d');
              }

            $intraday = Intraday::where('date', $date)->first();

            if (!$intraday) {
                return $this->sendResponse(null, 'Data not found', false);
            }

            $intravalues = IntraValue::where('intraday_id', $intraday->id)->get();

            $response = [
                'date' => $intraday->date,
                'data' => [],
            ];

            foreach ($intravalues as $intra) {
                $response['data'][] = [
                    'start_time' => $intra->start_time,
                    'end_time' => $intra->end_time,
                    'buy_or_sale' => $intra->buy_or_sale,
                    'nifty_or_banknifty' => $intra->nifty_or_banknifty,
                    'featureby_or_optionby' => $intra->featureby_or_optionby,
                    'target_price' => $intra->target_price,
                    'quantity' => $intra->quantity,
                ];
            }

            return $this->sendResponse($response, 'Data retrived SuccessFully', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function importantGrah()
    {
        try {
            ImportantGrah::truncate();

            $developer_key = 'AIzaSyDGkJtS1GZTJIZY5SchZb-CTTMKMxDsCF0';
            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = '1Pwmv4E5pe9wZDVMmPwvQICwe4ZeQGevg8tzs3rP7Buc';

            // Specify the sheets you want to retrieve data from
            $sheet = 'Sheet2';

            $range = $sheet; // You can adjust the range as needed
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            // Store the values in an array, associating them with the sheet name
            $sheet = $values;
            $items = array_values($sheet);

            $filteredItems = [];

            foreach ($items as $index => $item) {
                // Skip every third item
                if (($index + 1) % 3 !== 0) {
                    $filteredItems[] = $item;
                }
            }

            foreach ($filteredItems as $item) {
                $date = $item[3];
                $grahname = $item[4];
                $degre = $item[5];

                // Normalize the date format for comparison
                //    $normalizedDate = date('F j, Y, l', strtotime($date));
                $normalizedDate = date('d-m-Y', strtotime($date));

                $grah_id = Grah::where('name', 'LIKE', substr($grahname, 0, 3) . '%')
                    ->value('id');

                if (!empty($date)) {
                    $grahsWiseData = GrahViseData::where('date', $normalizedDate)
                        ->where('grah_id', $grah_id)
                        ->where(function ($query) {
                            // Time range condition: 09:15 AM to 03:30 PM
                            $query->whereBetween(DB::raw('TIME_FORMAT(STR_TO_DATE(start_time, "%h:%i %p"), "%H:%i:%s")'), ['09:15:00', '15:30:00'])
                                ->whereBetween(DB::raw('TIME_FORMAT(STR_TO_DATE(end_time, "%h:%i %p"), "%H:%i:%s")'), ['09:15:00', '15:30:00']);
                        })
                        ->first();
                    // Update previous values
                    $previousDate = $normalizedDate;

                } else {

                    if ($previousDate !== null) {
                        $grahsWiseData = GrahViseData::where('date', $previousDate)
                            ->where('grah_id', $grah_id)
                            ->where(function ($query) {
                                // Time range condition: 09:15 AM to 03:30 PM
                                $query->whereBetween(DB::raw('TIME_FORMAT(STR_TO_DATE(start_time, "%h:%i %p"), "%H:%i:%s")'), ['09:15:00', '15:30:00'])
                                    ->whereBetween(DB::raw('TIME_FORMAT(STR_TO_DATE(end_time, "%h:%i %p"), "%H:%i:%s")'), ['09:15:00', '15:30:00']);
                            })
                            ->first();
                    }

                }

                if ($grahsWiseData !== null) {
                    if (!empty($date)) {
                        $importantData = ImportantGrah::create([
                            'date' => $normalizedDate,
                            'grah_wise_id' => $grahsWiseData->id,
                            'degre' => $degre,
                        ]);

                        // Update previous values
                        $previousDate = $normalizedDate;

                    } else {
                        // If date is empty, use previous stored values
                        if ($previousDate !== null) {
                            $importantData = ImportantGrah::create([
                                'date' => $previousDate,
                                'grah_wise_id' => $grahsWiseData->id, // Use previous grahname
                                'degre' => $degre, // Use previous degre
                            ]);
                        }
                    }
                }
            }

            return $this->sendResponse(null, 'Data Saved SuccessFully', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal server error', false);

        }
    }

}
