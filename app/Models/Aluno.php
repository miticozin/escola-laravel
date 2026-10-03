<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aluno extends Model
{
    protected $table = 'alunos';

    protected $fillable = ['nome', 'matricula', 'email'];

    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'aluno_disciplina', 'aluno_id', 'disciplina_id');
    }
}
