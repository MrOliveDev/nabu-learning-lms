<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EvaluationQuestions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'id_evaluation', 'id_q', 'id_group', 'name_group', 'num_order', 'title', 'option_serialize', 'expected_response', 'reply', 'points'
    ];

    protected $table = 'evaluation';

    public $timestamps = false;

    public function scopeGetQuestionDetails($query, $sessionId, $idEvaluation){
        DB::connection('mysql_historic')->unprepared("CREATE TABLE IF NOT EXISTS `tb_evaluation_question_{$sessionId}` ("
        . "`id` int(11) NOT NULL AUTO_INCREMENT,"
        . "`id_evaluation` int(11) DEFAULT NULL,"
        . "`id_q` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`id_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`name_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`num_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'order of question',"
        . "`title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`option_serialize` text COLLATE utf8_unicode_ci,"
        . "`expected_response` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`reply` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "`points` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,"
        . "PRIMARY KEY (id) "
      . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
        $eval = DB::connection('mysql_historic')->select('select * from tb_evaluation_question_' . $sessionId . ' where id_evaluation="'.$idEvaluation.'"');
        if($eval)
            return $eval;
        else
            return array();
    }
}
