<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SetUserTimezone
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user_timezone is set in session
        $timezone = session('user_timezone');

        // If user_timezone is not set, fetch timezone based on the user's IP address
        if (!$timezone) {
            // Get the user's IP address
            $ip = $request->ip();

            // Fetch timezone from a third-party API (using ip-api as an example)
            $response = Http::get("http://ip-api.com/json/{$ip}");

            if ($response->successful()) {
                // Extract the timezone from the API response
                $timezone = $response->json()['timezone'] ?? 'UTC';
            } else {
                // Default to UTC if unable to get the timezone
                $timezone = 'UTC';
            }

            // Store the timezone in the session
            session(['user_timezone' => $timezone]);
        }

        // Set the PHP and Laravel timezone
        date_default_timezone_set($timezone);
        config(['app.timezone' => $timezone]);

        return $next($request);
    }
}
