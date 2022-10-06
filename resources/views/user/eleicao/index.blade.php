@extends('layouts.panelUser')
@section('title', 'Eleições')
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
            @foreach($eleicoes as $eleicao)
                <tr>
                <td class="align-middle">{{ $eleicao->name }}</td>
                    <td class="align-middle">{{ $eleicao->startDate_formatted }}</td>
                    <td class="align-middle">{{ $eleicao->endDate_formatted }}</td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm btn-info mr-2" href="{{ route('user.eleicao.show', $eleicao->id) }}">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
           @endforeach
        </tbody>
    </table>
    {{ $eleicoes->links() }}
@endsection
