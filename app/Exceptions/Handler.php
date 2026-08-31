<?php

namespace App\Exceptions;

use App\Services\PostHogService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e): void {
            $distinctId = auth()->id();

            app(PostHogService::class)->captureException(
                $e,
                $distinctId !== null ? (string) $distinctId : null,
                [
                    '$current_url' => request()->fullUrl(),
                    '$request_method' => request()->method(),
                ]
            );
        });
    }
}
