<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class PhotoController extends Controller
{
    public function store(Request $request): void
    {
        $request->validate([
            'photo' => ['required', 'mimes:avif,png,jpeg,jpg,webp', File::image()->max(3 * 1024)],
        ]);

        $path = $request->image('photo')->optimize()->storePublicly('photos', 'public');

        Photo::create([
            'path' => $path,
            'user_id' => Auth::id(),
            'name' => $request->photo->getClientOriginalName(),
        ]);

    }

    public function destroy(Request $request, Photo $photo): void
    {

        // $this->authorize('delete', $photo);

        Storage::disk('public')->delete($photo->path);

        $photo::destroy($photo->id);

    }
}
