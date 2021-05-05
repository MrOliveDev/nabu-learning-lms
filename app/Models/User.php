<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigModel;
// use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "login",
        "first_name",
        "last_name",
        "password",
        "contact_info",
        "company",
        "lang",
        "status",
        "pack",
        "function",
        "id_config",
        "type"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'tb_users';

    public function scopeGet_clients($query)
    {
        $clients = $query->where('type', 1)->get();
        return $clients;
    }

    public function scopeCreate_admin_table($query, $id)
    {
        DB::statement("DROP TABLE IF EXISTS `tb_admin_" . $id . "`;
        CREATE TABLE `tb_admin_" . $id . "` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `lang` int(11) NOT NULL DEFAULT 1,
          `contact_info` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `status` tinyint(4) NOT NULL DEFAULT 1,
          `function` int(1) NOT NULL DEFAULT 1,
          `type` tinyint(1) NOT NULL DEFAULT 0,
          `id_creator` int(11) DEFAULT 1,
          `id_config` int(11) NOT NULL DEFAULT 1,
          `pack` int(11) NOT NULL DEFAULT 0,
          `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `change_pw` tinyint(1) NOT NULL DEFAULT 0,
          `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
          `limit_date` date DEFAULT NULL COMMENT 'date or validity for the access to the lessons',
          `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `email_verified_at` timestamp NULL DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          `last_session` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=6804 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
    }

    public function scopeDrop_admin_table($query, $id)
    {
        DB::statement("DROP TABLE IF EXISTS `tb_admin_" . $id . "`;");
    }

    public function scopeGet_clientsInfo($query)
    {
        $clientlist = $query
            ->select(
                'tb_users.*',
                'tb_interface_config.interface_color as interface_color',
                'tb_interface_config.interface_icon as interface_icon',
                'tb_interface_config.id as interface_id',
                'tb_config.config as config'
            )
            ->leftjoin('tb_interface_config', 'tb_interface_config.id', '=', 'tb_users.id_config')
            ->leftjoin('tb_config', 'tb_config.id', "=", 'tb_users.id_config')
            ->where('type', '=', 1)->get();

        return $clientlist;
    }
}
