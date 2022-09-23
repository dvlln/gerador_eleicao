<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};
use App\Http\Requests\Admin\eleicaoRequest;

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
        Eleicao::create($request->validated());

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição cadastrada com sucesso');
    }

    public function show(Eleicao $eleicao)
    {
        return view('admin.eleicao.show', [
            'eleicoes' => $eleicao,
        ]);
    }

    public function edit(Eleicao $eleicao)
    {
        return view('admin.eleicao.edit', ['eleicoes' => $eleicao]);
    }

    public function update(Eleicao $eleicao, eleicaoRequest $request)
    {
        $eleicao->update($request->validated());

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição atualizada com sucesso');
    }

    public function destroy(Eleicao $eleicao)
    {
        $eleicao->delete();

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição removida com sucesso');
    }
}
