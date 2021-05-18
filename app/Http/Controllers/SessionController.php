<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('session');
    }

    // public function getSessionFromUser(Request $request, $id)
    // {
    //     print_r($request);exit;
    //     return response('findSession', 200);
    // }
}
