<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\PostHogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, PostHogService $posthog): RedirectResponse
    {
        $request->authenticate();

        $user = $request->user();
        $posthog->identify((string) $user->getAuthIdentifier(), [
            'email' => $user->email,
            'name' => $user->name,
        ]);
        $posthog->withContext([
            'distinctId' => (string) $user->getAuthIdentifier(),
        ], static fn () => $posthog->capture('user_logged_in', [
            'login_method' => 'password',
        ]));

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request, PostHogService $posthog): RedirectResponse
    {
        $posthog->capture('user_logged_out');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
