<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailHistories extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'senderId', 'detail', 'modelId', 'result', 'created_time'
    ];

    protected $table = 'tb_mail_history';

    public $timestamps = false;

}
