<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranslateModel;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        // InterfaceCfgModel::where('tag_name', '=', '')
        $this->sidebarData = TranslateModel::where('page_category_id', 'sidebar');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $password = base64_decode(auth()->user()->password);
        return view('changepassword')->with(compact('password'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changePassword(Request $request) {
        $authed_user = User::find(session("user_id"));

        if($authed_user!=null){
            $authed_user->password = base64_encode($request->post("new_password"));

            $authed_user->update();
            // return redirect()->route('changepassword', ['success' => 1]);
            return redirect("/changepassword")->with("success", "Change password successed!");
        }
        
        // return redirect()->route('changepassword', ['success' => 0]);
        return redirect("/changepassword")->with("success", "");
    }
}

