<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterfaceCfgModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'admin_id', 'interface_color', 'interface_icon'
    ];

    protected $table = 'tb_interface_config';

    public $timestamps = false;

    public function scopeGet_interface_color_byuser($query, $user_id)
    {
        $data = $query->where('admin_id', $user_id)->first();
        return json_decode($data->interface_color);
    }
}
