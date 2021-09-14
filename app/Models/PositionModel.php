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
        if(auth()->user()->type != 0) {
            if(auth()->user()->type == 3) {
                $position = $query
                ->where("id_creator", auth()->user()->id)
                ->get();
            } else {
                $position = $query->where('id_creator', session("client"))
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        } else {
            $position = $query->where('id_creator', session("client"))->get();
        }
        return $position;
    }
}
