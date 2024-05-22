<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeSignatureRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileSignatureController extends Controller
{
    public function __construct()
    {
        Inertia::share('activeMenu', 'Dashboard');
        $this->middleware('password.confirm');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        Gate::authorize('update', $request->user());

        return Inertia::render('Profile/Signature/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function show(Request $request): Response
    {
        Gate::authorize('view', $request->user());

        return Inertia::render('Profile/Signature/Show', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'twoFactorEnabled' => !empty($request->user()->two_factor_secret)
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ChangeSignatureRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $request->user()->save();

        return Redirect::route('profile.signature.show')->with('success', 'Signature successfully updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Gate::authorize('update', $request->user());

        $request->user()->fill(['signature' => null]);
        $request->user()->save();

        return Redirect::route('profile.signature.show')->with('success', 'Signature successfully deleted');
    }
}
