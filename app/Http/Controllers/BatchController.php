<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Microgreen;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BatchController extends Controller
{
    public function index()
    {
        $batches =  Batch::with('microgreen')->get();
        return Inertia::render('Batch/List', ['batches' => $batches]);
    }

    public function create()
    {
        $users = User::all();
        $microgreen = Microgreen::all();
        return Inertia::render('Batch/Create', ['users' => $users, 'microgreen' => $microgreen]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'microgreen_id' => 'required|exists:microgreens,id',
            'dateOfSowing' => 'required|date',
            'dateOfCollection' => 'required|date',
        ]);

        Batch::create($data);
        return redirect()->route('batches.index');
    }

    public function edit(Batch $batch)
    {
        $users = User::all();
        $microgreen = Microgreen::all();

        return Inertia::render('Batch/Edit', [
            'users' => $users,
            'microgreen' => $microgreen,
            'batch' => $batch
        ]);
    }

    public function update(Request $request, Batch $batch)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'microgreen_id' => 'required|exists:microgreens,id',
            'dateOfSowing' => 'required|date',
            'dateOfCollection' => 'required|date',
        ]);

        $batch->update($data);
        return redirect()->route('batches.index');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index');
    }
}
