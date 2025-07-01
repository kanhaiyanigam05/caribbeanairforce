<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $method = $request->method();
        if($method === 'GET') {
            // Exclude specific routes, e.g., login
            $excludedRoutes = ['login', 'logout', 'register']; // Add routes to exclude here

            // Check if the current route matches any excluded routes
            foreach ($excludedRoutes as $excludedRoute) {
                if ($request->is($excludedRoute) || $request->is("$excludedRoute/*")) {
                    return $next($request); // Allow access to excluded routes
                }
            }

            // If user is SUPERADMIN, ensure they are within the 'admin/' path
            if ($user && $user->role === Role::SUPERADMIN) {
                $adminPath = 'admin/';
                if (!str_starts_with($request->path(), $adminPath)) {
                    return redirect($adminPath . $request->path());
                }
            }

            // If user is not SUPERADMIN, redirect to the base path ('/') unless already there
            if (!$user || $user->role !== Role::SUPERADMIN) {
                $adminPath = 'admin/';
                if (str_starts_with($request->path(), $adminPath)) {
                    $newPath = substr($request->path(), strlen($adminPath));
                    return redirect('/' . ltrim($newPath, '/'));
                }
            }
        }


        return $next($request);
    }
}
