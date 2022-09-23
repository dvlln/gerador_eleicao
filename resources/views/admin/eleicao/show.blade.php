@extends('layouts.panel')
@section('title', $eleicoes->name)
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
    {{-- INFORMAÇÕES GERAIS --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Informações gerais</div>
                <div class="card-body">
                    <ul class="list-group text-center">
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Início: </span>
                            {{ $eleicoes->startDate_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim: </span>
                            {{ $eleicoes->endDate_formatted }}
                        </li>
                        <li class="list-group-item bg-secondary">
                            <span class="font-weight-bold text-white mb-1 text-align-center">Candidatos</span>
                        </li>
                        <li class="list-group-item">
                            @foreach($eleicoes->users as $user)
                                    @if ($user->pivot->categoria === 'candidato')
                                        <span class="mb-1 d-flex d-12 text-align-center">{{ $user->name }}</span>
                                    @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ELEITORES --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Eleitores</div>
        <div class="card-body">
            <table class="table bg-white mt-3">
                <thead>
                    <th>Nome</th>
                </thead>
                <tbody>
                    @foreach($eleicoes->users as $user)
                        @if ($user->pivot->categoria === 'eleitor')
                        <tr>
                            <td>{{ $user->name }}</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
