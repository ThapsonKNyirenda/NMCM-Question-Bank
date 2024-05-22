<?php

namespace App\Services;

use App\Models\User;
use App\Traits\HasUpdateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use HasUpdateUser;

    /**
     * @param Request $request
     * @return mixed
     */
    public function createUser(Request $request): mixed
    {

        $path  = $request->has('file') ? 'storage/'.$request->file('file')->store('uploads') : null;
        $password =  $request->password;

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'status' => $request->status,
            'photo'     => $path
        ]);
    }
}
