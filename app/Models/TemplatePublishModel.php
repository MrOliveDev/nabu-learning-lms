<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplatePublishModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'alpha_id',
        'name',
        'code',
        'id_creator',
        'style'
    ];

    protected $table = 'tb_template_html5';

    public $timestamps = false;
}

