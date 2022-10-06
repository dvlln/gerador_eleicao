@extends('layouts.panelUser')
@section('title', $eleicoes->name)
@section('content')
    {{-- INFORMAÇÕES GERAIS --}}
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
                        <li class="list-group-item bg-secondary">
                            <span class="font-weight-bold text-white mb-1 text-align-center">Candidatos</span>
                        </li>
                        <li class="list-group-item">
                            @foreach($eleicoes->users as $user)
                                @if ($user->pivot->categoria === 'candidato')
                                    <span class="mb-1 d-flex d-12 text-align-center">{{ $user->name }}</span>
                                @endif
                            @endforeach
                        </li>
                        <li class="list-group-item">
                            <div class='row'>
                                <div class='col'>
                                    <form method="POST" action="{{ route('user.eleicao.store', $eleicoes->id) }}">
                                        @csrf
                                            <div class="col col-lg-2">
                                                <button type="submit" class="btn btn-success">Inscrever</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class='col'>
                                    @if(!$eleicaoEndDateHasPassed)
                                        <form method="POST" action="{{ route('user.eleicao.destroy', [
                                            'eleicao'  => $eleicoes->id,
                                            'user'  => $user->id
                                        ]) }}">

                                            @csrf
                                            @method('DELETE')
                                            <div class="col col-lg-2">
                                                <button class="btn btn-danger">Remover inscrição</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
