<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempController extends Controller
{
    //
    public function index()
    {
        // echo asset('template-editor');
        return view('temp');
    }
}
