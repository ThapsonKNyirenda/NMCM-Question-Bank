<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait HasUpdateUser
{
    public function updateUser(Request $request, Model $user): void
    {
        if ($request->change_password === true){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);
        }else{
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
            ]);
        }
    }
}
