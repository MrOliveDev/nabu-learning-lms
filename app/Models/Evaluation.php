<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'session', 'user_id', 'date_start', 'date_end', 'is_presential', 'user_keypad', 'id_lesson', 'date_hour', 'number_eval', 'progression', 'note', 'status'
    ];

    protected $table = 'evaluation';

    public $timestamps = false;

    public function scopeGetEvaluation($query, $sessionId, $idEvaluation){
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_{$sessionId}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_start` datetime DEFAULT NULL,"
        . "`date_end` datetime DEFAULT NULL,"
        . "`is_presential` int(1) DEFAULT '0',"
        . "`user_keypad` int(11) DEFAULT '0',"
        . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_hour` datetime DEFAULT '0000-00-00 00:00:00',"
        . "`number_eval` int(11) DEFAULT NULL,"
        . "`progression` int(11) NOT NULL DEFAULT '0',"
        . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
        . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
        $eval = DB::connection('mysql_historic')->select('select * from tb_evaluation_' . $sessionId . ' where id="'.$idEvaluation.'"');
        if($eval && $eval[0])
            return $eval[0];
        else
            return null;
    }

    public function scopeGetNbEvaluations($query, $sessionId, $studentId, $idFabrica){
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_{$sessionId}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_start` datetime DEFAULT NULL,"
        . "`date_end` datetime DEFAULT NULL,"
        . "`is_presential` int(1) DEFAULT '0',"
        . "`user_keypad` int(11) DEFAULT '0',"
        . "`id_lesson` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`date_hour` datetime DEFAULT '0000-00-00 00:00:00',"
        . "`number_eval` int(11) DEFAULT NULL,"
        . "`progression` int(11) NOT NULL DEFAULT '0',"
        . "`note` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',"
        . "`status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
        $eval = DB::connection('mysql_historic')->select('select COUNT(id) as nb_evals from tb_evaluation_' . $sessionId . ' where user_id="'.$studentId.'" AND id_lesson="'.$idFabrica.'"');
        if($eval && $eval[0])
            return $eval[0]['nb_evals'];
        else
            return 0;
    }
}
