<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Receptor' => ['required', 'array'],
            'Receptor.UID' => ['required', 'string'],
            'Receptor.ResidenciaFiscal' => ['nullable', 'string'],
            'TipoDocumento' => ['required', 'string'],
            'Conceptos' => ['required', 'array'],
            'Conceptos.*.ClaveProdServ' => ['required', 'string'],
            'Conceptos.*.NoIdentificacion' => ['nullable', 'string'],
            'Conceptos.*.Cantidad' => ['required', 'numeric'],
            'Conceptos.*.ClaveUnidad' => ['required', 'string'],
            'Conceptos.*.Unidad' => ['required', 'string'],
            'Conceptos.*.ValorUnitario' => ['required', 'string'],
            'Conceptos.*.Descripcion' => ['required', 'string'],
            'Conceptos.*.Descuento' => ['nullable', 'string'],
            'Conceptos.*.ObjetoImp' => ['required', 'string'],
            'UsoCFDI' => ['required', 'string'],
            'Serie' => ['required', 'numeric'],
            'FormaPago' => ['required', 'string'],
            'MetodoPago' => ['required', 'string'],
            'Moneda' => ['required', 'string'],
            'EnviarCorreo' => ['nullable', 'boolean']
        ];
    }
}
