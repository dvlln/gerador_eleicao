<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class importRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'import' => ['required', 'mimes:csv'],
        ];
    }

    public function messages(){
        return[
            'required' => 'Nada foi inserido',
            'mimes' => 'O arquivo deve ser do tipo csv',
        ];
    }
}
