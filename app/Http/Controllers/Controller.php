<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($data = [], $message, $pagination = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'error' => [
                'error_code' => '',
                'error_data' => [],
            ],
        ];

            $response['pagination'] = $pagination;
        // if (count($pagination) > 0) {
        // }

        return response()->json($response, 200);
    }

    public function sendError($message, $error_data = new \stdClass, $error_code = 'PROCESS_ERROR', $status_code = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'data' => [],
            'error' => [
                'error_code' => $error_code,
                'error_data' => $error_data,
            ],
        ];


        return response()->json($response, $status_code);
    }

    public function autoPagination($data)
    {
        $pagination = [
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'first_page_url' => $data->url(1),
            'last_page_url' => $data->url($data->lastPage()),
            'next_page_url' => $data->nextPageUrl(),
            'prev_page_url' => $data->previousPageUrl(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem()
        ];

        return $pagination;
    }
}
