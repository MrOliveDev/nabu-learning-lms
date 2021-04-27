<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\core\Language;
use App\Models\LanguageModel;
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
        view()->share('language', $languageModel);
    }
}
