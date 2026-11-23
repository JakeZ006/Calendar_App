<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

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

        if (! Hash::check($request->oldPassword, $user->password)) {
            return back()->withErrors([
                'oldPassword' => 'Incorrect passord',
            ]);
        }
        if ($request->oldUsername !== $user->username) {
            return back()->withErrors([
                'oldPassword' => 'Incorrect username',
            ]);
        }

        $request->validate([
            'username' => ['required', 'string', 'unique:users', 'min:4', 'max:20'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->symbols()],
        ]);

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
