<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = DB::table('tb_template_html5_edit')->get();

        return view('template', ['templates' => $templates]);
    }
}
