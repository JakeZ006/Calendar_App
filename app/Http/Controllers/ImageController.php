<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['required'],
        ]);

        $path = $request->image->store('images', 'public');

        Image::create([
            'path' => $path,
            'user_id' => Auth::id(),
            'name' => $request->image->getClientOriginalName(),
        ]);

        return redirect()->to('/settings');

    }

    public function update(Request $request, Image $image): void
    {
        //
    }

    public function destroy(Image $image, Request $request): RedirectResponse
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $image = Image::where('user_id', Auth::id())
            ->findOrFail($request->integer('id'));

        Storage::disk('public')->delete($image->path);

        $image->delete();

        return redirect()->back();
    }
}
