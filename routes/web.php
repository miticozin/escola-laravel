<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\ProfessorController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('disciplinas.index'));

Route::resource('professores', ProfessorController::class)->except('show')->parameters(['professores' => 'professor']);
Route::resource('disciplinas', DisciplinaController::class)->except('show');
Route::resource('alunos', AlunoController::class)->except('show');
