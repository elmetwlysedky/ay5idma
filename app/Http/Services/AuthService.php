<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class AuthService
{
    public function attempt(Request $request)
    {
        $identifier = $request->input('email');
        $password = $request->input('password');

        if (is_numeric($identifier)) {
            return auth()->attempt(['phone' => $identifier, 'password' => $password]);
        }

        return auth()->attempt(['email' => $identifier, 'password' => $password]);
    }

    public function registerFromRequest(Request $request, $user = null)
    {
        if (!$user) {
            $user = new User();
            $user->phone_verify = code($numbers = 4, $type = 'digits');
        }

        $user->fill($request->all());
        $user->password = $request->input('password');
        $user->active = 1;

        $user->save();
        return $user;
    }

    public function passwordUpdate(Request $request)
    {
        $oldPassword    = $request->get('old_password');
        $newPassword    = $request->get('password');
        $hashedPassword = auth()->user()->password;

        if (Hash::check($oldPassword, $hashedPassword)) {
            User::find(auth()->user()->id)
            ->update(['password'=> $newPassword]);
            return response()->json(['success'=> true, 'result' => trans('password_updated_successfully')]);
        }

        return response()->json(['success'=> false, 'result'=> trans('wrong_old_password')]);
    }
}
