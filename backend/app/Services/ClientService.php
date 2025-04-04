<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientService
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

    public function getClients()
    {

        $response = Http::withHeaders($this->headers)->get(
            "{$this->apiUrl}/v1/clients"
        );

        if ($response->failed()) {
            return [
                'status' => 'error',
                'code' => $response->status(),
            ];
        }

        return $response->json();
    }

    public function createClient($data)
    {
        $response = Http::withHeaders($this->headers)->post(
            "{$this->apiUrl}/v1/clients/create",
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

    public function getClient($uid)
    {
        $response = Http::withHeaders($this->headers)->get(
            "{$this->apiUrl}/v1/clients/{$uid}"
        );

        if ($response->failed()) {
            return [
                'status' => 'error',
                'code' => $response->status(),
            ];
        }

        return $response->json();
    }

    public function updateClient($uid, $data)
    {
        $response = Http::withHeaders($this->headers)->post(
            "{$this->apiUrl}/v1/clients/{$uid}/update",
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

    public function deleteClient($uid)
    {
        $response = Http::withHeaders($this->headers)->post(
            "{$this->apiUrl}/v1/clients/destroy/{$uid}"
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
