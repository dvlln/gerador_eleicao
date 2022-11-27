@extends('layouts.panelAdmin')
@section('title', 'Editar evento')
@section('content')
    <form action="{{ route('admin.eleicao.update', $eleicoes->id) }}" method="POST" autocomplete="off">
        @method('PUT')
        @include('admin.eleicao.formTemplate.form')
    </form>

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
