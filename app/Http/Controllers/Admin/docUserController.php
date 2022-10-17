<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};

class docUserController extends Controller
{
    public function update_aprove(Eleicao $eleicoes, User $users){
        $eleicoes->users()->

        $users['doc_user_status'] = 'aprovado';
        return response()->json($users);

        // $eleicao->update($data);
    }
}
