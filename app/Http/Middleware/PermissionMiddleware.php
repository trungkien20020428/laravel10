<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // hash map for api router ??
        $user = $request->user();
        $path = $request->decodedPath();
        $permissions = json_decode(Redis::get('user_permission_'.$user['id']));

        Log::debug($permissions);
        foreach ($permissions as $permission) {
            if (!strcmp($permission,$path)){
                return $next($request);
            }
        }


        return redirect('/');
    }
}
