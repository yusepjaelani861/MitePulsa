<?php

namespace App\Http\Controllers;

use App\Models\Digiflazz\Balance;
use App\Models\Digiflazz\TopUp;
use App\Models\Digiflazz\WebhookLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DigiflazzController extends Controller
{
    public function cek_saldo()
    {
        $url = 'https://api.digiflazz.com/v1/cek-saldo';
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('APP_ENV') == 'production' ? env('DIGIFLAZZ_APIKEY_PRODUCTION') : env('DIGIFLAZZ_APIKEY_SANDBOX');
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

        Balance::updateOrCreate(
            ['id' => 1],
            ['balance' => $balance]
        );

        return $this->sendResponse([
            'balance' => $balance,
        ], 'Success get balance');
    }

    public function daftar_harga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cmd' => 'required|in:prepaid,pasca'
        ]);
 
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }

        $url = 'https://api.digiflazz.com/v1/price-list';
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('APP_ENV') == 'production' ? env('DIGIFLAZZ_APIKEY_PRODUCTION') : env('DIGIFLAZZ_APIKEY_SANDBOX');
        $cmd = $request->cmd;
        $signature = md5($username . $apiKey . 'pricelist');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [
            'cmd' => $cmd,
            'username' => $username,
            'sign' => $signature,
        ]);

        $data = $response->json()['data'];

        foreach ($data as $key => $value) {
            Product::updateOrCreate([
                'buyer_sku_code' => $value['buyer_sku_code'],
            ], [
                'product_name' => $value['product_name'],
                'category' => $value['category'],
                'brand' => $value['brand'],
                'type' => $value['type'],
                'seller_name' => $value['seller_name'],
                'price' => $value['price'],
                'buyer_sku_code' => $value['buyer_sku_code'],
                'buyer_product_status' => $value['buyer_product_status'] == true ? 1 : 0,
                'seller_product_status' => $value['seller_product_status'] == true ? 1 : 0,
                'unlimited_stock' => $value['unlimited_stock'] == true ? 1 : 0,
                'stock' => $value['stock'],
                'multi' => $value['multi'] == true ? 1 : 0,
                'start_cut_off' => $value['start_cut_off'],
                'end_cut_off' => $value['end_cut_off'],
                'desc' => $value['desc'],
            ]);
        }

        return $this->sendResponse($data, 'Success get price list');
    }

    public function topup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku_code' => 'required|string',
            'number' => 'required|numeric',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }
        
        if (Auth::user()->role_id != 2) {
            return $this->sendError('You cannot allow to acccess this api', [], 'PROCESS_ERROR', '400');
        }

        $url = 'https://api.digiflazz.com/v1/transaction';
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('APP_ENV') == 'production' ? env('DIGIFLAZZ_APIKEY_PRODUCTION') : env('DIGIFLAZZ_APIKEY_SANDBOX');
        
        $ref_id = Str::random(15);
        while (TopUp::where('ref_id', $ref_id)->exists()) {
            $ref_id = Str::random(15);
        }

        $testing = env('APP_ENV') === 'production' ? false : true;
        $signature = md5($username . $apiKey . $ref_id);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [
            'username' => $username,
            'sign' => $signature,
            'ref_id' => $ref_id,
            'buyer_sku_code' => $request->sku_code,
            'customer_no' => $request->number,
            'testing' => $testing,
            'msg' => 'Topup ' . $request->sku_code . ' to ' . $request->number . ' with message: ' . $request->message,
        ]);

        $data = $response->json()['data'];
        
        file_put_contents(storage_path('logs/topup.json'), json_encode($response->json()), FILE_APPEND);
        try {
            TopUp::create([
                'user_id' => Auth::user()->id,
                'ref_id' => $ref_id,
                'customer_no' => $request->number,
                'buyer_sku_code' => $request->sku_code,
                'message' => $request->message,
                'status' => $data['status'],
                'rc' => $data['rc'],
                'buyer_last_saldo' => $data['buyer_last_saldo'],
                'sn' => $data['sn'],
                'price' => $data['price'],
                'tele' => $data['tele'],
                'wa' => $data['wa'],
            ]);
            
            return $this->sendResponse($data, 'Success topup');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getTrace(), 'SERVER_ERROR', 500);
        }
    }

    public function cek_tagihan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku_code' => 'required|string',
            'number' => 'required|numeric',
            'ref_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }

        $url = 'https://api.digiflazz.com/v1/transaction';
        $cmd = 'inq-pasca';
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('APP_ENV') == 'production' ? env('DIGIFLAZZ_APIKEY_PRODUCTION') : env('DIGIFLAZZ_APIKEY_SANDBOX');
        $ref_id = $request->ref_id;
        $testing = env('APP_ENV') === 'production' ? false : true;
        $signature = md5($username . $apiKey . $ref_id);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [
            'commands' => $cmd,
            'username' => $username,
            'buyer_sku_code' => $request->sku_code,
            'customer_no' => $request->number,
            'ref_id' => $ref_id,
            'sign' => $signature,
            'testing' => $testing,
        ]);

        $data = $response->json()['data'];

        TopUp::where('ref_id', $ref_id)->update([
            'status' => $data['status'],
            'rc' => $data['rc'],
            'buyer_last_saldo' => $data['buyer_last_saldo'],
            'sn' => $data['sn'],
            'price' => $data['price'],
        ]);

        return $this->sendResponse($data, 'Success check bill');
    }

    public function bayar_tagihan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku_code' => 'required|string',
            'number' => 'required|numeric',
            'ref_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }

        $url = 'https://api.digiflazz.com/v1/transaction';
        $cmd = 'pay-pasca';
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('APP_ENV') == 'production' ? env('DIGIFLAZZ_APIKEY_PRODUCTION') : env('DIGIFLAZZ_APIKEY_SANDBOX');
        $ref_id = $request->ref_id;
        $testing = env('APP_ENV') === 'production' ? false : true;
        $signature = md5($username . $apiKey . $ref_id);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [
            'commands' => $cmd,
            'username' => $username,
            'buyer_sku_code' => $request->sku_code,
            'customer_no' => $request->number,
            'ref_id' => $ref_id,
            'sign' => $signature,
            'testing' => $testing,
        ]);

        $data = $response->json()['data'];

        TopUp::where('ref_id', $ref_id)->update([
            'status' => $data['status'],
            'rc' => $data['rc'],
            'buyer_last_saldo' => $data['buyer_last_saldo'],
            'sn' => $data['sn'],
            'price' => $data['price'],
        ]);

        return $this->sendResponse($data, 'Success pay bill');
    }

    public function inquiry_pln(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }

        $url = 'https://api.digiflazz.com/v1/transaction';
        $cmd = 'pln-subscribe';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [
            'commands' => $cmd,
            'customer_no' => $request->number,
        ]);

        $data = $response->json()['data'];

        return $this->sendResponse($data, 'Success inquiry pln');
    }

    public function webhook(Request $request)
    {
        $secret = env('DIGIFLAZZ_WEBHOOK_SECRET');

        $post_data = file_get_contents('php://input');
        $signature = hash_hmac('sha1', $post_data, $secret);
        file_put_contents(storage_path('logs/digiflazz.json'), $post_data, FILE_APPEND);
        
        WebhookLog::create([
            'data' => json_decode($post_data, true)['data'],
        ]);

        if ($request->header('X-Hub-Signature') == 'sha1='.$signature) {
            $response = json_decode($post_data, true)['data'];
            $ref_id = $response['ref_id'];
            $status = $response['status'];
            $message = $response['message'];
            $buyer_sku_code = $response['buyer_sku_code'];
            $customer_no = $response['customer_no'];
            $price = $response['price'];
            $sn = $response['sn'];
            $trx_id = $response['trx_id'];
            $buyer_last_saldo = $response['buyer_last_saldo'];
            
            Topup::updateOrCreate([
                'ref_id' => $ref_id,    
            ], [
                'status' => $status,
                'message' => $message,
                'buyer_sku_code' => $buyer_sku_code,
                'customer_no' => $customer_no,
                'price' => $price,
                'sn' => $sn,
                'buyer_last_saldo' => $buyer_last_saldo,
            ]);
            
            Balance::updateOrCreate(
                ['id' => 1],
                ['balance' => $buyer_last_saldo]
            );
        }
    }
}
