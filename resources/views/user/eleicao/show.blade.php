@extends('layouts.panelUser')

@section('title', $eleicoes->name)

@section('content')

    {{-- INFORMAÇÕES GERAIS --}}
    @if($duringEleicao && $votacao_status === 1 && !session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Voto já efetuado
        </div>
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
                            <span class="font-weight-bold mb-1">Início depuração: </span>
                            {{ $eleicoes->start_date_depuracao_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim depuração: </span>
                            {{ $eleicoes->end_date_depuracao_formatted }}
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
                                            <img style="width: 12rem; margin-bottom: 4px;" src="{{ url("storage/perfil/{$user->foto}") }}" alt="foto_perfil" >
                                            <h5 class="card-title">{{ $user->name }}</h5>
                                            @if ($user->id === $vencedor && $afterEleicao)
                                                <p class="text-danger"><b>VENCEDOR!!!</b></p>
                                            @endif
                                            @if ($duringEleicao && $user->pivot->doc_user_status === 'aprovado' && $user->pivot->votacao_status === 0)
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

    {{-- INSCRIÇÃO --}}
    @if( $duringInscricao || ($duringDepuracao && $doc_user_status != 'aprovado') )
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
                                                    <option value="pai/mãe">Pai/mãe</option>
                                                </select>
                                                <div class="invalid-feedback text-left">{{ $errors->first('ocupacao') }}</div>
                                        </td>

                                        <td class="col-12 border-0">
                                            <label for="doc_user">Documentos </label> <a class="fa-solid fa-circle-info tip"><span>Obrigatório envio de:<br><br> 01 documento pessoal com foto (ex: RG, Carteira de Trabalho)<br><br>01 documento comprobatório da categoria selecionada (ex: comprovante de matrícula discentes, CTPS docentes)</span></a>
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
                            @endif

                            {{-- REMOVER INSCRIÇÃO --}}
                            @if( $userSubscribedOnEleicao)
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-2">
                                    <form method="POST" action='{{ route('user.eleicoes.destroy', $eleicoes->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-md btn-block btn-danger" onclick="return confirm('Remover inscrição?')">Remover inscrição</button>
                                    </form>
                                </div>
                                <div class="col-12 col-md-2">
                                    <a class="btn btn-md btn-block btn-info mr-2" href='{{ url("storage/doc/eleicao_user/{$eleicoes->id}/{$eleicoes->users->find(Auth::id())->pivot->doc_user}") }}' target="_blank">
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

    <style>
        a.tip {
            border-bottom: 1px;
            text-decoration: none
        }
        a.tip:hover {
            cursor: help;
            position: relative
        }
        a.tip span {
            display: none
        }
        a.tip:hover span {
            border: #c0c0c0 1px solid;
            padding: 5px 20px 5px 5px;
            display: block;
            z-index: 100;
            background: whitesmoke no-repeat 100% 5%;
            left: 0px;
            margin: 10px;
            width: 250px;
            position: absolute;
            top: 10px;
            color: grey;
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }
        </style>

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
