<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};
use App\Http\Requests\Admin\eleicaoRequest;
use Illuminate\Support\Facades\DB;
use App\Services\EleicaoService;

class eleicaoController extends Controller
{

    public function index(Request $request)
    {
        $eleicoes = Eleicao::query();

        if (isset($request->search) && $request->search !== ''){
            $eleicoes->where('name', 'like', '%'.$request->search.'%');
        }

        return view('admin.eleicao.index', [
            'eleicoes' => $eleicoes->paginate(3),
            'search' => isset($request->search) ? $request->search : ''
        ]);
    }

    public function create()
    {
        return view('admin.eleicao.create');
    }

    public function store(eleicaoRequest $request)
    {
        $data = $request->validated();


        $data['start_date_eleicao'] .= ' '.$data['start_time_eleicao']; //JUNTANDO DATA E HORA INICIAL DA ELEICAO
        $data['end_date_eleicao'] .= ' '.$data['end_time_eleicao']; //JUNTANDO DATA E HORA FINAL DA ELEICAO

        $data['start_date_inscricao'] .= ' '.$data['start_time_inscricao']; //JUNTANDO DATA E HORA INICIAL
        $data['end_date_inscricao'] .= ' '.$data['end_time_inscricao']; //JUNTANDO DATA E HORA FINAL

        unset($data['start_time_eleicao']); // REMOVE HORA INICIAL
        unset($data['end_time_eleicao']); // REMOVE HORA FINAL

        unset($data['start_time_inscricao']); // REMOVE HORA INICIAL
        unset($data['end_time_inscricao']); // REMOVE HORA FINAL

        Eleicao::create($data);

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição cadastrada com sucesso');
    }

    public function show(Eleicao $eleicao)
    {

        $vencedor = DB::table('eleicao_user')
                      ->where('eleicao_id', '=', $eleicao->id)
                      ->where('voto', '=', DB::table('eleicao_user')->where('eleicao_id', '=', $eleicao->id)->max('voto'))
                      ->value('user_id');


        $total = DB::table('eleicao_user')
                   ->where('eleicao_id', '=', $eleicao->id)
                   ->where('categoria', '=', 'candidato')
                   ->sum('voto');

        return view('admin.eleicao.show', [
            'eleicoes' => $eleicao,
            'eleicaoStartDateHasPassed' => EleicaoService::eleicaoStartDateHasPassed($eleicao),
            'eleicaoEndDateHasPassed' => EleicaoService::eleicaoEndDateHasPassed($eleicao),
            'inscricaoStartDateHasPassed' => EleicaoService::inscricaoStartDateHasPassed($eleicao),
            'inscricaoEndDateHasPassed' => EleicaoService::inscricaoEndDateHasPassed($eleicao),
            'total' => $total,
            'vencedor' => $vencedor
        ]);
    }

    public function edit(Eleicao $eleicao)
    {
        $start_time_eleicao = date('H:i', strtotime($eleicao->start_date_eleicao));
        $end_time_eleicao = date('H:i', strtotime($eleicao->end_date_eleicao));
        $start_time_inscricao = date('H:i', strtotime($eleicao->start_date_inscricao));
        $end_time_inscricao = date('H:i', strtotime($eleicao->end_date_inscricao));

        return view('admin.eleicao.edit', [
            'eleicoes' => $eleicao,
            'start_time_eleicao' => $start_time_eleicao,
            'end_time_eleicao' => $end_time_eleicao,
            'start_time_inscricao' => $start_time_inscricao,
            'end_time_inscricao' => $end_time_inscricao
        ]);
    }

    public function update(Eleicao $eleicao, eleicaoRequest $request)
    {
        $data = $request->validated();

        $data['start_date_eleicao'] .= ' '.$data['start_time_eleicao']; //JUNTANDO DATA E HORA INICIAL DA ELEICAO
        $data['end_date_eleicao'] .= ' '.$data['end_time_eleicao']; //JUNTANDO DATA E HORA FINAL DA ELEICAO

        $data['start_date_inscricao'] .= ' '.$data['start_time_inscricao']; //JUNTANDO DATA E HORA INICIAL
        $data['end_date_inscricao'] .= ' '.$data['end_time_inscricao']; //JUNTANDO DATA E HORA FINAL

        unset($data['start_time_eleicao']); // REMOVE HORA INICIAL
        unset($data['end_time_eleicao']); // REMOVE HORA FINAL

        unset($data['start_time_inscricao']); // REMOVE HORA INICIAL
        unset($data['end_time_inscricao']); // REMOVE HORA FINAL

        $eleicao->update($data);

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição atualizada com sucesso');
    }

    public function destroy(Eleicao $eleicao)
    {
        $eleicao->delete();

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição removida com sucesso');
    }
}
