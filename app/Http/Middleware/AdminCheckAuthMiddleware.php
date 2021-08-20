<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class AdminCheckAuthMiddleware
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
        $isAuth = Session::get('isAuth');
		$routeName = $request->route()->getName();

		if (!$isAuth && $routeName != 'admin.index') {
			return redirect()->route('admin.index');
		} elseif ($isAuth && $routeName == 'admin.index') {
			return redirect()->route('admin.home');
		}
        return $next($request);
    }
}
