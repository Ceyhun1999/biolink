<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($validated, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.patients.create');
        };

        return redirect()->route('admin.login')->with('error', 'Incorrect username or password');
    }
}
