<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailHistories extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'senderId', 'detail', 'modelId', 'result', 'created_time', 'id_creator'
    ];

    protected $table = 'tb_mail_history';

    public $timestamps = false;

    public function scopeGetMailHistoryByClient($query) {
        if(isset(session("permission")->limited)) {
            $result = $query->where("id_creator", auth()->user()->id)
            ->get();
        } else {
            if(auth()->user()->type < 2 ) {
                $result = $query->where("id_creator", session("client"))
                ->get();
            } else {
                $result == $query->where("id_creator", session("client"))
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        }
        return $result;
    }
}
