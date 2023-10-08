<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendamentoRequest extends FormRequest
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
            'cpf' => 'required',
            'nome' => 'required',
            'whatsapp' => ['required', 'numeric'],
            'processo' => ['required','array'],
        ];
    }
}
