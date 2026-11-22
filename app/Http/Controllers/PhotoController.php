<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class PhotoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'mimes:avif,png,jpeg,jpg,webp', File::image()->max(5 * 1024)],
        ]);

        $path = $request->file('photo')->store('photos');

        Photo::create([
            'path' => $path,
            'user_id' => Auth::id(),
            'name' => $request->photo->getClientOriginalName(),
            'url' => Storage::disk()->url($path),
        ]);

        return redirect('settings');
    }

    public function destroy(Request $request, Photo $photo): RedirectResponse
    {

        $this->authorize('delete', $photo);

        Storage::disk()->delete($photo->path);

        $photo::destroy($photo->id);

        return redirect('settings');
    }
}
