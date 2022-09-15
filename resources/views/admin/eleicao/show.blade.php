@extends('layouts.panel')
@section('title', $eleicoes->name)
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Informações gerais</div>
                <div class="card-body">
                    <ul class="list-group text-center">
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Início: </span>
                            {{ $eleicoes->startDate_formatted }}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold mb-1">Fim: </span>
                            {{ $eleicoes->endDate_formatted }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Participantes</div>
        <div class="card-body">
            <table class="table bg-white mt-3">
                <thead>
                    <th>Nome</th>
                    <th>Categoria</th>
                </thead>
                <tbody>
                    @foreach($eleicoes->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            {{-- <td>{{ $user->categoria }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
