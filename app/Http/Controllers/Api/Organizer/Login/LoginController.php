<?php

namespace App\Http\Controllers\Api\Organizer\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Organizer;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('Organizer.Login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in the organizer
        if (
            Auth::guard('organizer')->attempt([
                'username' => $request->username,
                'password' => $request->password,
            ])
        ) {
            // If login successful, update last login time
            $organizer = Auth::guard('organizer')->user();
            $organizer->last_login = now();
            $organizer->save();

            // Redirect to dashboard
            return redirect()->route('organizer.dashboard');
        }

        // If authentication fails
        return redirect()
            ->back()
            ->withErrors([
                'username' => 'Invalid credentials.',
            ])
            ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::guard('organizer')->logout();

        return redirect()->route('home');
    }
}
