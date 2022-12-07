<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cpf;

class RegisterRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'name' => 'required',
            'email' => ['required', 'bail', 'email', 'unique:users,email'],
             'cpf' => ['required', new Cpf, 'unique:users,cpf'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(){
        return[
            'name' => 'nome',
            'email' => 'e-mail',
            'cpf' => 'CPF',
            'password' => 'senha',
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'email.unique' => 'Este email já foi cadastrado',
            'cpf.unique' => 'Este CPF já foi cadastrado'
        ];
    }

}
