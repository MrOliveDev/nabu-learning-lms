<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettingModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'value'
    ];
    
    protected $table = 'settings';

    public $timestamps = false;
}
