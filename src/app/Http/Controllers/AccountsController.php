<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    public function get($id)
    {
        $account = User::find($id);
        if (! $account) {
            return redirect(route('login'));
        }

        return response()->json($account->only([
            'id',
            'name',
            'email',
            'role'
        ]));
    }

    public function index()
    {
        $users = User::get();

        return view('pages.accounts', compact('users'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
            'role' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error_add', true)->withInput($request->only(['name', 'email']));
        }

        // Check password is match
        if ($request->password !== $request->confirm_password) {
            return back()->with('error_add', true)->with('error', 'Password missmatch');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($user) {
            return back()->with('success');
        }

        return back()->with('error_add', true)->withInput();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $user = User::find($request->id);

        // If you want to delete user with admin privileges
        // This action must be performed by another user with admin privileges
        // To ensure the system have at least one user with admin privileges
        if ($user->role == 'admin' && (Auth::user()->id === $user->id)) {
            return back()->with('error_body', 'To delete user with role admin, need to performed by another user with admin privileges');
        }

        $user->delete();

        return back();
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return back()->with('error_edit', true)->withErrors($validator)->withInput($request->only([
                'name',
                'email',
                'id'
            ]));
        }

        $account = User::find($request->id);

        if (! $account) {
            return redirect(route('login'));
        }

        $account->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($request->id == Auth::user()->id && $request->role == 'user') {
            return back()->with('error_edit', true)->with('error', "Cant't downgrade role for their own account")->withInput($request->only([
                'name',
                'email',
                'id'
            ]));
        }

        $account->update([
            'role' => $request->role
        ]);

        if ($request->password) {
            if ($request->password !== $request->confirm_password) {
                return back()->with('error_edit', true)->with('error', 'Password missmatch')->withInput($request->only([
                    'name',
                    'email',
                    'id'
                ]));
            }

            $account->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back();
    }
}
