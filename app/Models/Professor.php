<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professor extends Model
{
    protected $table = 'professores';

    protected $fillable = ['nome', 'email', 'titulacao'];

    public function disciplinas(): HasMany
    {
        return $this->hasMany(Disciplina::class, 'professor_id');
    }
}
