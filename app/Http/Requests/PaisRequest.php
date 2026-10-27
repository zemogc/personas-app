<?php

namespace App\Http\Requests;

class PaisRequest extends GeografiaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'pais_nomb' => ['required', 'string', 'max:50'],
            'pais_capi' => ['nullable', 'integer', 'exists:tb_municipio,muni_codi'],
        ];

        // El código es la llave primaria: solo se define al crear.
        if ($this->isMethod('post')) {
            $rules['pais_codi'] = ['required', 'alpha', 'size:3', 'unique:tb_pais,pais_codi'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'pais_codi' => 'código',
            'pais_nomb' => 'nombre',
            'pais_capi' => 'municipio capital',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('pais_codi')) {
            $this->merge(['pais_codi' => strtoupper(trim($this->input('pais_codi')))]);
        }
    }
}
