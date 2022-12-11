@extends('layouts.panelUser')

@section('title', $eleicoes->name)

@section('content')

    {{-- INFORMAÇÕES GERAIS --}}
    @if(!session()->has('success'))
        @if($duringEleicao && $votacao_status === 1)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Voto já efetuado
            </div>

        @elseif(($duringInscricao || $duringHomologacao) && $doc_user_status === 'pendente')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Aprovação pendente, favor aguardar.
            </div>
        @elseif($duringInscricao && $doc_user_status === 'reprovado')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Documento reprovado, favor aguardar inicio da homologação.
            </div>
        @elseif(($duringInscricao || $duringHomologacao) && $doc_user_status === 'aprovado')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Documento aprovado, favor aguardar inicio da eleição.
            </div>
        @elseif($duringHomologacao && $doc_user_status === 'reprovado')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Documento reprovado, favor alterar antes que o tempo de homologação acabe.
            </div>
        @elseif($duringEleicao && $doc_user_status != 'aprovado')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Documento reprovado, não poderá participar da eleição.
            </div>
        @endif
    @endif

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
                            <span class="font-weight-bold mb-1"> <i type="button" class="fa-solid fa-circle-question fa-small" data-toggle="tooltip" data-placement="top" title="Tempo para ajustar os documentos de inscrição"></i> Início homologação: </span>
                            {{ $eleicoes->start_date_homologacao_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim homologação: </span>
                            {{ $eleicoes->end_date_homologacao_formatted }}
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
                    {{-- CANDIDATOS --}}
                    <div class="row justify-content-center">
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
                                            <img style="width: 12rem;" src="{{ url("storage/perfil/$user->foto") }}" alt="foto_perfil" >
                                            <h5 class="card-title mt-2 mb-0">{{ $user->name }}</h5>
                                            @if ($user->id === $vencedor && $afterEleicao)
                                                <p class="text-danger mt-1 mb-0"><b>VENCEDOR!!!</b></p>
                                            @endif
                                            @if ($duringEleicao && $doc_user_status === 'aprovado' && $votacao_status === 0)
                                                <form class="mt-2" method="POST" action="{{ route('user.eleicao.vote', $eleicoes->id) }}">
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

    {{-- INSCRIÇÃO --}}
    @if($duringInscricao || ($duringHomologacao && $doc_user_status != 'aprovado'))
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
                                        <td class="col-12 border-0">
                                            <label for="doc_user">Categoria</label>
                                                <select
                                                    class="form-control {{ $errors->has('categoria') ? 'is-invalid' : '' }}"
                                                    id="categoria"
                                                    name="categoria"
                                                >
                                                    <option value="">Selecionar Categoria</option>
                                                    <option value="candidato">Candidato</option>
                                                    <option value="eleitor">Eleitor</option>
                                                </select>
                                                <div class="invalid-feedback text-left">{{ $errors->first('categoria') }}</div>
                                        </td>

                                        <td class="col-12 border-0">
                                            <label for="doc_user">Ocupação</label>
                                                <select
                                                    class="form-control {{ $errors->has('ocupacao') ? 'is-invalid' : '' }}"
                                                    id="ocupacao"
                                                    name="ocupacao"
                                                >
                                                    <option value="">Selecionar Ocupação</option>
                                                    <option value="docente">Docente</option>
                                                    <option value="discente">Discente</option>
                                                    <option value="pai/mãe">Pai, mãe ou responsável</option>
                                                </select>
                                                <div class="invalid-feedback text-left">{{ $errors->first('ocupacao') }}</div>
                                        </td>

                                        <td class="col-12 border-0">
                                            <label for="doc_user">Documentos </label>
                                            <i type="button" class="fa-solid fa-circle-question" data-toggle="tooltip" data-placement="top" title="
- Obrigatório envio em PDF
- 01 documento pessoal com foto (ex. RG, Carteira de Trabalho, Habilitação)
- 01 documento comprobatório da categoria selecionada (ex.: RA para Discentes)"></i>
                                            <input
                                                class="form-control {{ $errors->has('doc_user') ? 'is-invalid' : '' }}"
                                                type="file"
                                                id='doc_user'
                                                name='doc_user'
                                            >
                                            <div class="invalid-feedback text-left">{{ $errors->first('doc_user') }}</div>
                                        </td>

                                        <td class="col-12 border-0">
                                            <input type="hidden" id="user_id" name="user_id" />

                                            <button type="submit" class="btn btn-success">Inscrever</button>
                                        </td>
                                    </tr>
                                </form>
                            @else
                                {{-- REMOVER INSCRIÇÃO --}}
                                @if ($duringInscricao && $doc_user_status === 'pendente')
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-12 col-md-4 my-1">
                                            <form method="POST" action='{{ route('user.eleicoes.destroy', $eleicoes->id) }}'>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-md btn-block btn-danger" onclick="return confirm('Remover inscrição?')">Remover inscrição</button>
                                            </form>
                                        </div>
                                        <div class="col-12 col-md-4 my-1">
                                            <a class="btn btn-md btn-block btn-info mr-2" href='{{ url("storage/doc/eleicao_user/{$eleicoes->id}/{$eleicoes->users->find(Auth::id())->pivot->doc_user}") }}' target="_blank">
                                                Visualizar documentos
                                            </a>
                                        </div>
                                    </div>
                                @elseif($duringHomologacao && $doc_user_status === 'reprovado')
                                    <div class="row justify-content-center">
                                        <form method="POST" action='{{ route('user.eleicao.store', $eleicoes->id) }}' enctype="multipart/form-data">
                                            <div class="col-12 col-md-6 my-1">
                                                @csrf
                                                <input type="hidden" name="categoria" value="{{ $eleicoes->users->find(Auth::id())->pivot->categoria }}">
                                                <input type="hidden" name="ocupacao" value="{{ $eleicoes->users->find(Auth::id())->pivot->ocupacao }}">
                                                <input type="file" class="form-control" name="doc_user">
                                            </div>
                                            <div class="col-12 col-md-4 my-1">
                                                <button class="btn btn-md btn-block btn-danger">Enviar documento</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('js')
    {{-- Open and close modal --}}
        @if (session()->has('modalOpen'))
        @if (session('modalOpen') == 1)
            <script>
                $(document).ready(function(){
                    $("#buttonEditPerfil").toggleClass([function(){
                        $("#modalEditPerfil").modal();
                    }]);

                    $("#buttonEditPerfil").click(function(){
                        $("#modalEditPerfil").modal();
                    });
                });
            </script>
        @endif
        @else
            <script>
                $("#buttonEditPerfil").click(function(){
                    $("#modalEditPerfil").modal();
                });
            </script>
        @endif
    {{-- End open and close modal --}}
@endsection
