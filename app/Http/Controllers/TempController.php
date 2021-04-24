<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempController extends Controller
{
    //
    public function index()
    {
        // echo env('ASSET_URL');
        return view('temp');
    }
}
