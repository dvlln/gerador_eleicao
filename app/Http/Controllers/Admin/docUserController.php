<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};

class docUserController extends Controller
{
    public function update_approve(Eleicao $eleicao, User $user){
        try {
            $data = $eleicao->users()->find($user->id)->pivot->toArray();
            $data['doc_user_status'] = 'aprovado';

            $eleicao->users()->updateExistingPivot($user->id, $data);

            return back()->with('success', 'Aprovado com sucesso');
        } catch (\Throwable $th) {
            return back()->with('warning', 'Aprovação falhou');
        }
    }
}
