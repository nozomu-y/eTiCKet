<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AccountSettingController extends Controller
{
    function change_password(Request $request)
    {
        $user = Auth::user();
        $validator = $this->validator($request->all(), $user);
        $validator->validate();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('home')->with('success', __('message.change_password.success'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $user)
    {
        return Validator::make($data, [
            'current_password' => ['required', 'string', 'min:8', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('message.change_password.current_password_incorrect'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
