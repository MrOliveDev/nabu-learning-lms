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
            $permissionItem = PermissionModel::where('id', session("user_type"))->get();
        } else {
            $permissionItem = PermissionModel::where('id', $user_permission)->get();
        }
        // $permission = $permissionItem[0]->permission!=null ? json_decode($permissionItem[0]->permission) : null;
        if($permissionItem[0]->permission!=null) {
            session(['permission'=>json_decode($permissionItem[0]->permission)]);
        } else {
            session(['permission'=>null]);
        }
        return true;
    }

    public function switchClient(Request $request) {
        $id = $request->post("id");
        session(['client'=>$id]);
        return url()->previous();
    }
}
