<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigModel;
use App\Models\InterfaceCfgModel;
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
        "change_pw",
        "type",
        'expired_date',
        'permission_id'
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

    public function scopeGetUserPageInfoFromId($query, $id)
    {
        if(session("client")!=null){
            $user_table = session("client");
        }
        
        $result = $query->select(
            'tb_users.*',
            'tb_interface_config.interface_color as interface_color',
            'tb_interface_config.interface_icon as interface_icon',
            'tb_interface_config.id as interface_id',
            'tb_languages.language_iso as language_iso'
            // 'tb_position.name as position',
            // 'tb_companies.name as companies'
        )
            ->leftjoin('tb_interface_config', 'tb_interface_config.id', '=', 'tb_users.id_config')
            ->leftjoin('tb_languages', 'tb_users.lang', '=', 'tb_languages.language_id')
            // ->leftjoin('tb_companies', 'tb_users.company', '=', 'tb_companies.id')
            // ->leftjoin('tb_position', 'tb_users.function', '=', 'tb_position.id')
            ->where("tb_users.id_creator", session("client"))
            ->where('tb_users.id', $id)
            ->first();
        return $result;
    }

    public function scopeGetUserPageInfo($query, $type)
    {
        $client = session("client");
        $result = $query->select(
            'tb_users.*',
            'tb_interface_config.interface_color as interface_color',
            'tb_interface_config.interface_icon as interface_icon',
            'tb_interface_config.id as interface_id',
            'tb_languages.language_iso as language_iso'
        )
        ->leftjoin('tb_interface_config', 'tb_interface_config.id', '=', 'tb_users.id_config')
        ->leftjoin('tb_languages', 'tb_users.lang', 'tb_languages.language_id');
        if(session("client")!=null) {
            $result = $result
            ->where("tb_users.id_creator", $client);
        } elseif(session("limited")!=null) {
            $result = $result
            ->where("tb_users.id_creator", $client);
        }
        $result = $result
        ->where('tb_users.type', $type)
        ->get();
        return $result;
    }

    public function scopeAddUserSession($query, $id, $data)
    {
        $result = $query->find($id);
        if (isset($result->linked_session)) {
            $linked_session = json_decode($result->linked_session);

            $diff = array_diff($linked_session, array($data));
            if (count($diff) != count($linked_session)) {
                array_push($linked_session, $data);
            }
            $result->linked_session = $linked_session;
            $result->update();
            return true;
        }
        return false;
    }

    public function scopeGetUserFromGroup($query, $id)
    {
        $result = $query->select("tb_users.*")
        ->leftjoin('tb_groups', function ($join) {
            $join->on('tb_users.linked_groups', 'like', DB::raw("CONCAT('%_', tb_groups.id, '_%')"));
            $join->orOn('tb_users.linked_groups', 'like', DB::raw("CONCAT(tb_groups.id, '_%')"));
            $join->orOn('tb_users.linked_groups', 'like', DB::raw("CONCAT('%_', tb_groups.id)"));
        })
        ->where('tb_users.id_creator', session("client"))
        ->where('tb_groups.id', '=', $id)->get();
        // print_r($result->toArray());
        return $result->toArray();
    }

    public function scopeGetUserIDFromGroup($query, $id)
    {
        $result = $query->select("tb_users.id")
        ->leftjoin('tb_groups', function ($join) {
            $join->on('tb_users.linked_groups', 'like', DB::raw("CONCAT('%_', tb_groups.id, '_%')"));
            $join->orOn('tb_users.linked_groups', 'like', DB::raw("CONCAT(tb_groups.id, '_%')"));
            $join->orOn('tb_users.linked_groups', 'like', DB::raw("CONCAT('%_', tb_groups.id)"));
        })
        ->where("tb_users.id_creator", session("client"))
        ->where('tb_groups.id', '=', $id)->get();
        // print_r($result->toArray());
        return $result;
    }

    public function scopeGetClients($query) {
        $clients = $query->where('type', '1')->get()->toArray();
        return $clients;
    }

    public function scopeGetUserByClient($query) {
        $users = $query->where('id_creator', session("client"))->get();
        return $users;
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
