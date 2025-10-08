<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $base_url;
    protected array $header;

    protected function buildRequest($method, $url, $data = null, $type = 'json')
    {
        try {
            $response = Http::withHeaders($this->header)->send($method, $this->base_url . $url, [
                $type => $data
            ]);
            return response()->json([
                'success' => $response->successeful(),
                'status' => $response->status(),
                'data' => $response->json()
            ], $response->status());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
