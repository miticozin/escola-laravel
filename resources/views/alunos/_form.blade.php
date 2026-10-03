@php
    $disciplinasSelecionadas = old('disciplinas', $aluno->exists ? $aluno->disciplinas->pluck('id')->all() : []);
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($metodo === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label" for="nome">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $aluno->nome) }}" required>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label" for="matricula">Matrícula</label>
            <input type="text" id="matricula" name="matricula" class="form-control" value="{{ old('matricula', $aluno->matricula) }}" required>
        </div>
        <div class="col-md-8 mb-3">
            <label class="form-label" for="email">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $aluno->email) }}">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Disciplinas</label>
        <div class="border rounded bg-white p-3">
            @forelse ($disciplinas as $disciplina)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="disciplinas[]" id="disciplina{{ $disciplina->id }}" value="{{ $disciplina->id }}" @checked(in_array($disciplina->id, $disciplinasSelecionadas))>
                    <label class="form-check-label" for="disciplina{{ $disciplina->id }}">{{ $disciplina->nome }}</label>
                </div>
            @empty
                <span class="text-muted">Nenhuma disciplina cadastrada ainda.</span>
            @endforelse
        </div>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('alunos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
