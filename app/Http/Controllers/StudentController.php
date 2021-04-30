<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
class StudentController extends Controller
{
    public function index()
    {
        return view('student');
    }
}
