<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;

class UploadCustomerPhotoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Customer $customer, ImageUploadRequest $request): RedirectResponse
    {
        $path  = 'storage/'.$request->file('file')->store('uploads');

        $customer->update(['photo' => $path]);

        $customer->mainContact()->update([ 'photo'  => $path]);

        return redirect()->back()->with('success', 'Customer logo/photo successfully uploaded');
    }
}
