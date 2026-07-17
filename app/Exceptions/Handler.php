<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PostHog\PostHog;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (config('posthog.api_key') && !config('posthog.disabled')) {
                $distinctId = auth()->user()?->email ?? 'anonymous';
                PostHog::captureException($e, $distinctId, [
                    '$current_url' => request()->fullUrl(),
                    '$request_method' => request()->method(),
                ]);
            }
        });
    }
}
