<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranslateModel;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        // InterfaceCfgModel::where('tag_name', '=', '')
        $this->sidebarData = TranslateModel::where('page_category_id', 'sidebar');
    }
    public function index()
    {
        return view('superadminsettings', ['sidebardata'=>$this->sidebarData]);
    }
}
