@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Disciplinas</h2>
    <a href="{{ route('disciplinas.create') }}" class="btn btn-primary">Nova disciplina</a>
</div>

<form method="GET" action="{{ route('disciplinas.index') }}" class="input-group mb-3">
    <input type="text" name="busca" value="{{ $busca }}" class="form-control" placeholder="Pesquisar por disciplina, professor ou aluno">
    <button type="submit" class="btn btn-outline-secondary">Pesquisar</button>
    <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-dark">Limpar</a>
</form>

<table class="table table-striped table-bordered bg-white">
    <thead>
        <tr>
            <th>Disciplina</th>
            <th>Professor</th>
            <th>Carga horária</th>
            <th>Alunos</th>
            <th style="width: 180px">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($disciplinas as $disciplina)
            <tr>
                <td>{{ $disciplina->nome }}</td>
                <td>{{ $disciplina->professor->nome }}</td>
                <td>{{ $disciplina->carga_horaria }}h</td>
                <td>{{ $disciplina->alunos->pluck('nome')->join(', ') }}</td>
                <td>
                    <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="{{ route('disciplinas.destroy', $disciplina) }}" class="d-inline" onsubmit="return confirm('Excluir esta disciplina?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Nenhuma disciplina encontrada.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $disciplinas->links('pagination::bootstrap-5') }}
@endsection
