<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Perfil\{perfilSecretariaRequest, perfilUserRequest};
use App\Models\{Secretaria, User};

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class perfilController extends Controller
{
    public function updateUser(User $users, perfilUserRequest $request){
        $data = $request->validated();

        // Criando a validação na mão
        $validator = Validator::make(request()->all(), [
            'foto' => 'mimes:jpg,jpeg,png',
            'password' => 'confirmed'
        ]);

        // Validação de senha
        if($validator->fails()){
            return back()->with('modalOpen', '1')->withErrors($validator);
        }

        // Salvando foto caso exista
        if(array_key_exists('foto', $data)){
            $file = Str::of($users->cpf).'.'. $data['foto']->getClientOriginalExtension();
            $imagem = $data['foto']->storeAs('perfil', $file, 'public');
            $data['foto'] = $file;
        }

        // Removendo senha do array caso esteja vazia
        if($data['password'] === null){
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $users->find($users->id)->update($data);
        return back()->with('success', 'Perfil do usuário editado!!!');
    }

    public function updateSecretaria(perfilSecretariaRequest $request){
        $data = $request->validated();

        // Validando foto
        $validator = Validator::make(request()->all(), [
            'logo' => 'mimes:jpg,jpeg,png'
        ]);

        if($validator->fails()){
            return back()->with('modalOpen', '2')->withErrors($validator);
        }

        // Salvando foto caso exista
        if(isset($data['logo'])){
            $file = Str::of('pmc').'.'. $data['logo']->getClientOriginalExtension();
            $imagem = $data['logo']->storeAs('logo', $file, 'public');
            $data['logo'] = $file;
        }

        Secretaria::find(1)->update($data);
        return back()->with('success', 'Perfil da secretaria editado!!!');
    }
}
