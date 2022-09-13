@extends('layouts.panel')
@section('title', 'Eleições')
@section('sidebar')
    <a class="nav-link" href="{{ route('user.dashboard.index') }}">
        <i class="fa fa-solid fa-house-user"></i>
        <span>Dashboard</span>
    </a> 
    <a class="nav-link" href="{{ route('user.eleicao.viewEleicao') }}">
        <i class="fas fa-person-booth"></i>
        <span>Eleições</span>
    </a>
@endsection
@section('content')
<form>
            <div class="d-flex flex-fill">
                <input type="text" name="search" class="form-control w-50 mr-2" value="" placeholder="Pesquisar...">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>
    </form>
    <table class="table mt-4">
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

        </tbody>
    </table>
@endsection
