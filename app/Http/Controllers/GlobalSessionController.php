<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalSessionController extends Controller
{
    //
    public function setToPageSetting(Request $request) {
        session(["routeOfUser"=> $request->post("data")]);
    }
}
