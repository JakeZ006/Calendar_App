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

        $path = $request->image->store('images', 'public');

        Image::create([
            'path' => 'https://fls-a330b4e4-6408-4171-ba4a-11b9394b4178.laravel.cloud/'.$path,
            'user_id' => Auth::id(),
            'name' => $request->image->getClientOriginalName(),
        ]);

    }

    public function destroy( Request $request ): void
    {
        $image = Image::where('user_id', Auth::id())
            ->findOrFail($request->id);

        $this->authorize('delete', $image);

        Storage::disk('public')->delete($image->path);

        $image->delete();

    }
}
