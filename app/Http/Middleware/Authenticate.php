<?php

namespace App\Http\Middleware;

use App\Services\PostHogService;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, Closure $next, ...$guards): Response
    {
        parent::handle($request, static fn ($request) => $request, ...$guards);

        $user = $request->user();
        $context = app(PostHogService::class)->contextFromHeaders($request->headers->all());
        $context['distinctId'] = (string) $user->getAuthIdentifier();
        $context['properties'] = array_merge($context['properties'] ?? [], [
            '$set' => array_filter([
                'email' => $user->email,
                'name' => $user->name,
            ], static fn ($value): bool => $value !== null && $value !== ''),
        ]);

        return app(PostHogService::class)->withContext($context, static fn (): Response => $next($request));
    }
}
