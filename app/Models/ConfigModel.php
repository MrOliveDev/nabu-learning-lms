<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "id", "config"
    ];
    protected $table = 'tb_config';

    public $timestamps = false;
}
