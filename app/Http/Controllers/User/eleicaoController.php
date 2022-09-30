<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};
use App\Services\EleicaoService;

class eleicaoController extends Controller
{
    public function index(Request $request){
        $eleicoes = Eleicao::query();

        if (isset($request->search) && $request->search !== ''){
            $eleicoes->where('name', 'like', '%'.$request->search.'%');
        }

        return view('user.eleicao.index', [
            'eleicoes' => $eleicoes->paginate(3),
            'search' => isset($request->search) ? $request->search : ''
        ]);
    }

    public function show(Eleicao $eleicao)
    {
        return view('user.eleicao.show', [
            'eleicoes' => $eleicao,
            'eleicaoStartDateHasPassed' => EleicaoService::eleicaoStartDateHasPassed($eleicao),
            'eleicaoEndDateHasPassed' => EleicaoService::eleicaoEndDateHasPassed($eleicao),
            'allParticipantUsers' => User::query()
                ->where('role', 'user')
                ->whereDoesntHave('eleicoes', function($query) use($eleicao){
                    $query->where('id', $eleicao->id);
                })
                ->get()
        ]);
    }

    public function store(Eleicao $eleicoes, Request $request){
        $user = User::findOrFail($request->user_id);

        if(EleicaoService::userSubscribedOnEleicao($user, $eleicoes)){
            return back()->with('warning', 'Erro: Este participante já está inscrito nesta eleição!');
        }

        if(EleicaoService::eleicaoEndDateHasPassed($eleicoes)){
            return back()->with('warning', 'Erro: a eleição já ocorreu');
        }

        $eleicoes->users()->attach($user->id);

        return back()->with('success', $user->name.' inscreveu-se para a eleição');
    }

    public function destroy(Eleicao $eleicoes, User $user){
        if(EleicaoService::eleicaoEndDateHasPassed($eleicoes)){
            return back()->with('warning', 'Erro: A eleição já ocorreu');
        }

        if(!EleicaoService::userSubscribedOnEleicao($user, $eleicoes)){
            return back()->with('warning', 'Erro: O participante não está inscrito');
        }

        $eleicoes->users()->detach($user->id);

        return back()->with('success', $user->name.' saiu da eleição');
    }

    
}
