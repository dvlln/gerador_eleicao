<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Eleicao, User};
use App\Http\Requests\Admin\acaoRequest;
use Illuminate\Support\Facades\Validator;

use App\Mail\docMail;
use Illuminate\Support\Facades\Mail;

class docUserController extends Controller
{
    public function approve(Eleicao $eleicao, User $user){
        try {
            $data = $eleicao->users()->find($user->id)->pivot->toArray();
            $data['doc_user_status'] = 'aprovado';

            Mail::to($user->email)->send(new docMail('admin.eleicao.approve', $data['doc_user_status'], null, $eleicao['start_date_eleicao_formatted'], $eleicao['end_date_eleicao_formatted']));

            $eleicao->users()->updateExistingPivot($user->id, $data);

            return back()->with('success', 'Aprovado com sucesso');
        } catch (\Throwable $th) {
            return back()->with('warning', 'Aprovação falhou');
        }
    }

    public function deny(Eleicao $eleicao, User $user, acaoRequest $request){
        $data = $request->validated();

        // Validando dados
        $validator = Validator::make(request()->all(), [
            'doc_user_message' => 'required'
        ]);

        if($validator->fails()){
            return back()->with('modalOpen', '4')->with('userId', $user->id)->withErrors($validator);
        }

        try {
            $data = $eleicao->users()->find($user->id)->pivot->toArray();
            $data['doc_user_status'] = 'reprovado';
            $data['doc_user_message'] = $request->doc_user_message;

            $eleicao->users()->updateExistingPivot($user->id, $data);

            Mail::to($user->email)->send(new docMail('admin.eleicao.deny', $data['doc_user_status'], $data['doc_user_message'], $eleicao['start_date_depuracao_formatted'], $eleicao['end_date_depuracao_formatted']));

            return back()->with('success', 'Reprovado com sucesso');
        } catch (\Throwable $th) {
            return back()->with('warning', 'Reprovação falhou');
        }
    }
}
