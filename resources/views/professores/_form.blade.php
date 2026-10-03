<form method="POST" action="{{ $action }}">
    @csrf
    @if ($metodo === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label" for="nome">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $professor->nome) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="email">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $professor->email) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="titulacao">Titulação</label>
        <input type="text" id="titulacao" name="titulacao" class="form-control" value="{{ old('titulacao', $professor->titulacao) }}">
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('professores.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
