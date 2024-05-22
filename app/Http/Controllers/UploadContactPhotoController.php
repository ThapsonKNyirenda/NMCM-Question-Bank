<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;

class UploadContactPhotoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Contact $contact, ImageUploadRequest $request): RedirectResponse
    {
        $path  = 'storage/'.$request->file('file')->store('uploads');

        $contact->update(['photo' => $path]);

        return redirect()->back()->with('success', 'Contact photo successfully uploaded');
    }
}
