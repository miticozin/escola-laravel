@php
    $alunosSelecionados = old('alunos', $disciplina->exists ? $disciplina->alunos->pluck('id')->all() : []);
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($metodo === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label" for="nome">Nome da disciplina</label>
        <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $disciplina->nome) }}" required>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label" for="carga_horaria">Carga horária (horas)</label>
            <input type="number" id="carga_horaria" name="carga_horaria" class="form-control" value="{{ old('carga_horaria', $disciplina->carga_horaria) }}" required>
        </div>
        <div class="col-md-8 mb-3">
            <label class="form-label" for="professor_id">Professor</label>
            <select id="professor_id" name="professor_id" class="form-select" required>
                <option value="">Selecione</option>
                @foreach ($professores as $professor)
                    <option value="{{ $professor->id }}" @selected(old('professor_id', $disciplina->professor_id) == $professor->id)>{{ $professor->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Alunos matriculados</label>
        <div class="border rounded bg-white p-3">
            @forelse ($alunos as $aluno)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="alunos[]" id="aluno{{ $aluno->id }}" value="{{ $aluno->id }}" @checked(in_array($aluno->id, $alunosSelecionados))>
                    <label class="form-check-label" for="aluno{{ $aluno->id }}">{{ $aluno->nome }} ({{ $aluno->matricula }})</label>
                </div>
            @empty
                <span class="text-muted">Nenhum aluno cadastrado ainda.</span>
            @endforelse
        </div>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('disciplinas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
