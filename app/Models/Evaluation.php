<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'session', 'user_id', 'date_start', 'date_end', 'is_presential', 'user_keypad', 'id_lesson', 'date_hour', 'number_eval', 'progression', 'note', 'status'
    ];

    protected $table = 'evaluation';

    public $timestamps = false;
}
