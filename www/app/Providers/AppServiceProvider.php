<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Form::macro('fieldErr', function($field_name = ''){
            return new HtmlString("<p class=\"has-error help-block\" v-if=\"form.errors.has('$field_name')\" v-text=\"form.errors.get('$field_name')\"></p>");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
