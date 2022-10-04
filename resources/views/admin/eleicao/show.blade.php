@extends('layouts.panel')
@section('title', $eleicoes->name)
@section('sidebar')
    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
        <i class="fa-solid fa-house-user"></i>
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
                <div class="card-body text-center ">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Início: </span>
                            {{ $eleicoes->startDate_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim: </span>
                            {{ $eleicoes->endDate_formatted }}
                        </li>
                        <li class="list-group-item bg-primary">
                            <span class="font-weight-bold text-white mb-1 text-align-center">Candidatos</span>
                        </li>

                        {{-- CANDIDATOS --}}
                        <table class="table m-0">
                            <thead>
                                <th>Nome</th>

                                {{-- APARECERÁ A QUANTIDADE DE VOTOS NO FIM DA ELEIÇÃO --}}
                                @if ( $eleicaoEndDateHasPassed )
                                    <th>Quantid. Votos</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($eleicoes->users as $user) {{-- LISTAGEM DE USUARIOS NA ELEICAO --}}
                                    @if ($user->pivot->categoria === 'candidato') {{--LISTAGEM DE APENAS CANDIDATOS --}}

                                        {{-- MARCAÇÃO DO CANDIDATO VITORIOSO NO FIM DA ELEIÇÃO --}}
                                        @if ($vencedor === $user->id and $eleicaoEndDateHasPassed)
                                            <tr class="p-3 mb-2 bg-success text-white">
                                        @else
                                            <tr>
                                        @endif

                                        <td>{{ $user->name }}</td>

                                        {{-- APARECERÁ A QUANTIDADE DE VOTOS NO FIM DA ELEIÇÃO --}}
                                        @if ( $eleicaoEndDateHasPassed )
                                            <td>{{ $user->pivot->voto }}</td>
                                        @endif
                                    </tr>

                                    @endif
                                @endforeach

                                {{-- APARECERÁ O TOTAL DE VOTOS NO FIM DA ELEIÇÃO --}}
                                @if ( $eleicaoEndDateHasPassed )
                                    <tr class="bg-warning text-dark">
                                        <td class="font-weight-bold ">Total de votos</td>
                                        <td>{{ $total }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ELEITORES --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Eleitores</div>
                <div class="card-body text-center mt-0">
                        <table class="table">
                            <thead>
                                <th>Nome</th>
                                <th>E-mail</th>
                                
                                {{-- APARECERÁ O STATUS DA VOTAÇÃO QUANDO A ELEIÇÃO COMEÇAR --}}
                                @if ( $eleicaoStartDateHasPassed )
                                    <th>Status Votação</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($eleicoes->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        {{-- APARECERÁ O STATUS DA VOTAÇÃO QUANDO A ELEIÇÃO COMEÇAR --}}
                                        @if ( $eleicaoStartDateHasPassed )
                                            @if ($user->pivot->votacao_status === 1)
                                                <td class="bg-green"><i class="fa-solid fa-check fa-xl"></i></td>
                                            @else
                                                <td><i class="fa-solid fa-xmark fa-2xl"></i></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
