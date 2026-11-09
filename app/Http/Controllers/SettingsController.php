<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(Image $image): Response
    {
        return Inertia::render('Settings', [
            'images' => $image::where('user_id', Auth::id())->get(),
        ]);
    }
}
