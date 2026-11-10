<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Image;
use App\Models\Note;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{
    public function index(Note $note, User $user, Image $image, Quote $quote): Response
    {

        return Inertia::render('Home', [
            'notes' => $note::where('user_id', Auth::id())
                ->orderBy('for_date')
                ->get()
                ->groupBy('for_date'),
            'images' => $image::where('user_id', Auth::id())->get(),
            'quotes' => $quote::all(),

        ]);

    }

    public function store(StoreNoteRequest $request): void
    {
        $request->validate([
            'title' => ['required', 'max:15', 'min:3'],
            'type' => ['required'],
            'content' => ['max:255'],
        ]);

        Note::create([
            'user_id' => Auth::id(),
            'title' => ucfirst(request('title')),
            'type' => request('type'),
            'important' => request('important'),
            'expirable' => request('expirable'),
            'for_date' => request('for_date'),
            'content' => request('content'),
        ]);

    }

    public function update(UpdateNoteRequest $request, Note $note): void
    {
        $this->authorize('update', $note);

        $request->validate([
            'title' => ['required', 'max:15', 'min:3'],
            'type' => ['required'],
            'content' => ['max:255'],
        ]);

        Note::where('id', $request->id)
            ->update([
                'title' => ucfirst(request('title')),
                'type' => request('type'),
                'important' => request('important'),
                'expirable' => request('expirable'),
                'content' => request('content'),
            ]);
    }

    public function destroy(DeleteNoteRequest $request, Note $note): void
    {

        $this->authorize('delete', $note);

        $note->delete();
    }
}
