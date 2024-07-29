<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class AngelOneService
{
    protected $apiToken;
    protected $apiKey;
    protected $clientCode;
    protected $password;
    protected $totp;

    // public function __construct()
    // {
    //     $this->apiKey = config('services.angel_broking.api_key');
    //     $this->clientCode = config('services.angel_broking.client_code');
    //     $this->password = config('services.angel_broking.password');
    //     $this->totp = config('services.angel_broking.totp'); // Optional, if 2FA is enabled
    //     $this->apiToken = $this->getAccessToken();
    // }

    // public function getSymbolToken($symbol)
    // {
       
    //     if (!$this->apiToken) {
    //         throw new Exception('API token is not set. Check your configuration.');
    //     }

    //     Log::info('Using API token: ' . $this->apiToken);

    //     $response = Http::withToken($this->apiToken)->get('https://api.angelone.in/symboltoken', [
    //         'symbol' => $symbol,
    //     ]);

    //     Log::info('Response: ' . $response->body());

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         if (is_array($data) && isset($data['symboltoken'])) {
    //             return $data['symboltoken'];
    //         } else {
    //             throw new Exception('Invalid response format or symboltoken not found in response.');
    //         }
    //     }else {
    //         throw new Exception('Failed to fetch symbol token: ' . $responseBody);
    //     }
    // }

    // public function placeOrder(array $orderData)
    // {
    //     $headers = [
    //         'Authorization' => 'Bearer ' . $this->apiToken,
    //         'Content-Type' => 'application/json',
    //         'Accept' => 'application/json',
    //         'X-ClientCode' => config('services.angel_broking.client_code'),
    //         'X-API-Key' => config('services.angel_broking.api_key'),
    //     ];

    //     Log::info('Headers: ' . json_encode($headers));

    //     $response = Http::withHeaders($headers)->post(config('services.angel_broking.api_endpoint'), $orderData);

    //     if ($response->successful()) {
    //         return $response->json();
    //     } else {
    //         throw new Exception('Failed to place order: ' . $response->body());
    //     }
    // }

    // protected function generateSessionToken()
    // {
    //     $client = new Client();
    
    //     try {
    //         $response = $client->post(config('services.angel_broking.api_endpoint'), [
    //             'json' => [
    //                 'clientcode' => $this->clientCode,
    //                 'password' => $this->password,
    //                 'totp' => $this->totp, // Optional if 2FA is enabled
    //             ],
    //             'headers' => [
    //                 'X-API-Key' => $this->apiKey,
    //                 'Content-Type' => 'application/json',
    //             ],
    //         ]);

    //         $statusCode = $response->getStatusCode();
    //         $responseBody = json_decode($response->getBody(), true);
    
    //         if ($statusCode == 200 && isset($responseBody['data']['jwtToken'])) {
    //             return $responseBody['data']['jwtToken'];
    //         } elseif ($statusCode == 200 && isset($responseBody['success']) && !$responseBody['success']) {
    //             $errorMessage = isset($responseBody['message']) ? $responseBody['message'] : 'Unknown error occurred';
    //             throw new Exception('Failed to generate session token: ' . $errorMessage);
    //         } else {
    //             throw new Exception('Failed to generate session token: Unexpected response');
    //         }
    //     } catch (Exception $e) {
    //         Log::error('Error generating session token: ' . $e->getMessage());
    //         throw $e;
    //     }
    // }
    
    protected function generateAccessToken($sessionToken)
    {
        $client = new Client();

        $response = $client->post('https://apiconnect.angelbroking.com/rest/auth/angelbroking/user/v1/token', [
            'json' => [
                'refreshToken' => $sessionToken,
            ],
            'headers' => [
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);
            return $data['data']['accessToken'];
        } else {
            throw new Exception('Failed to generate access token: ' . $response->getBody());
        }
    }

    // protected function getAccessToken()
    // {
    //     try {
    //         $sessionToken = $this->generateSessionToken();
    //         $accessToken = $this->generateAccessToken($sessionToken);
    //         return $accessToken;
    //     } catch (Exception $e) {
    //         Log::error('Error generating access token: ' . $e->getMessage());
    //         throw $e;
    //     }
    // }
}
