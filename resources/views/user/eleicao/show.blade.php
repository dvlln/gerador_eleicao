
@extends('layouts.panelUser')
@section('title', $eleicoes->name)
@section('content')

    {{-- INFORMAÇÕES GERAIS --}}
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-primary text-white text-center"><h4 class="m-0">Informações gerais</h4></div>
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
                            <span class="font-weight-bold text-white text-align-center"><h6 class="m-0">Candidatos</h6></span>
                        </li>
                    </ul>
                    <div class="row justify-content-center">
                        {{-- CANDIDATOS --}}
                        @foreach($eleicoes->users as $user) {{-- LISTAGEM DE USUARIOS NA ELEICAO --}}
                            @if ($user->pivot->categoria === 'candidato' && $user->pivot->doc_user_status === 'aprovado') {{--LISTAGEM DE APENAS CANDIDATOS APROVADOS --}}
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1" align="center">
                                {{-- MUDA O STYLE DO VENCEDOR --}}
                                @if ($user->id === $vencedor && $afterEleicao)
                                    <div class="card mt-2 bg-success text-white" style="width: 15rem;">
                                @else
                                    <div class="card mt-2 border-dark" style="width: 15rem;">
                                @endif
                                <div class="card-body">
                                    <img style="width: 12rem; margin-bottom: 4px;" src="{{ url("storage/user_foto/{$user->foto}") }}" alt="foto_perfil" >
                                    <h5 class="card-title">{{ $user->name }}</h5>
                                    @if ($user->id === $vencedor && $afterEleicao)
                                        <p class="text-danger"><b>VENCEDOR!!!</b></p>
                                    @endif
                                    @if ($duringEleicao && $user->pivot->doc_user_status === 'aprovado')
                                        <form method="POST" action="{{ route('user.eleicao.vote', $eleicoes->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="candidatoId" value="{{ $user->id }}">
                                            <input type="hidden" name="eleitorId" value="{{ Auth::id() }}">
                                            <button type="submit" onclick="return confirm('Deseja realizar o voto?')" class="btn btn-success">Votar</button>
                                        </form>
                                    @endif
                                </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if( $duringInscricao || ($duringDepuracao && !$eleicoes->users->pivot->doc_user_status === 'aprovado') )
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center"><h4 class="m-0">Inscrição</h4></div>
                    <div class="card-body text-center mt-0">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody>

                            {{-- INSCREVER-SE --}}
                            @if ( !$userSubscribedOnEleicao )
                                <form enctype="multipart/form-data" method="POST" action="{{ route('user.eleicao.store', $eleicoes->id) }}">
                                    @csrf
                                    <tr class="row justify-content-around">
                                        <td class="col-12 col-md-2">
                                                <select class="form-control" name="categoria" id="categoria">
                                                    <option value="">Selecionar Categoria</option>
                                                    <option value="candidato">Candidato</option>
                                                    <option value="eleitor">Eleitor</option>
                                                </select>
                                        </td>
                                        <td class="col-12 col-md-2">
                                                <select class="form-control" name="ocupacao" id="ocupacao">
                                                    <option value="">Selecionar Ocupação</option>
                                                    <option value="docente">Docente</option>
                                                    <option value="discente">Discente</option>
                                                    <option value="pai/mãe">Pai/mãe</option>
                                                </select>
                                        </td>
                                        <td class="col-12 col-md-2">
                                        <input type="hidden" id="user_id" name="user_id">
                                            <label>Documentos</label>
                                            <input class="btn btn-sm" type="file" id='doc_user' name='doc_user'/>
                                        </td>
                                        <td class="col-12 col-md-2">
                                           <button type="submit" class="btn btn-success">Inscrever</button>
                                        </td>
                                    </tr>
                                </form>
                            @endif

                            {{-- REMOVER INSCRIÇÃO --}}
                            @if( $userSubscribedOnEleicao)
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-2">
                                    <form method="POST" action='{{ route("user.eleicoes.destroy", $eleicoes->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-md btn-block btn-danger" onclick="return confirm('Remover inscrição?')">Remover inscrição</button>
                                    </form>
                                </div>
                                <div class="col-12 col-md-2">
                                    <a class="btn btn-md btn-block btn-info mr-2" href='{{ url("storage/doc/eleicao_user/{$eleicoes->id}/{$user->pivot->doc_user}") }}' target="_blank">
                                        Visualizar documentos
                                    </a>
                                </div>
                            </div>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
