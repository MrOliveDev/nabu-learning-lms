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

    public function scopeGet_selected_data($query, $title) {
        $data = $query->where('tag_name', $title)->first();
        return $data;
    }
}
