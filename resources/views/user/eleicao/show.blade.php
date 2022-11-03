
@extends('layouts.panelUser')
@section('title', $eleicoes->name)
@section('content')

    {{-- INFORMAÇÕES GERAIS --}}
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-primary text-white">Informações gerais</div>
                <div class="card-body text-center">
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
                    </ul>
                    <div class="row">
                            {{-- CANDIDATOS --}}
                            @foreach($eleicoes->users as $user) {{-- LISTAGEM DE USUARIOS NA ELEICAO --}}
                                @if ($user->pivot->categoria === 'candidato') {{--LISTAGEM DE APENAS CANDIDATOS --}}
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1" align="center">
                                    <div class="card mt-2" style="width: 15rem;">
                                        <div class="card-body">
                                            <img style="width: 12rem; margin-bottom: 4px;" src="{{ url("storage/user_foto/{$user->foto}") }}" alt="foto_perfil" >
                                            <h5 class="card-title">{{ $user->name }}</h5>
                                            <button type="button">Votar</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                    </div>

                        {{-- CANDIDATOS --}}


                </div>
            </div>
        </div>
    </div>

    @if( !$eleicaoStartDateHasPassed )
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">Inscrição</div>
                    <div class="card-body text-center mt-0">
                            <table class="table">
                                <thead>

                                    <!--<th></th>
                                    <th></th>-->

                                    {{-- APARECERÁ O STATUS DA VOTAÇÃO QUANDO A ELEIÇÃO COMEÇAR --}}
                                    @if ( $eleicaoStartDateHasPassed )
                                        <th>Eleição em andamento</th>
                                    @endif

                                    @if ( !$eleicaoStartDateHasPassed )
                                        <!--<th></th>-->
                                    @endif
                                </thead>
                                <tbody>
                                <form enctype="multipart/form-data" method="POST" action="{{ route('user.eleicao.store', $eleicoes->id) }}">
                                    @csrf
                                    @if ( $inscricaoStartDateHasPassed && !$inscricaoEndDateHasPassed )
                                    <tr>
                                        <td>
                                        <select class="form-control" name="categoria" id="categoria">
                                                <option value="">Selecione</option>
                                                <option value="candidato">Candidato</option>
                                                <option value="eleitor">Eleitor</option>
                                            </select>
                                        </td>

                                            <td>
                                                <div>
                                                    <input type="hidden" id="user_id" name="user_id">
                                                </div>
                                                <div class="col col-lg-2">
                                                    <input class="btn btn-sm" type="file" id='doc_user' name='doc_user'/>
                                                </div>
                                            </td>
                                                <td>
                                                <div class="col col-lg-2">
                                                <button type="submit" class="btn btn-success">Inscrever</button>
                                                </div>
                                                </td>
                                            @endif
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <li class="list-group-item">
        <form method="POST" action='{{ route("user.eleicao.destroy", ["eleicao"  => $eleicoes->id, "user"  => Auth::id()]) }}'>
            @csrf
            @method('DELETE')
            <div class="col col-lg-2">
            <button class="btn btn-danger">Remover inscrição</button>
            </div>
        </form>
    </li>

@endsection
