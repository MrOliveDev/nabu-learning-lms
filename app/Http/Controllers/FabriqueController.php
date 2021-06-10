<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FabriqueController extends Controller
{
    //
    public function index()
    {
        return view('fabrique_editor');
    }
}
