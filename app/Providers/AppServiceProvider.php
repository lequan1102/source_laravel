<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Backend\Entities\Category;
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
        view()->composer('*', function ($view) {
            $data = Category::orderBy('id', 'DESC')->get();
            $view->with('category_footer', $data);
        });
    }
}
