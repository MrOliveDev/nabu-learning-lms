<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'session', 'idFabrica', 'user_id'
    ];

    protected $table = 'tb_session';

    public $timestamps = false;
}
