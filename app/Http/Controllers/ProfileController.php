<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\PostHogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, PostHogService $posthog): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $emailChanged = $request->user()->isDirty('email');

        if ($emailChanged) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $posthog->identify((string) $request->user()->getAuthIdentifier(), [
            'email' => $request->user()->email,
            'name' => $request->user()->name,
        ]);
        $posthog->capture('profile_updated', [
            'email_changed' => $emailChanged,
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, PostHogService $posthog): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $posthog->capture('account_deleted');

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
