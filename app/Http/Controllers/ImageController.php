<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request): void
    {
        $request->validate([
            'image' => ['required', 'image'],
        ]);

        $path = Storage::disk('s3')->put('images', $request->file('image'));


        Image::create([
            'path' => $path,
            'user_id' => Auth::id(),
            'name' => $request->image->getClientOriginalName(),
        ]);

    }

    public function destroy(Request $request): void
    {
        $image = Image::where('user_id', Auth::id())
            ->findOrFail($request->id);

        $this->authorize('delete', $image);

        Storage::disk('public')->delete($image->path);

        $image->delete();

    }
}
