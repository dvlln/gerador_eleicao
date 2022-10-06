@extends('layouts.panelAdmin')
@section('title', 'Nova eleição')
@section('content')
    <form action="{{ route('admin.eleicao.store') }}" method="POST" autocomplete="off">
        @include('admin.eleicao.formTemplate.form')
    </form>
@endsection
