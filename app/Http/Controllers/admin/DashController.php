<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function index()
    {
        if (auth()->user()->type === 0) {
            return view('admindash');
        } else {
            // var_dump('abc'.auth()->user()->type);
            return redirect('dash');
        }
    }
}
