<?php

namespace App\Http\Controllers;

use App\Models\CompanyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateModel;
use GrahamCampbell\ResultType\Success;
use App\Models\InterfaceCfgModel;
use App\Models\SessionModel;
use App\Models\TrainingsModel;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = TemplateModel::all();
        $sessions = SessionModel::all();
        $trainings = TrainingsModel::all();
        $companies = CompanyModel::all();

        return view('template', compact('templates', 'sessions', 'trainings', 'companies'));
    }

    public function update(Request $request)
    {
        return TemplateModel::where('id', $request->id)
            ->update(['name' => $request->name, 'code' => $request->name]);
    }

    public function add(Request $request)
    {
        return TemplateModel::create([
            'name' => $request->name,
            'code' => $request->name,
            "alpha_id" => md5(uniqid()),
            "id_creator" => "1",
            "style" =>"",
            "published" => "1"
        ]);
    }

    public function delete(Request $request)
    {
        $result = TemplateModel::where("id", $request->id)
        ->delete([]);
        return response()->json(["success" =>$result]);
    }
}
