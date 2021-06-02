<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'id_creator',
        'date_begin',
        'date_end',
        'status',
        'creation_date',
        'templateformation',
        'lesson_content',
        'type'
    ];

    protected $table = 'tb_trainings';
    use HasFactory;
}
