<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};
use App\Services\EleicaoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class eleicaoController extends Controller
{
    public function index(Request $request){
        $eleicoes = Eleicao::query();

        if (isset($request->search) && $request->search !== ''){
            $eleicoes->where('name', 'like', '%'.$request->search.'%');
        }

        return view('user.eleicao.index', [
            'eleicoes' => $eleicoes->paginate(5),
            'search' => isset($request->search) ? $request->search : ''
        ]);
    }

    public function show(Eleicao $eleicao)
    {
        $vencedor = DB::table('eleicao_user')
                      ->where('eleicao_id', '=', $eleicao->id)
                      ->where('voto', '=', DB::table('eleicao_user')->where('eleicao_id', '=', $eleicao->id)->max('voto'))
                      ->value('user_id');

        return view('user.eleicao.show', [
            'eleicoes' => $eleicao,
            'vencedor' => $vencedor,
            'userSubscribedOnEleicao' => EleicaoService::userSubscribedOnEleicao(Auth::id(), $eleicao),
            'beforeInscricao' => EleicaoService::beforeInscricao($eleicao),
            'duringInscricao' => EleicaoService::duringInscricao($eleicao),
            'afterInscricao' => EleicaoService::afterInscricao($eleicao),
            'beforeEleicao' => EleicaoService::beforeEleicao($eleicao),
            'duringEleicao' => EleicaoService::duringEleicao($eleicao),
            'afterEleicao' => EleicaoService::afterEleicao($eleicao),
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

        $nameFile = Str::of(User::find($data['user_id'])->cpf). '.'. $request->doc_user->getClientOriginalExtension();
        $documento = $request->doc_user->storeAs('doc/eleicao_user/'.$eleicao->id, $nameFile, 'public');
        $data['doc_user'] = $documento;

        $eleicao->users()->attach([
            $data['user_id'] => [
                'categoria' => $data['categoria'],
                'doc_user' => $data['doc_user']
            ]
        ]);

        return back()->with('success', 'Você se inscreveu na eleição');
    }

    public function destroy(Eleicao $eleicao){

        if(EleicaoService::duringEleicao($eleicao)){
            return back()->with('warning', 'Erro: A eleição já ocorreu');
        }

        $eleicao->users()->detach(Auth::id());

        return back()->with('success', 'Você saiu da eleição');
    }

    public function vote(Eleicao $eleicao, Request $request){
        $data = $request->all();

        if($data['candidatoId'] === $data['eleitorId']){
            try{
                $user = $eleicao->users()->find($data['eleitorId'])->pivot->toArray();
                $user['votacao_status'] = 1;
                $user['voto'] += 1;

                $eleicao->users()->updateExistingPivot($data['eleitorId'], $user);

                return back()->with('success', 'Voto efetuado');
            } catch (\Throwable $th) {
                return back()->with('warning', 'Erro na votação');
            }
        }else{
            try{
                $user['eleitor'] = $eleicao->users()->find($data['eleitorId'])->pivot->toArray();
                $user['candidato'] = $eleicao->users()->find($data['candidatoId'])->pivot->toArray();

                $user['eleitor']['votacao_status'] = 1;
                $user['candidato']['voto'] += 1;

                $eleicao->users()->updateExistingPivot($data['eleitorId'], $user['eleitor']);
                $eleicao->users()->updateExistingPivot($data['candidatoId'], $user['candidato']);

                return back()->with('success', 'Voto efetuado');
            } catch (\Throwable $th) {
                return back()->with('warning', 'Erro na votação');
            }
        }
    }

}
