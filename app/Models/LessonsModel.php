<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class LessonsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'publicoAlvo',
        'dataCriacao',
        'status',
        'idFabrica',
        'idCriador',
        'threshold_score',
        'template_player_id'
    ];

    protected $table = 'tb_lesson';
    use HasFactory;
}
