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
        $template = new TemplateModel();
        if($request->post("template_name")!=NULL){
            $template->name = $request->post("template_name");
        } else {
            $template->name='';
        }
            if($request->post("template_name")!=NULL){
                $template->code = $request->post("template_name");
            } else {
                $template->code='';
            }
            if($request->post("template_description")!=NULL){
                $template->description = $request->post("template_description");
            } else {
                $template->description='';
            }
            if($request->post("template-status-icon")!=NULL){
                $template->status = $request->post("template-status-icon");
            } else {
                $template->status=1;
            }
            $template->alpha_id = md5(uniqid());
            $template->id_creator = TemplateModel::first()->id_creator;
            $template->style = TemplateModel::first()->style;
            $template->published = TemplateModel::first()->published;
        $template->save();
        return response()->json($template);
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

        if($request->post('template_name')!=NULL){
        $template->name = $request->post("template_name");
        $template->code = $request->post("template_name");
        }
        if($request->post('template_name')!=NULL){
        $template->description = $request->post('template_description');
        }
        if($request->post('template_name')!=NULL){
        $template->status = $request->post('template-status-icon');
        }
        if($request->post("template-status-icon")!=NULL){
            $template->status = $request->post("template-status-icon");
        } else {
            $template->status=1;
        }
        $arrTemplate = $template->toArray();
        $arrTemplate['style']='';
        return response()->json($arrTemplate);
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
                if($company!=NULL){
                    $company->templateformation = $request->post('template');
                    return response()->json($company);
                }
                break;
            case "training":
                $training = TrainingsModel::find($request->post('id'));
                if($training!=NULL){
                    $training->templateformation = $request->post('template');
                    return response()->json($training);
                }
                break;
            case "session":
                $session = SessionModel::find($request->post('id'));
                if($session!=NULL){
                    $session->templateformation = $request->post('template');
                    return response()->json($session);
                }
                break;
            default:
            return false;
                break;
        }
    }

    public function getTemplateFromCate(Request $request)
    {
        // print_r(TemplateModel::find(TrainingsModel::find((int)$request->post('id'))->templateformation)); exit;
        switch ($request->post('data')) {
            case "company":
                $company = CompanyModel::find((int)$request->post('id'));
                if($company!=NULL){
                if ($company->templateformation!=NULL) {
                    $template = TemplateModel::find($company->templateformation);
                    if($template!=NULL){
                    return response()->json($template->toArray());
                    }
                }
                }
                return false;
                break;
            case "training":
                $training = TrainingsModel::find((int)$request->post('id'));
                if($training!=NULL){
                if ($training->templateformation!=NULL) {
                    $template = TemplateModel::find($training->templateformation);
                    if($template!=NULL){
                    return response()->json($template->toArray());
                    }
                }
                }
                return false;
                break;
            case "session":
                $session = SessionModel::find((int)$request->post('id'));
                if($session!=NULL){
                if ($session->templateformation !=NULL) {
                    $template = TemplateModel::find($session->templateformation);
                    if($template!=NULL){
                    return response()->json($template->toArray());
                    }
                }
                }
                return false;
                break;
            default:
            return false;
                break;
        }
    }

    public function templateDuplicate(Request $request){
        $template = TemplateModel::find($request->post('id'));
        $copyTemplate = new TemplateModel();
        $copyTemplate->name = $template->name;
        $copyTemplate->code = $template->code;
        $copyTemplate->id_creator = $template->id_creator;
        $copyTemplate->style = $template->style;
        $copyTemplate->published = $template->published;
        $copyTemplate->status = $template->status;
        $copyTemplate->description = $template->description;
        $copyTemplate->alpha_id = md5(uniqid());
        $copyTemplate->save();
        return response()->json($copyTemplate);
    }
}
