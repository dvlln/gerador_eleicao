<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
//use App\Rules\Cpf;

class RegisterRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            // 'cpf' => ['required', new Cpf, 'unique:users,cpf'],
            'password' => ['required', 'min:3', 'confirmed'],
        ];
    }

    public function attributes(){
        return[
            'name' => 'nome',
            'email' => 'e-mail',
            // 'cpf' => 'CPF',
            'password' => 'senha',
        ];
    }
}
