@extends('layouts.panelAdmin')

@section('title', $eleicoes->name)

@section('import')
    @if ($duringInscricao)
        {{-- IMPORTAR USUARIOS POR CSV --}}
        <button class="btn btn-primary mb-2" type="button" id="buttonImport">Importar usuário</button>

        <div class="modal fade" id="modalImport" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Selecione o arquivo a ser importado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <i type="button" class="fa-solid fa-circle-info" data-toggle="tooltip" data-placement="top" title="
nome
email
cpf
categoria
ocupacao"> Documentos</i>
                        <form action="{{ route('admin.eleicao.import', $eleicoes->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input
                                class="form-control {{ $errors->has('import') ? 'is-invalid' : '' }}"
                                type="file"
                                id="import"
                                name='import'
                            />
                            <div class="invalid-feedback">{{ $errors->first('import') }}</div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
                            <span class="font-weight-bold mb-1">Início inscrição: </span>
                            {{ $eleicoes->start_date_inscricao_formatted }}
                        </li>
                        <li class="list-group-item">
                        <span class="font-weight-bold mb-1">Fim inscrição: </span>
                            {{ $eleicoes->end_date_inscricao_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Início homologação: </span>
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
                        @if ( $afterEleicao )
                            <li class="list-group-item">
                                <span class="font-weight-bold mb-1">Total de votos: </span>
                                {{ $total }}
                            </li>
                        @endif
                        <li class="list-group-item bg-primary">
                            <span class="font-weight-bold text-white mb-1 text-align-center">Candidatos</span>
                        </li>

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
                                            <div class="card-body row justify-content-center">
                                                <div class="col-12">
                                                    <img style="width: 12rem;" src="{{ url("storage/perfil/$user->foto") }}" alt="foto_perfil" >
                                                </div>
                                                <div class="col-12">
                                                    <h5 class="card-title mt-2 mb-0">{{ $user->name }}</h5>
                                                </div>
                                                <div class="col-12">
                                                    @if ($afterEleicao)
                                                        <span>Qtd. votos: {{ $user->pivot->voto }}</span>
                                                        @if($user->id === $vencedor)
                                                            <p class="text-danger mt-1 mb-0"><b>VENCEDOR!!!</b></p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
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
                                <th>CPF</th>

                                {{-- APARECERÁ O STATUS DA VOTAÇÃO QUANDO A ELEIÇÃO COMEÇAR --}}
                                @if ( $duringEleicao || $afterEleicao)
                                    <th>Status Votação</th>
                                @endif

                                @if ( $duringInscricao || $duringHomologacao)
                                    <th>Ações</th>
                                    <th>Status</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($eleicoes->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->cpf }}</td>

                                        {{-- APARECERÁ O STATUS DA VOTAÇÃO QUANDO A ELEIÇÃO COMEÇAR --}}
                                        @if ( $duringEleicao || $afterEleicao)
                                            @if ($user->pivot->votacao_status === 1)
                                                <td class="bg-green"><i class="fa-solid fa-check fa-xl"></i></td>
                                            @else
                                                <td><i class="fa-solid fa-xmark fa-2xl"></i></td>
                                            @endif
                                        @endif

                                        @if ( $duringInscricao || $duringHomologacao )
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
                                                            <button class="btn btn-sm btn-success mr-2" onclick="return confirm('Aprovar usuário?')">
                                                                <i class="fa-solid fa-check fa-l"></i>
                                                            </button>
                                                        </form>

                                                    {{-- REPROVAR O USUARIO --}}
                                                        <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" id="buttonReprovar_{{ $user->id }}">
                                                            <i class="fa-solid fa-xmark fa-l"></i>
                                                        </button>

                                                        <div class="modal fade" id="modalReprovar_{{ $user->id }}" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modal_title">Informe o motivo da reprovação</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{ route('admin.eleicao.deny', ['eleicao' => $eleicoes->id, 'user' => $user->id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <textarea
                                                                                class="form-control {{ $errors->has('doc_user_message') ? 'is-invalid' : '' }}"
                                                                                rows="10"
                                                                                name="doc_user_message"></textarea>
                                                                                <div class="invalid-feedback">{{ $errors->first('doc_user_message') }}</div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-success">Salvar</button>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </td>

                                            <td>{{ $user->pivot->doc_user_status }}</td>
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

@section('js')
    {{-- Open and close modal --}}
    @if (session()->has('modalOpen'))
        @if (session('modalOpen') == 1)
            <script>
                $(document).ready(function(){
                    $("#buttonEditPerfil").click(function(){
                        $("#modalEditPerfil").modal();
                    });
                    $("#buttonEditPerfil").toggleClass([function(){
                        $("#modalEditPerfil").modal();
                    }]);
                    $("#buttonEditSecretaria").click(function(){
                        $("#modalEditSecretaria").modal();
                    });
                    $("#buttonImport").click(function(){
                        $("#modalImport").modal();
                    });
                });
            </script>
            @foreach ($eleicoes->users as $user)
                <script>
                    $(document).ready(function(){
                        $("#buttonReprovar_"+{{ $user->id }}).click(function(){
                            $("#modalReprovar_"+{{ $user->id }}).modal();
                        });
                    });
                </script>
            @endforeach
        @elseif (session('modalOpen') == 2)
            <script>
                $(document).ready(function(){
                    $("#buttonEditSecretaria").click(function(){
                        $("#modalEditSecretaria").modal();
                    });
                    $("#buttonEditSecretaria").toggleClass([function(){
                        $("#modalEditSecretaria").modal();
                    }]);
                    $("#buttonEditPerfil").click(function(){
                        $("#modalEditPerfil").modal();
                    });
                    $("#buttonImport").click(function(){
                        $("#modalImport").modal();
                    });
                });
            </script>
            @foreach ($eleicoes->users as $user)
                <script>
                    $(document).ready(function(){
                        $("#buttonReprovar_"+{{ $user->id }}).click(function(){
                            $("#modalReprovar_"+{{ $user->id }}).modal();
                        });
                    });
                </script>
            @endforeach
        @elseif (session('modalOpen') == 3)
            <script>
                $(document).ready(function(){
                    $("#buttonImport").click(function(){
                        $("#modalImport").modal();
                    });
                    $("#buttonImport").toggleClass([function(){
                        $("#modalImport").modal();
                    }]);
                    $("#buttonEditSecretaria").click(function(){
                        $("#modalEditSecretaria").modal();
                    });
                    $("#buttonEditPerfil").click(function(){
                        $("#modalEditPerfil").modal();
                    });
                });
            </script>
            @foreach ($eleicoes->users as $user)
                <script>
                    $(document).ready(function(){
                        $("#buttonReprovar_"+{{ $user->id }}).click(function(){
                            $("#modalReprovar_"+{{ $user->id }}).modal();
                        });
                    });
                </script>
            @endforeach
        @elseif (session('modalOpen') == 4)
            <script>
                $(document).ready(function(){
                    $("#buttonReprovar_"+{{ session('userId') }}).toggleClass([function(){
                        $("#modalReprovar_"+{{ session('userId') }}).modal();
                    }]);
                    $("#buttonEditSecretaria").click(function(){
                        $("#modalEditSecretaria").modal();
                    });
                    $("#buttonEditPerfil").click(function(){
                        $("#modalEditPerfil").modal();
                    });
                    $("#buttonImport").click(function(){
                        $("#modalImport").modal();
                    });
                });
            </script>
            @foreach ($eleicoes->users as $user)
                <script>
                    $(document).ready(function(){
                        $("#buttonReprovar_"+{{ $user->id }}).click(function(){
                            $("#modalReprovar_"+{{ $user->id }}).modal();
                        });
                    });
                </script>
            @endforeach
    @endif
    @else
        <script>
            $(document).ready(function(){
                $("#buttonEditPerfil").click(function(){
                    $("#modalEditPerfil").modal();
                });

                $("#buttonEditSecretaria").click(function(){
                    $("#modalEditSecretaria").modal();
                });

                $("#buttonImport").click(function(){
                    $("#modalImport").modal();
                });
            });
        </script>
        @foreach ($eleicoes->users as $user)
            <script>
                $(document).ready(function(){
                    $("#buttonReprovar_"+{{ $user->id }}).click(function(){
                        $("#modalReprovar_"+{{ $user->id }}).modal();
                    });
                });
            </script>
        @endforeach
    @endif
    {{-- End open and close modal --}}
@endsection
