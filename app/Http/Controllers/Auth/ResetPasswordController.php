<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'identity_number' => 'required|min:1',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('identity_number', $request->identity_number)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['identity_number' => 'Identification Number is not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        event(new PasswordReset($user));

        // Customize the response after a successful password reset
        return redirect('/')->with('success', 'Your password has been reset successfully.');
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
