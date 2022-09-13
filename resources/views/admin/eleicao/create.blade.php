@extends('layouts.panel')
@section('title', 'Nova eleição')
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
    <form action="{{ route('admin.eleicao.store') }}" method="POST" autocomplete="off">
        @include('admin.eleicao.formTemplate.form')
    </form>
@endsection