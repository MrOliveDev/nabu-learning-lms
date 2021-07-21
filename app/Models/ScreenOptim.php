<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScreenOptim extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_screen_optim', 'id_fabrique_screen_optim', 'id_curso_screen_optim', 'id_user_screen_optim', 'progress_screen_optim', 'last_date_screen_optim', 'first_eval_id_screen_optim', 'last_eval_id_screen_optim'
    ];

    protected $table = 'tb_screen_optim';

    public $timestamps = false;
}
