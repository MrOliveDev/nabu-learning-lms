<?php

namespace App\Http\Controllers;

use App\Models\TemplateModel;
use Illuminate\Http\Request;
use App\Models\TrainingsModel;
use App\Models\CompanyModel;
use App\Models\SessionModel;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = TemplateModel::all();
        $sessions = SessionModel::all();
        $trainings = TrainingsModel::all();
        $companies = CompanyModel::all();

        return view('template', compact('templates', 'sessions', 'trainings', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return TemplateModel::create([
            'name' => $request->post("template_name"),
            'code' => $request->post("template_name"),
            'description' => $request->post("template_description"),
            "alpha_id" => md5(uniqid()),
            "id_creator" => "1",
            "style" => "",
            "published" => "1"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TemplateModel  $templateModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = TemplateModel::find($id);
        return response()->json($template);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TemplateModel  $templateModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        print_r($request->all());
        $template = TemplateModel::find($id);
        $template->update([
            'name' => $request->post("template_name"),
            'code' => $request->post("template_name"),
            'description' => $request->post('template_description'),
            'status' => $request->post('template-status-icon')
        ]);
        return response()->json($template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TemplateModel  $templateModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = TemplateModel::find($id)
            ->delete();
        return response()->json(["success" => $result]);
    }

    public function templateLinkTo(Request $request)
    {
        switch ($request->post('data')) {
            case "company":
                $company = CompanyModel::find($request->post('id'));
                $company->templateformation = $request->post('template');
                break;
            case "training":
                $training = TrainingsModel::find($request->post('id'));
                $training->templateformation = $request->post('template');
                break;
            case "session":
                $session = SessionModel::find($request->post('id'));
                $session->templateformation = $request->post('template');
                break;
            default:
                break;
        }
        return response()->json(['success' => true]);
    }

    public function getTemplateFromCate(Request $request)
    {
        switch ($request->post('data')) {
            case "company":
                $company = CompanyModel::find($request->post('id'));
                if ($company->templateformation) {
                    $template = TemplateModel::find($company->templateformation);
                } else {
                    return NULL;
                }
                break;
            case "training":
                $training = TrainingsModel::find($request->post('id'));
                if ($training->templateformation) {
                    $template = TemplateModel::find($training->templateformation);
                } else {
                    return NULL;
                }
                break;
            case "session":
                $session = SessionModel::find($request->post('id'));
                if ($session->templateformation) {
                    $template = TemplateModel::find($session->templateformation);
                } else {
                    return NULL;
                }
                break;
            default:
                break;
        }
        return response()->json($template);
    }
}
