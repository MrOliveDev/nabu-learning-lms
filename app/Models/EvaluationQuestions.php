<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EvaluationQuestions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'id_evaluation', 'id_q', 'id_group', 'name_group', 'num_order', 'title', 'option_serialize', 'expected_response', 'reply', 'points'
    ];

    protected $table = 'evaluation';

    public $timestamps = false;
}
