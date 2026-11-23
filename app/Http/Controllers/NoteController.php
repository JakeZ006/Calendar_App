<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\Photo;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
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
            'photos' => Photo::where('user_id', Auth::id())->get(),
            'quotes' => Quote::all(),

        ]);

    }

    public function store(NoteRequest $request): RedirectResponse
    {
        Note::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home');

    }

    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        $this->authorize('update', $note);

        $note->update([
            ...$request->validated()
        ]);

        return redirect()->route('home');

    }

    public function destroy(Request $request, Note $note): RedirectResponse
    {

        $this->authorize('delete', $note);

        $note->delete();

        return redirect()->route('home');
    }
}
