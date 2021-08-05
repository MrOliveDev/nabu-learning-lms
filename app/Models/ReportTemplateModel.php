<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'data', 'created_time'
    ];

    protected $table = 'tb_report_model';

    public $timestamps = false;

}
