<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};
use App\Services\EleicaoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'inscricaoStartDateHasPassed' => EleicaoService::inscricaoStartDateHasPassed($eleicao),
            'inscricaoEndDateHasPassed' => EleicaoService::inscricaoEndDateHasPassed($eleicao),
            'allParticipantUsers' => User::query()
                ->where('role', 'user')
                ->whereDoesntHave('eleicoes', function($query) use($eleicao){
                    $query->where('id', $eleicao->id);
                })
                ->get()
        ]);
    }

    public function store(Eleicao $eleicao, Request $request){
        $data = $request->all();
        $data['user_id'] = Auth::id();


        // return response()->json(User::find($data['user_id'])->cpf);

        $nameFile = Str::of(User::find($data['user_id'])->cpf). '.'. $request->doc_user->getClientOriginalExtension();
        $documento = $request->doc_user->storeAs('doc/eleicao_user/'.$eleicao->id, $nameFile, 'public');
        $data['doc_user'] = $documento;

        $eleicao->users()->attach([
            $data['user_id'] => [
                'categoria' => $data['categoria'],
                'doc_user' => $data['doc_user']
            ]
        ]);

        return back()->with('success', 'Usuário inscreveu-se para a eleição');
    }

    public function destroy(Eleicao $eleicoes){

        if(EleicaoService::eleicaoEndDateHasPassed($eleicoes)){
            return back()->with('warning', 'Erro: A eleição já ocorreu');
        }

        if(!EleicaoService::userSubscribedOnEleicao($user, $eleicoes)){
            return back()->with('warning', 'Erro: O participante não está inscrito');
        }

        $eleicoes->users()->detach([$eleicoes->id]);

        return back()->with('success', $user->name.' saiu da eleição');
    }

    public function vote(Eleicao $eleicao, Request $request){
        $voto = $request->all();
        $userId = Auth::id();

        try{
            $dataEleitor = $eleicao->users()->find($userId)->pivot->toArray();
            $dataCandidato = $eleicao->users()->find($voto['user_id'])->pivot->toArray();
            $dataEleitor['votacao_status'] = 1;
            $dataCandidato['voto'] += 1;

            $eleicao->users()->updateExistingPivot($userId, $dataEleitor);
            $eleicao->users()->updateExistingPivot($voto['user_id'], $dataCandidato);

            return back()->with('success', 'Voto efetuado');
        } catch (\Throwable $th) {
            return back()->with('warning', 'Burro!!!');
        }
    }

}
