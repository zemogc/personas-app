<?php

namespace App\Http\Requests;

class MunicipioRequest extends GeografiaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'muni_nomb' => ['required', 'string', 'max:50'],
            'depa_codi' => ['required', 'exists:tb_departamento,depa_codi'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'muni_nomb' => 'nombre',
            'depa_codi' => 'departamento',
        ];
    }
}
