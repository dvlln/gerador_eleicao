<?php

namespace App\Http\Requests\Perfil;

use Illuminate\Foundation\Http\FormRequest;

class perfilSecretariaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => '',
            'logo' => ''
        ];
    }

    public function attributes(){
        return[
            'name' => 'nome'
        ];
    }
}
