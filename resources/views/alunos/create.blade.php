@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Novo aluno</h2>
@include('alunos._form', ['action' => route('alunos.store'), 'metodo' => 'POST'])
@endsection
