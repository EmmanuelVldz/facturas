<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'rfc' => ['required', 'string', 'min:12'],
            'razons' => ['required', 'string'],
            'codpos' => ['required', 'string'],
            'email' => ['required', 'email'],
            'regimen' => ['required', 'string'],
            'pais' => ['required', 'string'],
            'calle' => ['nullable', 'string'],
            'numero_exterior' => ['nullable', 'string'],
            'numero_interior' => ['nullable', 'string'],
            'colonia' => ['nullable', 'string'],
            'ciudad' => ['nullable', 'string'],
            'delegacion' => ['nullable', 'string'],
            'localidad' => ['nullable', 'string'],
            'nombre' => ['nullable', 'string'],
            'apellidos' => ['nullable', 'string'],
            'telefono' => ['nullable', 'string'],
            'numregidtrib' => ['nullable', 'string'],
            'email2' => ['nullable', 'email'],
            'email3' => ['nullable', 'email'],
            'usocfdi' => ['nullable', 'string'],
        ];
    }
}
