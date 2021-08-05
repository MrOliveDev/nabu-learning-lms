<?php

namespace App\Http\Controllers;

use App\Models\LanguageModel;
use App\Models\TranslateModel;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Language;

class LanguageManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response\asdf
     */
    public function index()
    {
        //
        $languages = LanguageModel::all();

        print_r($languages);
        exit();
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
        $language = LanguageModel::create([
            'language_name' => $request->input('language_name')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LanguageModel  $languageModel
     * @return \Illuminate\Http\Response
     */
    public function show($language_id)
    {
        //
        $translate = TranslateModel::where("langauge_id", $language_id)
        ->get();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LanguageModel  $languageModel
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
     * @param  \App\Models\LanguageModel  $languageModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $language = LanguageModel::find('language_id', $id);
        $language->language_name = $request->input("language_name");
        $language->update();
        $translate = TranslateModel::where('translate_id', $language->language_id)
            ->where('translate_string', $request->input('translate_string'))->first();
        $translate->translate_value = $request->input('translate_value');
        $translate->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LanguageModel  $languageModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $language = LanguageModel::find($id);
        $language->delete();
    }
}
