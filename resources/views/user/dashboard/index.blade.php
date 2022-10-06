@extends('layouts.panelUser')
@section('title', 'Dashboard')
@section('sidebar')
    <a class="nav-link" href="{{ route('user.dashboard.index') }}">
       <i class="fa fa-solid fa-house-user"></i>
        <span>Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('user.eleicao.index') }}">
       <i class="fas fa-person-booth"></i>
        <span>Eleições</span>
    </a>
@endsection
@section('content')
    Dashboard do usuario
@endsection
