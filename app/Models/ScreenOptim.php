<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScreenOptim extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_screen_optim', 'id_fabrique_screen_optim', 'id_curso_screen_optim', 'id_user_screen_optim', 'progress_screen_optim', 'last_date_screen_optim', 'first_eval_id_screen_optim', 'last_eval_id_screen_optim'
    ];

    protected $table = 'tb_screen_optim';

    public $timestamps = false;

    public function scopeGetScreenOptim($query, $sessionId, $studentId, $idFabrica){
        DB::connection('mysql_reports')->unprepared('CREATE TABLE IF NOT EXISTS `tb_screen_optim_'.$sessionId.'` (
            `id_screen_optim` int(11) NOT NULL,
            `id_fabrique_screen_optim` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
            `id_curso_screen_optim` int(11) NOT NULL,
            `id_user_screen_optim` int(11) NOT NULL,
            `progress_details_screen_optim` text COLLATE utf8_unicode_ci NOT NULL,
            `progress_screen_optim` float(5,2) NOT NULL,
            `last_date_screen_optim` datetime NOT NULL,
            `first_eval_id_screen_optim` int(11) NOT NULL,
            `last_eval_id_screen_optim` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ');
        $optim = DB::connection('mysql_reports')->select('select * from tb_screen_optim_' . $sessionId . ' where id_user_screen_optim="'.$studentId.'" AND id_fabrique_screen_optim="'.$idFabrica.'"');
        if($optim && $optim[0])
            return $optim[0];
        else
            return null;
	}
}
