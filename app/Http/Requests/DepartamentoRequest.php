<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;

class DepartamentoRequest extends GeografiaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'depa_nomb' => ['required', 'string', 'max:50'],
            'pais_codi' => ['required', 'exists:tb_pais,pais_codi'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'depa_nomb' => 'nombre',
            'pais_codi' => 'país',
        ];
    }
}
