<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GannSolarDatesService
{
    protected $baseUrl = 'https://query1.finance.yahoo.com/v7/finance/download/';

    public function calculateGannSolarDates($start_date, $angles)
    {
        $days_per_degree = 365 / 360; // Value of 1 degree in days
        $gann_dates = [];

        foreach ($angles as $angle) {
            $days_offset = $angle * $days_per_degree;
            $gann_timestamp = strtotime($start_date) + round($days_offset) * 86400; // Calculate timestamp
            $gann_date = date('Y-m-d', $gann_timestamp);
            $gann_dates[$angle] = $gann_date;
        }

        return $gann_dates;
    }

    public function getStockPrices($symbol, $startDate, $endDate)
    {
        $period1 = strtotime($startDate);
        $period2 = strtotime($endDate);

        $url = $this->baseUrl . $symbol . '?period1=' . $period1 . '&period2=' . $period2 . '&interval=1d&events=history&includeAdjustedClose=true';

        $response = Http::get($url);

        if ($response->successful()) {
            return $this->parseCsv($response->body());
        }

        return null;
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
}
