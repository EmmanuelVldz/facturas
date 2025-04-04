<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    private $apiUrl;
    private $headers;

    public function __construct()
    {
        $this->apiUrl = env('FACTURA_API_URL');
        $this->headers = [
            'Content-Type' => 'application/json',
            'F-PLUGIN' => env('FACTURA_PLUGIN'),
            'F-Api-Key' => env('FACTURA_API_KEY'),
            'F-Secret-Key' => env('FACTURA_SECRET_KEY'),
        ];
    }

    public function getInvoices($params)
    {
        $params = array_merge([
            'page' => 1,
            'per_page' => 15,
        ], $params);


        $response = Http::withHeaders($this->headers)->get(
            "{$this->apiUrl}/v4/cfdi/list",
            $params
        );

        if ($response->failed()) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener las facturas',
                'code' => $response->status(),
            ];
        }

        $data = $response->json();

        if (isset($data['data'])) {
            $data['data'] = collect($data['data'])->map(function ($item) {
                $item['Options'] = [
                    'send_email' => route('invoice.sendEmail', ['uid' => $item['UUID']]),
                    'cancel' => route('invoice.cancel', ['uid' => $item['UUID']]),
                ];

                return $item;
            });
        }

        return $data;
    }


    public function createInvoice($data)
    {
        $response = Http::withHeaders($this->headers)->post(
            "{$this->apiUrl}/v4/cfdi40/create",
            $data
        );

        if ($response->failed()) {
            return [
                'status' => 'error',
                'code' => $response->status(),
            ];
        }

        return $response->json();
    }

    public function sendEmail($uid)
    {
        $response = Http::withHeaders($this->headers)->get(
            "{$this->apiUrl}/v4/cfdi40/{$uid}/email"
        );

        if ($response->failed()) {
            return [
                'status' => 'error',
                'code' => $response->status(),
            ];
        }

        return $response->json();
    }

    public function cancelInvoice($uid, $data)
    {
        $response = Http::withHeaders($this->headers)->post(
            "{$this->apiUrl}/v4/cfdi40/{$uid}/cancel",
            $data
        );

        if ($response->failed()) {
            return [
                'status' => 'error',
                'code' => $response->status(),
            ];
        }

        return $response->json();
    }
}
