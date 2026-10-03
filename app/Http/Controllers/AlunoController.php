<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $alunos = Aluno::query()
            ->leftJoin('aluno_disciplina', 'aluno_disciplina.aluno_id', '=', 'alunos.id')
            ->leftJoin('disciplinas', 'disciplinas.id', '=', 'aluno_disciplina.disciplina_id')
            ->select('alunos.*')
            ->when($busca, function ($q) use ($busca) {
                $q->where(function ($w) use ($busca) {
                    $w->where('alunos.nome', 'like', "%{$busca}%")
                        ->orWhere('alunos.matricula', 'like', "%{$busca}%")
                        ->orWhere('disciplinas.nome', 'like', "%{$busca}%");
                });
            })
            ->groupBy('alunos.id')
            ->orderBy('alunos.nome')
            ->with('disciplinas')
            ->paginate(10)
            ->withQueryString();

        return view('alunos.index', compact('alunos', 'busca'));
    }

    public function create()
    {
        return view('alunos.create', [
            'aluno' => new Aluno(),
            'disciplinas' => Disciplina::orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:20', 'unique:alunos,matricula'],
            'email' => ['nullable', 'email', 'max:255'],
            'disciplinas' => ['nullable', 'array'],
            'disciplinas.*' => ['exists:disciplinas,id'],
        ]);

        $aluno = Aluno::create($request->only('nome', 'matricula', 'email'));
        $aluno->disciplinas()->sync($dados['disciplinas'] ?? []);

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno cadastrado com sucesso.');
    }

    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', [
            'aluno' => $aluno,
            'disciplinas' => Disciplina::orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, Aluno $aluno)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:20', Rule::unique('alunos', 'matricula')->ignore($aluno->id)],
            'email' => ['nullable', 'email', 'max:255'],
            'disciplinas' => ['nullable', 'array'],
            'disciplinas.*' => ['exists:disciplinas,id'],
        ]);

        $aluno->update($request->only('nome', 'matricula', 'email'));
        $aluno->disciplinas()->sync($dados['disciplinas'] ?? []);

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno atualizado com sucesso.');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->disciplinas()->detach();
        $aluno->delete();

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno excluído com sucesso.');
    }
}
