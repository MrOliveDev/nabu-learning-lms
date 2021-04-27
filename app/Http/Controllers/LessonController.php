<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
class LessonController extends Controller
{
    public function index()
    {
        $lessonCfg = InterfaceCfgModel::get_selected_data('lessons');
        $trainingcourseCfg = InterfaceCfgModel::get_selected_data('TRAINING COURSES');
        return view('lesson', ['lessonCfg'=>$lessonCfg, 'trainingcourseCfg'=>$trainingcourseCfg]);
    }
}
