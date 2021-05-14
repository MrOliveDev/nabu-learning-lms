<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'name'
    ];

    protected $table = 'tb_companies';

    public $timestamps = false;

}
