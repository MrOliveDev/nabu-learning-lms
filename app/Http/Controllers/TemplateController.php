<?php

namespace App\Http\Controllers;

use App\Models\TemplateModel;
use App\Models\TemplatePublishModel;
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
        $templates = TemplateModel::getTemplateByClient();
        // dd($templates);exit;
        $sessions = SessionModel::getSessionPageInfo();
        $trainings = TrainingsModel::getTrainingByClient();
        $companies = CompanyModel::getCompanyByClient();

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
        if ($request->post("template_name") != NULL) {
            $template->name = $request->post("template_name");
        } else {
            $template->name = '';
        }
        if ($request->post("template_name") != NULL) {
            $template->code = $request->post("template_name");
        } else {
            $template->code = '';
        }
        if ($request->post("template_description") != NULL) {
            $template->description = $request->post("template_description");
        } else {
            $template->description = '';
        }
        if ($request->post("template-status-icon") != NULL) {
            $template->status = $request->post("template-status-icon");
        } else {
            $template->status = 1;
        }
        if (session("user_type") !== 0) {
            $template->id_creator = session("user_id");
        } else {
            $template->id_creator = session("client");
        }
        $template->alpha_id = md5(uniqid());
        $defaultTemplate = TemplateModel::where("default_user", session("client"))->first();
        if($defaultTemplate){
            $defaultPublished = TemplatePublishModel::where('alpha_id', $defaultTemplate->alpha_id)->first();
            if($defaultPublished)
                $template->style = $defaultPublished->style;
            else
                $template->style = TemplatePublishModel::first() ? TemplatePublishModel::first()->style : '';
        } else {
            $template->style = TemplatePublishModel::first() ? TemplatePublishModel::first()->style : '';
        }
        $template->published = TemplateModel::first() ? TemplateModel::first()->published : '';
        $template->save();
        
        $templatePublish = new TemplatePublishModel();
        $templatePublish->alpha_id = $template->alpha_id;
        if ($request->post("template_name") != NULL) {
            $templatePublish->name = $request->post("template_name");
        } else {
            $templatePublish->name = '';
        }
        if ($request->post("template_name") != NULL) {
            $templatePublish->code = $request->post("template_name");
        } else {
            $templatePublish->code = '';
        }
        if (session("user_type") !== 0) {
            $templatePublish->id_creator = session("user_id");
        } else {
            $templatePublish->id_creator = session("client");
        }
        $templatePublish->style = '';
        $templatePublish->save();
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

    // public function publishTemplate($request) {
    //     if($request->post("id")!=null) {
    //         $template = TemplateModel::find($request->post("template_name"));
    //         if($template) {
    //             $templatePublish = TemplatePublishModel::where("alpha_id", $template->alpha_id);
    //             if($templatePublish) {
    //                 $templatePublish->style = $template->style;
    //                 $templatePublish->update();
    //                 return response()->json(true);
    //             }
    //         }
    //     }
        
    //     return response()->json(false);
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TemplateModel  $templateModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // print_r($request->all());
        $template = TemplateModel::find($id);

        if ($request->post('template_name') != NULL) {
            $template->name = $request->post("template_name");
            $template->code = $request->post("template_name");
        }
        if ($request->post('template_name') != NULL) {
            $template->description = $request->post('template_description');
        }
        if ($request->post('template_name') != NULL) {
            $template->status = $request->post('template-status-icon');
        }
        if ($request->post("template-status-icon") != NULL) {
            $template->status = $request->post("template-status-icon");
        } else {
            $template->status = 1;
        }
        $template->update();
        // print_r($template);exit;
        $arrTemplate = $template->toArray();
        $arrTemplate['style'] = '';
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
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $reqData = $request->data;
        if ($reqData != NULL) {
            // var_dump($reqData);
            $arrData = json_decode($reqData);
            if ($arrData != NULL) {
                $id = (int)$arrData->id;
                $data = $arrData->data;
                $template = (int)$arrData->template;

                switch ($data) {
                    case "company":
                        $company = CompanyModel::find($id);
                        if ($company != NULL) {
                            $company->templateformation = $template;
                            $company->update();
                            return response()->json(["data" => $company->templateformation]); //
                        }
                        break;
                    case "training":
                        $training = TrainingsModel::find($id);
                        if ($training != NULL) {
                            $training->templateformation = $template;
                            $training->update();
                            // var_dump($training->templateformation);
                            return response()->json(["data" => "ad"]); //
                        }
                        break;
                    case "session":
                        $session = SessionModel::find($id);
                        if ($session != NULL) {
                            $session->templateformation = $template;
                            $session->update();
                            return response()->json(["data" => $session->templateformation]); //
                        }
                        break;
                    default:
                        return false;
                        break;
                }
            }
        }
    }

    public function getTemplateFromCate(Request $request)
    {

        $data_id = $request->data;
        if ($data_id != NULL) {
            $arrData = explode("_", $data_id);
            if (is_array($arrData)) {
                $id = (int)$arrData[1];
                $data = $arrData[0];
                switch ($data) {
                    case "company":
                        $company = CompanyModel::find($id);
                        if ($company != NULL) {
                            if ($company->templateformation != NULL) {
                                $template = TemplateModel::find($company->templateformation);
                                if ($template != NULL) {
                                    return response()->json(["data" => $template]);
                                }
                            }
                        }
                        return false;
                        break;
                    case "training":
                        $training = TrainingsModel::find($id);
                        if ($training != NULL) {
                            if ($training->templateformation != NULL) {
                                $template = TemplateModel::find($training->templateformation);
                                if ($template != NULL) {
                                    //  var_dump(->toArray());
                                    return response()->json(["data" => $template]);
                                }
                            }
                        }
                        return false;
                        break;
                    case "session":
                        $session = SessionModel::find($id);
                        if ($session != NULL) {
                            if ($session->templateformation != NULL) {
                                $template = TemplateModel::find($session->templateformation);
                                if ($template != NULL) {
                                    return response()->json(["data" => $template]);
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
        }
    }

    public function templateDuplicate(Request $request)
    {
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
