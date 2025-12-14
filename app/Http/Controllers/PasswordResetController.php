<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class PasswordResetController extends Controller
{
    /**
     * Show the password reset form.
     */
    public function show()
    {
        return view('password-reset');
    }

    /**
     * Handle the password reset request.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'password_confirmation' => ['required'],
        ]);

        $user = Auth::user();
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password),
            ]);

        return redirect()->route('password-reset.show')->with('success', 'Password updated successfully!');
    }
}
