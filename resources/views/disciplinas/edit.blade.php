@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Editar disciplina</h2>
@include('disciplinas._form', ['action' => route('disciplinas.update', $disciplina), 'metodo' => 'PUT'])
@endsection
