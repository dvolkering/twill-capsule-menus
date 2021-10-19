<?php

namespace App\Twill\Capsules\Menus\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->has('menu_id') && !session('currentMenuAdmin')) {
            return redirect()->route('admin.menus.index');
        }
        if($request->has('menu_id')) {
            session()->put('currentMenuAdmin', $request->get('menu_id'));
        }

        return $next($request);
    }
}
