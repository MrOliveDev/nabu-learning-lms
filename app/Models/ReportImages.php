<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'userId', 'data'
    ];

    protected $table = 'tb_report_images';
    public $timestamps = false;
}
