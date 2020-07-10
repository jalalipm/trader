<?php

namespace App\Http\Middleware;

use App\Helpers\MessageHelper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

//        if( $request->is('api/*')){
//            return MessageHelper::instance()->sendError('Unauthorized',[],401);
//        }else{
//            return route('login');
//        }

        if ($request->wantsJson()) {
            return MessageHelper::instance()->sendError('Unauthorized',[],401);
        } else {
            return route('login');
        }
//        if (! $request->expectsJson()) {
//            return route('login');
//        }
    }
}
