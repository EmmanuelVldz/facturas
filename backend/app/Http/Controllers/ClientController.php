<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\ClientService;
use Throwable;

class ClientController extends Controller
{
    private $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clients = $this->clientService->getClients();
            return response()->json($clients);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al obtener los clientes.',
            ], $th->getCode() ?: 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        try {
            $data = $request->validated();
            $response = $this->clientService->createClient($data);
            if ($response['status'] === 'error') {
                return response()->json($response, 400);
            }

            return response()->json($response, 201);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al intentar crear el cliente.',
            ], $th->getCode() ?: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uid)
    {
        try {

            $response = $this->clientService->getClient($uid);

            if ($response['status'] === 'error') {
                return response()->json($response, 404);
            }

            return response()->json($response);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al obtener el cliente.',
            ], $th->getCode() ?: 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, string $uid)
    {
        try {
            $data = $request->validated();
            $response = $this->clientService->updateClient($uid, $data);

            if ($response['status'] === 'error') {
                return response()->json($response, 404);
            }

            return response()->json($response);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al intentar actualizar el cliente.',
            ], $th->getCode() ?: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uid)
    {
        try {
            $response = $this->clientService->deleteClient($uid);

            if ($response['response'] === 'error') {
                return response()->json($response, 404);
            }

            return response()->json($response);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al intentar eliminar el cliente.',
            ], $th->getCode() ?: 500);
        }
    }
}
