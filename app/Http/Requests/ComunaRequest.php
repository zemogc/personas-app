<?php

namespace App\Http\Requests;

class ComunaRequest extends GeografiaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'comu_nomb' => ['required', 'string', 'max:50'],
            'muni_codi' => ['required', 'exists:tb_municipio,muni_codi'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'comu_nomb' => 'nombre',
            'muni_codi' => 'municipio',
        ];
    }
}
