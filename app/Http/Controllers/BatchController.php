<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BatchController extends Controller
{
    public function index()
    {
        $batches =  Batch::with('microgreen')->get();
        return Inertia::render('Batches', ['batches' => $batches]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'microgreen_id' => 'required|exists:microgreens,id',
            'dateOfSowing' => 'required|date',
            'dateOfCollection' => 'required|integer',
        ]);

        $batch = Batch::create($data);
        return response()->json($batch, 201);
    }

    public function edit(Batch $batch)
    {
        return $batch;
    }

    public function update(Request $request, Batch $batch)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'microgreen_id' => 'required|exists:microgreens,id',
            'dateOfSowing' => 'required|date',
            'dateOfCollection' => 'required|integer',
        ]);

        $batch->update($data);
        return response()->json($batch);
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return response()->json(['message' => 'Batch deleted']);
    }
}
