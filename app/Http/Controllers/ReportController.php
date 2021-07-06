<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ReportsModel;
use App\Models\ReportTemplateModel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = ReportTemplateModel::get();
        return view('report.view')->with('templates', $templates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Return server-side rendered table list.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function getReportList(Request $request){
        $columns = array( 
            0 =>'session', 
            1 =>'filename',
            2 =>'type',
            3 =>'detail',
            4 =>'created_time'
        );
        $totalData = ReportsModel::count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $handler = new ReportsModel;
        $handler = $handler->leftjoin('tb_session', "tb_session.id", "=", "tb_reports.sessionId");

        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $reports = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_reports.id as id',
                        'tb_session.description as session',
                        'tb_reports.filename as filename',
                        'tb_reports.type as type',
                        'tb_reports.detail as detail',
                        'tb_reports.created_time as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $reports =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_reports.id','LIKE',"%{$search}%")
                            ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.type', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.detail', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.created_time', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_reports.id as id',
                                'tb_session.description as session',
                                'tb_reports.filename as filename',
                                'tb_reports.type as type',
                                'tb_reports.detail as detail',
                                'tb_reports.created_time as created_time',
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                                $q->where('tb_reports.id','LIKE',"%{$search}%")
                                ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.type', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.detail', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.created_time', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($reports))
        {
            foreach ($reports as $report)
            {
                $nestedData['id'] = $report->id;
                $nestedData['session'] = $report->session;
                $nestedData['filename'] = $report->filename;
                $nestedData['type'] = $report->type;
                $nestedData['detail'] = $report->detail;
                $nestedData['created_time'] = $report->created_time;
                
                $nestedData['actions'] = "
                <div class='text-center'>
                    <button type='button' class='js-swal-confirm btn btn-danger' onclick='delCompany(this,{$nestedData['id']})'>
                        <i class='fa fa-trash'></i>
                    </button>
                </div>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );
        echo json_encode($json_data);
    }

    /**
     * Return model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getTemplateData(Request $request){
        if(!empty($request['id'])){
            $template = ReportTemplateModel::where('id', $request['id'])->first();
            if($template)
                return response()->json(["success" => true, "data" => $template->data, "name" => $template->name]);
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Save model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function saveTemplateData(Request $request){
        if(!empty($request['id']) && !empty($request['name'])){
            $template = ReportTemplateModel::where('id', $request['id'])->first();
            if($template){
                $template->name = $request['name'];
                $template->data = $request['data'];
                $template->save();
                return response()->json(["success" => true]);
            }
            else{
                $template = ReportTemplateModel::create([
                    'name' => $request['name'],
                    'data' => $request['data'],
                    'created_time' => gmdate("Y-m-d\TH:i:s", time())
                ]);
                return response()->json(["success" => true, "id" => $template->id]);
            }
        } else
            return response()->json(["success" => false, "message" => "Missing id or name."]);
    }

    /**
     * Delete model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function delTemplate(Request $request){
        if(!empty($request['id'])){
            $template = ReportTemplateModel::where('id', $request['id'])->first();
            if($template){
                $template->delete();
                return response()->json(["success" => true]);
            }
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }
}
