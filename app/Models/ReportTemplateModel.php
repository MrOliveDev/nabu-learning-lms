<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'creatorId', 'name', 'data', 'created_time', 'id_creator'
    ];

    protected $connection= 'mysql_reports';
    
    protected $table = 'tb_report_model';

    public $timestamps = false;

    public function scopeGetTemplateModelByClient($query) {
        // if(isset(session("permission")->limited)){
            // $result = $query
            //     ->where("id_creator", auth()->user()->id)->get();
        // } else {
            if(auth()->user()->type < 2) {
                $result = $query
                ->whereIn("id_creator", User::get_members())->get();
            } else {
                $result = $query
                    ->where("id_creator", session("client"))
                    ->orWhere("id_creator", auth()->user()->id)
                    ->get();
            }
        // }
        return $result;
    }
}
