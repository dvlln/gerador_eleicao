@extends('layouts.panelAdmin')
@section('title', $eleicoes->name)
@section('content')

    {{-- INFORMAÇÕES GERAIS --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Informações gerais</div>
                <div class="card-body text-center ">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Início inscrição: </span>
                            {{ $eleicoes->start_date_inscricao_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim inscrição: </span>
                            {{ $eleicoes->end_date_inscricao_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Início eleição: </span>
                            {{ $eleicoes->start_date_eleicao_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim eleição: </span>
                            {{ $eleicoes->end_date_eleicao_formatted }}
                        </li>
                        <li class="list-group-item bg-primary">
                            <span class="font-weight-bold text-white mb-1 text-align-center">Candidatos</span>
                        </li>

                        {{-- CANDIDATOS --}}
                        <table class="table m-0">
                            <thead>
                                <th>Perfil</th>
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

                                        <td><img src="{{ url("storage/user_foto/{$user->foto}") }}" alt="foto_perfil" ></td>
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
                                        <td></td>
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
                <div class="card-body text-center mt-0 justify-content-center">
                        <table class="table">
                            <thead>
                                <th>Nome</th>
                                <th>E-mail</th>

                                {{-- APARECERÁ O STATUS DA VOTAÇÃO QUANDO A ELEIÇÃO COMEÇAR --}}
                                @if ( $eleicaoStartDateHasPassed )
                                    <th>Status Votação</th>
                                @endif

                                @if ( !$eleicaoStartDateHasPassed )
                                    <th>Ações</th>
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

                                        @if ( !$eleicaoStartDateHasPassed )
                                            <td>
                                                <div class="d-flex justify-content-center">

                                                    {{-- VISUALIZAR DOC DO USUARIO --}}
                                                    <a class="btn btn-sm btn-info mr-2" href='{{ url("storage/doc/eleicao_user/{$eleicoes->id}/{$user->pivot->doc_user}") }}' target="_blank">
                                                        <i class="fa fa-eye fa-l"></i>
                                                    </a>

                                                    {{-- APROVAR O USUARIO --}}
                                                    <form action="{{ route('admin.eleicao.approve', ['eleicao' => $eleicoes->id, 'user' => $user->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-sm btn-success mr-2">
                                                            <i class="fa-solid fa-check fa-l"></i>
                                                        </button>
                                                    </form>

                                                    {{-- REPROVAR O USUARIO --}}
                                                    <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#reprovar_modal_{{ $user->id }}">
                                                        <i class="fa-solid fa-xmark fa-l"></i>
                                                    </button>


                                                        <div class="modal fade" id="reprovar_modal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="reprovar_modal_title" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modal_title">Informe o motivo da reprovação</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{ route('admin.eleicao.deny', ['eleicao' => $eleicoes->id, 'user' => $user->id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <textarea class="form-control" rows="10" name="doc_user_message"></textarea>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </td>
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
