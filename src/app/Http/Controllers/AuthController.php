<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            return redirect('/books');
        }

        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $auth = Auth::attempt($credential, $request->remember);
        if ($auth) {
            $request->session()->regenerate();

            return redirect(route('books'));
        }

        return redirect(route('login'))->with('failed', 1);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
