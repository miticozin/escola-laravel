<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('disciplinas.index') }}">Sistema Escolar</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('disciplinas.index') }}">Disciplinas</a>
                <a class="nav-link" href="{{ route('professores.index') }}">Professores</a>
                <a class="nav-link" href="{{ route('alunos.index') }}">Alunos</a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @if (session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        @if (session('erro'))
            <div class="alert alert-danger">{{ session('erro') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('conteudo')
    </div>
</body>
</html>
