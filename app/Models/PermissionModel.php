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
        $permissionItem = PermissionModel::where('id', $id)->get();
        return $permissionItem[0]->permission!=null ? json_decode($permissionItem[0]->permission) : null;
    }
}
