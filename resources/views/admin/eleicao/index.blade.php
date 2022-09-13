@extends('layouts.panel')
@section('title', 'Eleições')
@section('sidebar')
    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
        <i class="fa fa-solid fa-house-user"></i>
        <span>Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('admin.eleicao.index') }}">
        <i class="fas fa-person-booth"></i>
        <span>Eleições</span>
    </a>
@endsection
@section('content')
<form>
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-fill">
                <input type="text" name="search" class="form-control w-50 mr-2" value="" placeholder="Pesquisar...">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>
            <a href="{{ route('admin.eleicao.create') }}" class="btn btn-primary">Nova eleição</a>
        </div>
    </form>
    <table class="table mt-4">
        <thead class="thead bg-white">
            <tr>
                <!-- COLUNAS MERAMENTE ILUSTRATIVAS -->
                <th>Nome</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- CONTEÚDO DA TABELA -->
            @foreach($eleicoes as $eleicao)
                <tr>
                    <td class="align-middle">{{ $eleicao->name }}</td>
                    <td class="align-middle">{{ $eleicao->startDate_formatted }}</td>
                    <td class="align-middle">{{ $eleicao->endDate_formatted }}</td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.eleicao.show', $eleicao->id) }}">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-primary mr-2" href="{{ route('admin.eleicao.edit', $eleicao->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.eleicao.destroy', $eleicao->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger confirm-submit" type="submit">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
