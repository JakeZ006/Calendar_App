<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

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
                'username' => 'Wrong username or password',
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

    public function updateUser(UpdateUserRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if ($request->oldUsername !== $user->username) {
            return back()->withErrors([
                'oldUsername' => 'Incorrect username',
            ]);
        }
        if (! Hash::check($request->oldPassword, $user->password)) {
            return back()->withErrors([
                'oldPassword' => 'Incorrect password',
            ]);
        }

        $request->validated();

        if ($request->filled('newUsername')) {
            $user->username = $request->newUsername;
        }
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
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($request->username !== $user->username) {
            return back()->withErrors([
                'username' => 'Incorrect username',
            ]);
        }
        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password',
            ]);
        }

        $userPhotos = Photo::where('user_id', Auth::id())->get();

        foreach ($userPhotos as $photo) {
            Storage::disk()->delete($photo->path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('register');
    }
}
