@extends('layouts.app')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Alunos</h2>
    <a href="{{ route('alunos.create') }}" class="btn btn-primary">Novo aluno</a>
</div>

<form method="GET" action="{{ route('alunos.index') }}" class="input-group mb-3">
    <input type="text" name="busca" value="{{ $busca }}" class="form-control" placeholder="Pesquisar por nome, matrícula ou disciplina">
    <button type="submit" class="btn btn-outline-secondary">Pesquisar</button>
    <a href="{{ route('alunos.index') }}" class="btn btn-outline-dark">Limpar</a>
</form>

<table class="table table-striped table-bordered bg-white">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>E-mail</th>
            <th>Disciplinas</th>
            <th style="width: 180px">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($alunos as $aluno)
            <tr>
                <td>{{ $aluno->nome }}</td>
                <td>{{ $aluno->matricula }}</td>
                <td>{{ $aluno->email }}</td>
                <td>{{ $aluno->disciplinas->pluck('nome')->join(', ') }}</td>
                <td>
                    <a href="{{ route('alunos.edit', $aluno) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="{{ route('alunos.destroy', $aluno) }}" class="d-inline" onsubmit="return confirm('Excluir este aluno?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Nenhum aluno encontrado.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $alunos->links('pagination::bootstrap-5') }}
@endsection
