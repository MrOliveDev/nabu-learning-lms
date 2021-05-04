<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        "email",
        "lang",
        "pack",
        "state",
        "function",
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

    public function scopeGet_clientsInfo($query)
    {
        $clientlist = $query->select(
            'tb_users.*',
            'tb_interface_config.interface_color as interface_color',
            'tb_interface_config.interface_icon as interface_icon'
        )->leftjoin('tb_interface_config', 'tb_interface_config.admin_id', '=', 'tb_users.id')
            ->where('type', '=', 1)->get();

        return $clientlist;
    }
}
