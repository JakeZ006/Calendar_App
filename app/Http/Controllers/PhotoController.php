<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoRequest;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function store(PhotoRequest $request): RedirectResponse
    {
        $user = $request->user();
        $path = $request->file('photo')->store('photos');

        $user->photos()->create([
            'path' => $path,
            'name' => $request->photo->getClientOriginalName(),
            'url' => Storage::url($path),
        ]);

        return redirect()->route('settings');
    }

    public function destroy(Photo $photo): RedirectResponse
    {

        $this->authorize('delete', $photo);

        Storage::disk()->delete($photo->path);

        $photo->delete();

        return redirect()->route('settings');
    }
}
