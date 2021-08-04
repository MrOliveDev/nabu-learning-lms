<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'userId', 'data'
    ];

    protected $table = 'tb_mail_images';
    public $timestamps = false;
}
