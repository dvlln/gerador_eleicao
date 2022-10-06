@extends('layouts.panelAdmin')
@section('title', 'Editar evento')
@section('content')
    <form action="{{ route('admin.eleicao.update', $eleicoes->id) }}" method="POST" autocomplete="off">
        @method('PUT')
        @include('admin.eleicao.formTemplate.form')
    </form>
@endsection
