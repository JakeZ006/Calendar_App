<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Home', [
            'notes' => $user->notes()->orderBy('for_date')->get()->groupBy('for_date'),
            'photos' => $user->photos()->get(),
            'quotes' => Quote::all(),
        ]);

    }

    public function store(NoteRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->notes()->create($request->validated());

        return redirect()->route('home');

    }

    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        $this->authorize('update', $note);

        $note->update($request->validated());

        return redirect()->route('home');

    }

    public function destroy(Note $note): RedirectResponse
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()->route('home');
    }
}
