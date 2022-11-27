@extends('layouts.panelAdmin')
@section('title', 'Eleições')
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
    <table class="table mt-4 text-center">
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
                    <td class="align-middle">{{ $eleicao->start_date_eleicao_formatted }}</td>
                    <td class="align-middle">{{ $eleicao->end_date_eleicao_formatted }}</td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-center">
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

    {{ $eleicoes->links() }}
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

                        $("#buttonEditSecretaria").click(function(){
                            $("#modalEditSecretaria").modal();
                        });
                    });
                </script>
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
                        });
                    </script>
        @endif
        @else
            <script>
                $("#buttonEditPerfil").click(function(){
                    $("#modalEditPerfil").modal();
                });

                $("#buttonEditSecretaria").click(function(){
                    $("#modalEditSecretaria").modal();
                });
            </script>
        @endif
    {{-- End open and close modal --}}
@endsection
