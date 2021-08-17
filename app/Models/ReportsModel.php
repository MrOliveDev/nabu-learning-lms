<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportsModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'sessionId', 'studentId', 'filename', 'type', 'detail', 'created_time'
    ];

    protected $connection= 'mysql_reports';
    
    protected $table = 'tb_reports';

    public $timestamps = false;

}
