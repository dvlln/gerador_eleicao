<?php

namespace App\Http\Requests\Perfil;

use Illuminate\Foundation\Http\FormRequest;

class perfilRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => '',
            'email' => '',
            'foto' => '',
            'password' => '',
            'password_confirmation' => ''
        ];
    }

    public function attributes(){
        return[
            'name' => 'nome',
            'email' => 'e-mail',
            'foto' => 'foto',
            'password' => 'senha'
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute deve ser preenchido',
            'min' => ':attribute deve ser maior'
        ];
    }
}
