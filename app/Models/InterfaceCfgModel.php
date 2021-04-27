<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterfaceCfgModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'tag_name', 'color_schemar_hex', 'color_schemar_hex_hover', 'icon_font'
    ];

    protected $table = 'tb_interface_config';

    public $timestamps = false;
}
