<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Perfil\perfilRequest;
use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class perfilController extends Controller
{
    public function update(User $users, perfilRequest $request){
        $data = $request->validated();

        if($data['foto'] != null){
            $validator = Validator::make(request()->all(), ['foto' => 'mimes:jpg,jpeg,png']);
        }else{
            $validator = Validator::make(request()->all(), []);
        }

        // Validação de senha
        if($data['password'] != $data['password_confirmation']){
            $validator->errors()->add('password', 'As senhas não conferem');
            return view('admin.dashboard.index', [
                'flag' => 1,
                'users' => $users
            ])->withErrors($validator);
        }

        // Validação de foto
        if($data['foto'] != null){
            if($validator->fails()){
                return view('admin.dashboard.index', [
                    'flag' => 1,
                    'users' => $users
                ])->withErrors($validator);
            }
        }

        // Retirando atributos nulos do array
        if($data['foto'] === null){
            unset($data['foto']);
        }
        else if($data['password'] === null){
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        // try{
            if($data['foto'] != null){
                $file = Str::of($users->cpf).'.'. $data['foto']->getClientOriginalExtension();
                $imagem = $data['foto']->storeAs('perfil', $file, 'public');
                $data['foto'] = $file;
            }
            // return response()->json($data);
            $users->find($users->id)->update($data);
            return back()->with('success', 'Perfil do usuário editado!!!');
        // } catch (\Throwable $th) {
        //     return back()->with('warning', 'Erro na edição do perfil!!!');
        // }
    }
}
