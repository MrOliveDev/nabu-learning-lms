<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateModel;
use GrahamCampbell\ResultType\Success;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = TemplateModel::all();

        return view('template', ['templates' => $templates]);
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
