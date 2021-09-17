<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'creatorId', 'name', 'subject', 'data', 'created_time', 'id_creator'
    ];

    protected $table = 'tb_mail_model';

    public $timestamps = false;

    public function scopeGetMailTemplateByClient($query) {
        if(isset(session("permission")->limited)) {
            $result = $query->where("id_creator", auth()->user()->id)
            ->get();
        } else {
            if(auth()->user()->type < 2) {
                $result = $query->where("id_creator", session("client"))
                ->get();
            } else {
                $result = $query->where("id_creator", session("client"))
                ->orWhere("id_creator", session("client"))
                ->get();
            }
        }
        return $result;
    }
}
