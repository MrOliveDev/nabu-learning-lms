<?php

namespace App\Http\Controllers;

use App\Models\PermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermissionModel  $permissionModel
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermissionModel  $permissionModel
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermissionModel  $permissionModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermissionModel  $permissionModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionModel $permissionModel)
    {
        //
    }

    public function setPermission() {
        $user_permission = auth()->user()->permission_id;
        if(!isset($user_permission)) {
            $permission = PermissionModel::getPermission(auth()->user()->type);
        } else {
            $permission = PermissionModel::getPermission($user_permission);
        }

        session(['permission'=>$permission]);
        return true;
    }

    public function switchClient(Request $request) {
        $id = $request->post("id");
        // // if(!Schema::hasTable("tb_admin_".$id)) {
        //     DB::connection('mysql')->unprepared("CREATE TABLE IF NOT EXISTS `tb_admin_".$id."` (
        //         `id` int(11) NOT NULL,
        //         `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        //         `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        //         `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        //         `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        //         `lang` int(11) NOT NULL DEFAULT '1',
        //         `contact_info` longtext COLLATE utf8_unicode_ci,
        //         `status` tinyint(4) NOT NULL DEFAULT '1',
        //         `function` int(11) NOT NULL DEFAULT '1',
        //         `type` tinyint(1) NOT NULL DEFAULT '4',
        //         `id_creator` int(11) DEFAULT '1',
        //         `id_config` int(11) NOT NULL DEFAULT '1',
        //         `pack` int(11) NOT NULL DEFAULT '0',
        //         `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        //         `change_pw` tinyint(1) NOT NULL DEFAULT '0',
        //         `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //         `limit_date` date DEFAULT NULL,
        //         `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
        //         `email_verified_at` timestamp NULL DEFAULT NULL,
        //         `created_at` timestamp NULL DEFAULT NULL,
        //         `updated_at` timestamp NULL DEFAULT NULL,
        //         `last_session` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
        //         `linked_groups` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
        //         `expired_date` date DEFAULT NULL
        //         ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC
        //         ");
        // // }
        // $userByClient = DB::connection('mysql')->unprepared('select *  from tb_admin_'.$id);
        session(['client'=>$id]);
        return url()->previous();
    }
}
