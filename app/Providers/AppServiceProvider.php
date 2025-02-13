<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\core\Language;
use App\Models\LanguageModel;
use App\Models\InterfaceCfgModel;
use App\Models\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $translation = new Language;
        view()->share('translation', $translation);
        $languageModel = LanguageModel::all();
        view()->share('screen_language', $languageModel);
        $interfaceCfg = InterfaceCfgModel::get_interface_color_byuser(1);
        view()->share('interfaceCfg', $interfaceCfg);
        $clients = User::where('type', "<", "2")->get();
        view()->share('clients', $clients);
        // foreach ($language as $languages) {
        // }exit;
    }
}
