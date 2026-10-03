@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Editar professor</h2>
@include('professores._form', ['action' => route('professores.update', $professor), 'metodo' => 'PUT'])
@endsection
