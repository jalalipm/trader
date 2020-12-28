<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }


    public function register()
    {
        // require_once app_path('Helpers/MessageHandler.php');
        // require_once app_path('Helpers/AuthUser.php');
        require_once app_path('Helpers/RequestHandler.php');
    }
}
