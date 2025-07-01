<?php

namespace App\Jobs;

use App\Events\CsrfUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;

class CsrfJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Ensure you're in a context that can generate CSRF token
        $token = \Request::instance()->session()->token(); // Manually access the CSRF token

        \Log::info('CSRF Token: ' . $token); // Log the CSRF token
        broadcast(new CsrfUpdate($token));
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}