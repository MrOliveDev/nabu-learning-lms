<?php

namespace App\Http\Controllers;

use App\Models\SiteSettingModel;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
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
     * @param  \App\Models\SiteSettingModel  $siteSettingModel
     * @return \Illuminate\Http\Response
     */
    public function show(SiteSettingModel $siteSettingModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteSettingModel  $siteSettingModel
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSettingModel $siteSettingModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteSettingModel  $siteSettingModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSettingModel $siteSettingModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteSettingModel  $siteSettingModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSettingModel $siteSettingModel)
    {
        //
    }

    public function updateDoubleLogin(Request $request) {
        $flag = $request->input("flag");
        $dbLoginSetting = SiteSettingModel::where("name", "doublelogin")->first();
        $dbLoginSetting->value = $flag;
        $dbLoginSetting->update();
        return response()->json(["success"=> true]);
    }
}
