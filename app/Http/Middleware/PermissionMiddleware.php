<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an middleware role config
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // hash map for api router ??
        $user = $request->user();
        $path = $request->decodedPath();
        $permissions = Redis::get('user_permission_'.$user['id']);

        if (isset($permissions)) {
            foreach ($permissions as $permission) {
                if (!strcmp($permission, $path)) {
                    return $next($request);
                }
            }
        }

        return redirect('/');
    }
}
