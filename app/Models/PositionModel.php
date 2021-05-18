<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'name', 'description'
    ];

    protected $table = 'tb_position';

    public $timestamps = false;

}
