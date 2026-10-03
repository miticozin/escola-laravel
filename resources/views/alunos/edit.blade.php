@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Editar aluno</h2>
@include('alunos._form', ['action' => route('alunos.update', $aluno), 'metodo' => 'PUT'])
@endsection
