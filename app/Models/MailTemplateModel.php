<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'creatorId', 'name', 'data', 'created_time'
    ];

    protected $table = 'tb_mail_model';

    public $timestamps = false;

}
