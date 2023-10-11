<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtendimentoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required','date'],
            'opening_hours' => 'required',
            'cpf' => 'nullable',
            'nome' => 'required',
            'whastapp' => 'required',
            'procedimento_key' => ['required','array'],
            'comment' => 'nullable'
        ];
    }
}
