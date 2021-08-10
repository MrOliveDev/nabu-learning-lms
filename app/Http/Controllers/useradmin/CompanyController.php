<?php

namespace App\Http\Controllers\useradmin;

use App\Http\Controllers\Controller;
use App\Models\CompanyModel;
use App\Models\InterfaceCfgModel;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        // print_r($request->input());exit;

        $company = new CompanyModel();
        if ($request->post("category_name") != NULL) {
            $company->name = $request->input('category_name');
        }
        if ($request->post("category_description") != NULL) {
            $company->description = $request->input('category_description');
        }
        if ($request->post("name") != NULL) {
            $company->name = $request->input('name');
        }
        if ($request->post("description") != NULL) {
            $company->description = $request->input('description');
        }
        if (auth()->user()->type !== 0) {
            $company->id_creator = auth()->user()->id;
        } else {
            $company->id_creator = session("client");
        }
        $company->status = 1;
        $company->save();
        return response()->json($company);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyModel  $companyModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $company = CompanyModel::find($id);

        return response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyModel  $companyModel
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyModel $companyModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyModel  $companyModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = CompanyModel::find($id);
        // print_r($request->input());
        // exit;
        if ($request->post('category_name') != NULL) {
            $company->name = $request->input('category_name');
        }
        if ($request->post('category_description') != NULL) {
            $company->description = $request->input('category_description');
        }
        if ($request->post('name') != NULL) {
            $company->name = $request->input('name');
        }
        if ($request->post('description') != NULL) {
            $company->description = $request->input('description');
        }

        $company->update();

        return response()->json($company);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyModel  $companyModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $company = CompanyModel::find($id);

        $company->delete();

        return response('successfully deleted', 200);
    }
}
