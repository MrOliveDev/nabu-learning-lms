<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
class StudentController extends Controller
{
    public function index()
    {
        $studentsCfg = InterfaceCfgModel::get_selected_data('STUDENTS');
        $teachersCfg = InterfaceCfgModel::get_selected_data('TEACHERS');
        $authorsCfg = InterfaceCfgModel::get_selected_data('AUTHORS');
        $companiesCfg = InterfaceCfgModel::get_selected_data('COMPANIES');
        $groupsCfg = InterfaceCfgModel::get_selected_data('groups');
        return view('student', ['studentsCfg'=>$studentsCfg,
         'teachersCfg'=>$teachersCfg,
         'authorsCfg'=>$authorsCfg,
         'companiesCfg'=>$companiesCfg,
         'groupsCfg'=>$groupsCfg,
         ]);
    }
}
