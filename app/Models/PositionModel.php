<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'name', 'description', 'id_creator'
    ];

    protected $table = 'tb_position';

    public $timestamps = false;

    public function scopeGetPositionByClient($query) {
        // if(isset(session("client")->limited)){
        //     $position = $query
        //     ->where("id_creator", auth()->user()->id)
        //     ->get();
        // } else {
            if(auth()->user()->type < 2) {
                $position = $query->whereIn('id_creator', User::get_members())->get();
            } else {
                $position = $query->where('id_creator', session("client"))
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        // }
        return $position;
    }
}
