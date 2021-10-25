<?php

namespace App\Http\Controllers;
use App\Models\LanguageModel;

class GetLanguageController extends controller
{
    public function getRouteId($datas)
    {
        $product_online_path = env('PRODUCTS_ONLINE_PATH');
        $product_fabrique_path = env('PRODUCTS_FABRIQUE_PATH');
        $paths = array("fabrique" => $product_fabrique_path, 
                    "online" => $product_online_path);
        
        $fabrique = false;
        $online = false;
        $types = array();
        foreach ($paths as $key => $path) {
            $dir = $path . $datas . '/courses/';
            $files = scandir($dir);
            $langs = array();
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $file_arr = explode('_', $file);
                    $iso = $file_arr[2];
                    $course = $file_arr[1];
                    $langs[] = array("id" => LanguageModel::where('language_iso', $iso)->first()->language_id, "iso" => $iso, "course" => $course, "name" => LanguageModel::where("language_iso", $iso)->first()->language_name);
                    if ($key == "fabrique") {
                        $fabrique = true;
                    }
                    if ($key == "online") {
                        $online = true;
                    }
                }
            }
            if (count($langs) > 0) {
                $types[] = $langs;
            }
        }
        $types["fabrique"]  = $fabrique;
        $types["online"]    = $online;
        return $types;
    }
}
