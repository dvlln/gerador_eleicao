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

                        @foreach($eleicoes->users as $user)
                            @if ($user->pivot->categoria === 'candidato')
                                <li class="list-group-item">
                                    <img src="{{ url("storage/user_foto/{$user->foto}") }}" alt="foto_perfil" >
                                </li>

                                <li class="list-group-item">
                                    <span class="mb-1 d-flex d-12 text-align-center">{{ $user->name }}</span>
                                </li>
                            @endif
                        @endforeach

                        <li class="list-group-item">
                            <form enctype="multipart/form-data" method="POST" action="{{ route('user.eleicao.store', $eleicoes->id) }}">
                                @csrf
                                <div>
                                    <input type="hidden" id="user_id" name="user_id">
                                </div>
                                <div class="col col-lg-2">
                                    <input class="btn btn-sm" type="file" id='doc_user' name='doc_user'/>
                                </div>
                                <div class="col col-lg-2">
                                    <select class="form-control" name="categoria" id="categoria">
                                        <option value="">Selecione</option>
                                        <option value="candidato">candidato</option>
                                        <option value="eleitor">eleitor</option>
                                    </select>
                                </div>
                                <div class="col col-lg-2">
                                    <button type="submit" class="btn btn-success">Inscrever</button>
                                </div>
                            </form>
                        </li>
                        <li class="list-group-item">
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
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
