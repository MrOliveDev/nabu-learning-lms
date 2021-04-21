<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'alpha_id', 'name', 'code', 'id_creator', 'style', 'published'
    ];

    protected $table = 'tb_template_html5_edit';

    public $timestamps = false;
}
