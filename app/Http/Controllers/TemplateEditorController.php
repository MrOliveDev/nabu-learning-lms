<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateEditorController extends Controller
{
    //
    public function index()
    {
        // echo asset('template-editor');
        return view('template_editor');
    }
}
