<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'status', 'description', 'creation_date'
    ];

    protected $table = 'tb_groups';
    public $timestamps = false;
}
