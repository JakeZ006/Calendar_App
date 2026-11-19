<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(Image $image): Response
    {
        dd(Storage::disk('s3')->url('images/BjtCvlieBz704PfGpNTlOvNctyMvApxCQTbqKxWD.jpg'));

        return Inertia::render('Settings', [
            'images' => $image::where('user_id', Auth::id())->get(),
        ]);
    }
}
