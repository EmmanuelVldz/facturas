<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelInvoiceRequest;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Services\InvoiceService;
use Throwable;

class InvoiceController extends Controller
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InvoiceRequest $request)
    {
        try {
            $params = $request->validated();
            $invoices = $this->invoiceService->getInvoices($params);

            return response()->json($invoices);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al obtener las facturas'
            ], $th->getCode() ?: 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        try {
            $data = $request->validated();
            $response = $this->invoiceService->createInvoice($data);

            if (isset($response['response']) && $response['response'] == 'error') {
                return response()->json($response, 400);
            }
            return response()->json($response);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al crear la factura'
            ], $th->getCode() ?: 500);
        }
    }

    public function sendEmail(string $uid)
    {
        try {
            $response = $this->invoiceService->sendEmail($uid);

            if (isset($response['response']) && $response['response'] == 'error') {
                return response()->json($response, 404);
            }
            return response()->json($response);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al enviar la factura'
            ], $th->getCode() ?: 500);
        }
    }

    public function cancel(CancelInvoiceRequest $request, string $uid)
    {
        try {
            $data = $request->validated();
            $response = $this->invoiceService->cancelInvoice($uid, $data);

            if (isset($response['response']) && $response['response'] == 'error') {
                return response()->json($response, 400);
            }
            return response()->json($response);
        } catch (Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrio un error al cancelar la factura'
            ], $th->getCode() ?: 500);
        }
    }
}
