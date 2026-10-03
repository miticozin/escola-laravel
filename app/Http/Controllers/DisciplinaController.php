<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Disciplina;
use App\Models\Professor;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $disciplinas = Disciplina::query()
            ->join('professores', 'professores.id', '=', 'disciplinas.professor_id')
            ->leftJoin('aluno_disciplina', 'aluno_disciplina.disciplina_id', '=', 'disciplinas.id')
            ->leftJoin('alunos', 'alunos.id', '=', 'aluno_disciplina.aluno_id')
            ->select('disciplinas.*')
            ->when($busca, function ($q) use ($busca) {
                $q->where(function ($w) use ($busca) {
                    $w->where('disciplinas.nome', 'like', "%{$busca}%")
                        ->orWhere('professores.nome', 'like', "%{$busca}%")
                        ->orWhere('alunos.nome', 'like', "%{$busca}%");
                });
            })
            ->groupBy('disciplinas.id')
            ->orderBy('disciplinas.nome')
            ->with(['professor', 'alunos'])
            ->paginate(10)
            ->withQueryString();

        return view('disciplinas.index', compact('disciplinas', 'busca'));
    }

    public function create()
    {
        return view('disciplinas.create', [
            'disciplina' => new Disciplina(),
            'professores' => Professor::orderBy('nome')->get(),
            'alunos' => Aluno::orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'carga_horaria' => ['required', 'integer', 'min:1', 'max:1000'],
            'professor_id' => ['required', 'exists:professores,id'],
            'alunos' => ['nullable', 'array'],
            'alunos.*' => ['exists:alunos,id'],
        ]);

        $disciplina = Disciplina::create($request->only('nome', 'carga_horaria', 'professor_id'));
        $disciplina->alunos()->sync($dados['alunos'] ?? []);

        return redirect()->route('disciplinas.index')->with('sucesso', 'Disciplina cadastrada com sucesso.');
    }

    public function edit(Disciplina $disciplina)
    {
        return view('disciplinas.edit', [
            'disciplina' => $disciplina,
            'professores' => Professor::orderBy('nome')->get(),
            'alunos' => Aluno::orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'carga_horaria' => ['required', 'integer', 'min:1', 'max:1000'],
            'professor_id' => ['required', 'exists:professores,id'],
            'alunos' => ['nullable', 'array'],
            'alunos.*' => ['exists:alunos,id'],
        ]);

        $disciplina->update($request->only('nome', 'carga_horaria', 'professor_id'));
        $disciplina->alunos()->sync($dados['alunos'] ?? []);

        return redirect()->route('disciplinas.index')->with('sucesso', 'Disciplina atualizada com sucesso.');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->alunos()->detach();
        $disciplina->delete();

        return redirect()->route('disciplinas.index')->with('sucesso', 'Disciplina excluída com sucesso.');
    }
}
