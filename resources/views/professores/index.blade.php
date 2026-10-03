@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Professores</h2>
    <a href="{{ route('professores.create') }}" class="btn btn-primary">Novo professor</a>
</div>

<form method="GET" action="{{ route('professores.index') }}" class="input-group mb-3">
    <input type="text" name="busca" value="{{ $busca }}" class="form-control" placeholder="Pesquisar por nome ou e-mail">
    <button type="submit" class="btn btn-outline-secondary">Pesquisar</button>
    <a href="{{ route('professores.index') }}" class="btn btn-outline-dark">Limpar</a>
</form>

<table class="table table-striped table-bordered bg-white">
    <thead>
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Titulação</th>
            <th>Disciplinas</th>
            <th style="width: 180px">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($professores as $professor)
            <tr>
                <td>{{ $professor->nome }}</td>
                <td>{{ $professor->email }}</td>
                <td>{{ $professor->titulacao }}</td>
                <td>{{ $professor->disciplinas_count }}</td>
                <td>
                    <a href="{{ route('professores.edit', $professor) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="{{ route('professores.destroy', $professor) }}" class="d-inline" onsubmit="return confirm('Excluir este professor?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Nenhum professor encontrado.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $professores->links('pagination::bootstrap-5') }}
@endsection
