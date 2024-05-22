<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\User;

class UploadUserPhotoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, ImageUploadRequest $request)
    {
        $path  = 'storage/'.$request->file('file')->store('uploads');

        $user->update([
            'photo'     => $path
        ]);
    }
}
