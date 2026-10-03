<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfessorController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $professores = Professor::withCount('disciplinas')
            ->when($busca, fn ($q) => $q->where('nome', 'like', "%{$busca}%")->orWhere('email', 'like', "%{$busca}%"))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('professores.index', compact('professores', 'busca'));
    }

    public function create()
    {
        return view('professores.create', ['professor' => new Professor()]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:professores,email'],
            'titulacao' => ['nullable', 'string', 'max:255'],
        ]);

        Professor::create($dados);

        return redirect()->route('professores.index')->with('sucesso', 'Professor cadastrado com sucesso.');
    }

    public function edit(Professor $professor)
    {
        return view('professores.edit', compact('professor'));
    }

    public function update(Request $request, Professor $professor)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('professores', 'email')->ignore($professor->id)],
            'titulacao' => ['nullable', 'string', 'max:255'],
        ]);

        $professor->update($dados);

        return redirect()->route('professores.index')->with('sucesso', 'Professor atualizado com sucesso.');
    }

    public function destroy(Professor $professor)
    {
        if ($professor->disciplinas()->exists()) {
            return redirect()->route('professores.index')->with('erro', 'Não é possível excluir um professor que possui disciplinas.');
        }

        $professor->delete();

        return redirect()->route('professores.index')->with('sucesso', 'Professor excluído com sucesso.');
    }
}
