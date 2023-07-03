<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $user = $request->user();
        DB::connection()->enableQueryLog();
        Log::debug($request->user());
        $payload = auth()->payload();
        Log::debug($payload);

        //        if ($role == UserRole::ADMIN) {
        //            return $next($request);
        //        }
        //        return redirect('/');
        return $next($request);
    }
}
