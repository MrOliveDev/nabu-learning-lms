<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'status', 'description', 'creation_date', 'id_creator'
    ];

    protected $table = 'tb_groups';
    public $timestamps = false;

    public function scopeGetGroupByClient($query) {
        $client = session("client");

        // if(isset(session("permission")->limited)) {
        //     $groups = $query
        //     ->where("id_creator", auth()->user()->id)
        //     ->get();
        // } else {
            if(auth()->check() && auth()->user()->type < 2) {
                $groups = $query->whereIn("id_creator", User::get_members())
                ->get();
            } else {
                $groups = $query->where("id_creator", $client)
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        // }
        return $groups;
    }
}
