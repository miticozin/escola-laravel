@extends('layouts.app')

@section('conteudo')
<h2 class="mb-3">Novo professor</h2>
@include('professores._form', ['action' => route('professores.store'), 'metodo' => 'POST'])
@endsection
