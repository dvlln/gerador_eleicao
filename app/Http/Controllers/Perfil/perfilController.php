<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class perfilController extends Controller
{
    public function update(User $users, Request $request){
        $data = $request->all();

        try{
            $file = Str::of($users->cpf).'.'. $data['foto']->getClientOriginalExtension();
            $imagem = $data['foto']->storeAs('perfil', $file, 'public');
            $data['foto'] = $file;

            $users->find($users->id)->update($data);

            return back()->with('success', 'Perfil do usuário editado!!!');
        } catch (\Throwable $th) {
            return back()->with('warning', 'Erro na edição do perfil!!!');
        }
    }
}
