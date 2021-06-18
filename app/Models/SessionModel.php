<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;

    protected $fillable = [
'id',
'session_code',
'name',
'begin_date',
'linked_item',
'create_date',
'templateformation',
'description',
'end_date',

    ];

    protected $table = 'tb_session';

    public $timestamps = false;
}
