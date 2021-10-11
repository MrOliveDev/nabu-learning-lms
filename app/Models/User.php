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
        'permission_id',
        'auto_generate'
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

    /**
     * Get clients that has type 1 from tb_users
     */
    public function scopeGet_clients($query)
    {
        $clients = $query->where('type', 1)->get();
        return $clients;
    }

    /**
     * Get info that contained to user for student page with interface info, language info and company info.
     */
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
            'tb_languages.language_iso as language_iso',
            // 'tb_position.name as position',
            'tb_companies.name as company_name'
        )
            ->leftjoin('tb_interface_config', 'tb_interface_config.id', '=', 'tb_users.id_config')
            ->leftjoin('tb_languages', 'tb_users.lang', '=', 'tb_languages.language_id')
            ->leftjoin('tb_companies', 'tb_users.company', '=', 'tb_companies.id');
            // ->leftjoin('tb_position', 'tb_users.function', '=', 'tb_position.id')
            // ->where("tb_users.id_creator", session("client"))
            if(session("user_type")!=2){
                $result = $result->where('tb_users.id', $id);
            }
            $result = $result->first();
        return $result;
    }

    /**
     * Get the user info that has any specified type.
     */
    public function scopeGetUserPageInfo($query, $type)
    {
        $client = session("client");
        $current_type = User::find(session("client"))->type;
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
            switch ($type) {
                case '2':
                    $result = $result
                    ->where('tb_users.type', $type)
                    ->where("tb_users.id_creator", $client);

                    break;
                    
                case '3':
                    $result = $result
                    ->where('tb_users.type', $type)
                    ->where("tb_users.id_creator", $client);
                    break;
                    
                case '4':
                    $result = $result
                    ->leftjoin("tb_users as ctb", 'tb_users.id', '=', 'ctb.id_creator')
                    ->where('tb_users.type', $type);

                    if($current_type == 0) {
                        $result = $result
                        ->where(function($query){
                            // var_dump(auth()->user()->id);exit;
                            return $query->where('tb_users.id_creator', auth()->user()->id)
                                    ->orWhere('ctb.id_creator', '=', auth()->user()->id);
                        });
                    } else {
                        $result = $result
                        ->where(function($query) use ($client){
                            return $query->where('tb_users.id_creator', session("client"))
                                    ->orWhere('ctb.id_creator', '=', session("client"));
                        });
                    }

                    break;
                
                default:

                break;
            }

        }
        $result = $result->get();
        return $result;
    }

    /**
     * Add user for session
     * 
     * @param int $id: session id
     * @param array $data:user items
     */
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

    /**
     * Get user data from any group
     * 
     * @param int @id:group id
     */
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

    /**
     * Get user id from group id
     */
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

    /**
     * Get Client data
     */
    public function scopeGetClients($query) {
        $clients = $query->where('type', '1')->get()->toArray();
        return $clients;
    }

    /**
     * Get user data that created by client
     */
    public function scopeGetUserByClient($query) {
        $users = $query->where('id_creator', session("client"))->get();
        return $users;
    }

    /**
     * Get client info with language & interface info
     */
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

    public function scopeGet_members($query) {
        $memberlist = $query->where("id_creator", session("client"))->get("id")->toArray();
        $memberArray = [];
        foreach($memberlist as $member) {
            if(isset($member['id']))
            array_push($memberArray, $member['id']);
        }
        array_push($memberArray, session("client"));
        // var_dump($memberArray);exit;
        return $memberArray;
    }
}
