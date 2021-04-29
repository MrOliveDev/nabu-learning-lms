<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
class LessonController extends Controller
{
    public function index()
    {
        return view('lesson');
    }
}
