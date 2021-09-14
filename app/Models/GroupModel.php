<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'status', 'description', 'creation_date'
    ];

    protected $table = 'tb_groups';
    public $timestamps = false;

    public function scopeGetGroupByClient($query) {
        $client = session("client");

        if(auth()->user()->type != 0) {
            if(auth()->user()->type ==3 ){
                $groups = $query
                ->where("id_creator", auth()->user()->id)
                ->get();
            } else {
                $groups = $query->where("id_creator", $client)
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        } else {
            $groups = $query->where("id_creator", $client)->get();
        }
        return $groups;
    }
}
