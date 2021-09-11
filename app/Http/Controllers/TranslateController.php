<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranslateModel;
use App\Models\LanguageModel;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        if(count($request->all())!=0){
            $translate = new TranslateModel();
            if($request->input("translation_value")) {
                $translate->translation_value = $request->input("translation_value");
            }
            if($request->input("translation_string")) {
                $translate->translation_string = $request->input("translation_string");
            }
            if($request->input("selectLanguage")) {
                $translate->language_id = $request->input("selectLanguage");
            }
            $translate->save();
            $language = LanguageModel::where("language_id", $translate->language_id)->first()->language_iso;
        }
        return response()->json(
            ["result"=>$translate, "lang_iso"=>$language]
        );
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(count($request->all())!=0) {
            $translate = TranslateModel::find($id)->first();
            if(isset($translate)){
                if($request->input("translation_string")) {
                    $translate->translation_string = $request->input("translation_string");
                }
                if($request->input("translation_value")) {
                    $translate->translation_value = $request->input("translation_value");
                }
                if($request->input("selectLanguage")) {
                    $translate->language_id = $request->input("selectLanguage");
                }
                $translate->update();
                $language = LanguageModel::where("language_id", $translate->language_id)->first()->language_iso;
            }
        }

        return response()->json(
            ["result"=>$translate, "lang_iso"=>$language]
        );
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
}
