<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Digiflazz
{
    public function balance()
    {
        $url = 'https://api.digiflazz.com/v1/cek-saldo';
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('DIGIFLAZZ_APIKEY');
        $cmd = 'deposit';
        $signature = md5($username . $apiKey . 'depo');

       $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [
            'cmd' => $cmd,
            'username' => $username,
            'sign' => $signature,
        ]);

        $balance = $response->json()['data']['deposit'];

        return $balance;
    }
}