<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'id', 'name', 'permission'
    ];

    protected $table = 'tb_permission';
    public $timestamps = false;

    public function scopeGetPermission($query, $id) {
        $permissionItem = $query->where('id', $id)->first();
        
        return json_decode($permissionItem->permission);
    }
}
