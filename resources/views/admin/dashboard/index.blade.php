@extends('layouts.panel')
@section('title', 'Dashboard')
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
    Dashboard do admin
@endsection
