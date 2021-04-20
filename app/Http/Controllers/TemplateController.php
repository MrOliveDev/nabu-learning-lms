<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateModel;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = TemplateModel::all();

        return view('template', ['templates' => $templates]);
    }
}
