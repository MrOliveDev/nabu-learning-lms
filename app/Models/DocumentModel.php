<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "id", "filename", "user", "created_date"
    ];
    protected $table = 'tb_document';

    public $timestamps = false;
}
