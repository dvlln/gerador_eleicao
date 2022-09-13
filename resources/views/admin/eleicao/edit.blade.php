@extends('layouts.panel')
@section('title', 'Editar evento')
@section('sidebar')
    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
        <i class="fa fa-solid fa-house-user"></i>
        <span>Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('admin.eleicao.index') }}">
        <i class="fas fa-person-booth"></i>
        <span>Eleições</span>
    </a>
@endsection
@section('content')
    <form action="{{ route('admin.eleicao.update', $eleicoes->id) }}" method="POST" autocomplete="off">
        @method('PUT')
        @include('admin.eleicao.formTemplate.form')
    </form>
@endsection