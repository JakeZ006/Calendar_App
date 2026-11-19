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

        dd(Storage::disk('storage'));

        return Inertia::render('Settings', [
            'images' => Storage::disk('s3')
        ]);
    }
}
