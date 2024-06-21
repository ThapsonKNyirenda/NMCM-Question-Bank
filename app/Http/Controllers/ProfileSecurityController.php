<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileSecurityUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class ProfileSecurityController extends Controller
{

    public function __construct()
    {
        Inertia::share('activeMenu', 'My Profile');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {

        return Inertia::render('Profile/Security/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'twoFactorEnabled' => !empty($request->user()->two_factor_secret),
            'qrCodeSvg' => !empty($request->user()->two_factor_secret) ? $request->user()->twoFactorQrCodeSvg() : '',
            'recoveryCodes' => !empty($request->user()->two_factor_secret) ? (array) $request->user()->recoveryCodes() : [],
        ]);
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileSecurityUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'User password successfully updated');

    }

}