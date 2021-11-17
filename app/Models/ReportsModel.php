<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportsModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'sessionId', 'studentId', 'filename', 'type', 'detail', 'created_time', 'id_creator', 'model'
    ];

    protected $connection= 'mysql_reports';
    
    protected $table = 'tb_reports';

    public $timestamps = false;

    public function scopeGetReportByClient($query) {
        // if(isset(session("permission")->limited)){
        //     $report = $query->where('id_creator', auth()->user()->id)->get();
        // } else {
            if(auth()->user()->type < 2) {
                $report = $query->whereIn('id_creator', User::get_members())->get();
            } else {
                $report = $query
                ->where('id_creator', auth()->user()->id)
                ->orWhere('id_creator', session("client"))
                ->get();
            }
        // }
        return $report;
    }
}
