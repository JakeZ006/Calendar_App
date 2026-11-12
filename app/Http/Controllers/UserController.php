<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Image;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::create($credentials);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function loginUser(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Wrong username or password.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logoutUser(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updateUser(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'oldPassword' => ['required', 'string'],
            'newUsername' => ['required', 'string', 'min:4', 'max:20', 'unique:users'],
            'newPassword' => ['nullable', 'string', 'min:8'],
        ]);

        if (! Hash::check($request->oldPassword, $user->password)) {
            return back()->withErrors([
                'oldPassword' => 'Your current password is incorrect.',
            ]);
        }

        $user->username = $request->newUsername;

        if ($request->filled('newPassword')) {
            $user->password = $request->newPassword;
        }

        $user->save();

        return redirect()->route('settings');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Your password is incorrect.',
            ]);
        }

        Note::where('user_id', $user->id)->delete();
        Image::where('user_id', $user->id)->delete();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('register');
    }
}
