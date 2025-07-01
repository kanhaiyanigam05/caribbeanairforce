<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use App\Enums\Status;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyDocuments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is an ORGANIZER and both license_status and address_proof_status are ACCEPTED
        if (Auth::user()->role == Role::ORGANIZER &&
            Auth::user()->license_status == Status::ACCEPTED &&
            Auth::user()->address_proof_status == Status::ACCEPTED) {

            // If both statuses are ACCEPTED and the route is 'admin.signup.documents', redirect to the dashboard
            if ($request->route()->getName() === 'admin.signup.documents') {
                return redirect()->route('admin.dashboard');
            }
        }

        // If the route is 'admin.signup.documents' or 'admin.signup.store.documents', allow the request to continue
        if ($request->route()->getName() === 'admin.signup.documents' || $request->route()->getName() === 'admin.signup.store.documents') {
            return $next($request);
        }

        // If either status is not ACCEPTED, redirect to the 'admin.signup.documents' page
        if (Auth::user()->role == Role::ORGANIZER &&
            (Auth::user()->license_status != Status::ACCEPTED || Auth::user()->address_proof_status != Status::ACCEPTED)) {
            return redirect()->route('admin.signup.documents');
        }

        return $next($request);
    }

}
