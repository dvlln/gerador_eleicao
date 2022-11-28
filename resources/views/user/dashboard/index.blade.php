@extends('layouts.panelUser')
@section('title', 'Dashboard')
@section('content')
    Dashboard do usuario
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
