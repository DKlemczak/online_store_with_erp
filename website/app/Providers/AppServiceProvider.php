<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Models\Products_Group;

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
        if (!\App::runningInConsole())
        {
            $GlobalNavbarGroups = Products_Group::where('on_navbar', 1)->whereNull('group_id')->get();

            View::share([
                'GlobalNavbarGroups' => $GlobalNavbarGroups
            ]);
        }
    }
}
