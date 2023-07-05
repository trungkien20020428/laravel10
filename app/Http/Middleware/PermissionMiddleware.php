<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an middleware role config.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // hash map for api router ??
        $user = $request->user();
        $path = $request->decodedPath();
        $permissions = json_decode(Redis::get('user_permission_'.$user['id']));

        if (isset($permissions)) {
            foreach ($permissions as $permission) {
                if (!strcmp($permission, $path)) {
                    return $next($request);
                }
            }
        } else {
            // load permission data from database

            $permissions = ['api/calculate'];
            $roles = $user->roles;
            foreach ($roles as $role) {
                $permission = $role->permissions;
                Log::debug($permission);
            }
            //            $permissions = [
            //                'api/calculate',
            //            ];

            Redis::set('user_permission_'.$user['id'], json_encode($permissions));
            Redis::expire('user_permission_'.$user['id'], env('REDIS_TTL'));
            foreach ($permissions as $permission) {
                if (!strcmp($permission, $path)) {
                    return $next($request);
                }
            }
        }

        return redirect('/');
    }
}
