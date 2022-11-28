<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class subscribeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categoria' => 'required',
            'ocupacao' => 'required',
            'doc_user' => 'required|mimes:pdf'
        ];
    }

    public function attributes(){
        return[
            'doc_user' => 'documento'
        ];
    }

    public function messages(){
        return[
            'required' => 'Campo obrigatorio',
        ];
    }
}
