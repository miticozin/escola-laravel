@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Nova disciplina</h2>
@include('disciplinas._form', ['action' => route('disciplinas.store'), 'metodo' => 'POST'])
@endsection
