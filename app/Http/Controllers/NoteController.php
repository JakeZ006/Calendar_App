<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{
    public function index(): Response
    {

        return Inertia::render('Home', [
            'notes' => Note::where('user_id', Auth::id())
                ->orderBy('for_date')
                ->get()
                ->groupBy('for_date'),
            'photos' => User::find(Auth::id())->photos,
            'quotes' => Quote::all(),

        ]);

    }

    public function store(Request $request, Note $note): void
    {

        $request->validate([
            'title' => ['required', 'max:15', 'min:3'],
            'type' => ['required'],
            'content' => ['max:255'],
        ]);

        $note->create([
            'user_id' => Auth::id(),
            'title' => ucfirst(request('title')),
            'type' => request('type'),
            'important' => request('important'),
            'expirable' => request('expirable'),
            'for_date' => request('for_date'),
            'content' => request('content'),
        ]);

    }

    public function update(Request $request, Note $note): void
    {
        $this->authorize('update', $note);

        $request->validate([
            'title' => ['required', 'max:15', 'min:3'],
            'type' => ['required'],
            'content' => ['max:255'],
        ]);

        $note->update([
            'title' => ucfirst(request('title')),
            'type' => request('type'),
            'important' => request('important'),
            'expirable' => request('expirable'),
            'content' => request('content'),
        ]);
    }

    public function destroy(Request $request, Note $note): void
    {

        $this->authorize('delete', $note);

        $note->delete();
    }
}
