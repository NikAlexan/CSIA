<?php

namespace App\Http\Controllers;

use App\Models\Microgreen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MicrogreenController extends Controller
{
    public function index()
    {
        $microgreen = Microgreen::all();

        return Inertia::render('Microgreen/List', ['microgreen' => $microgreen]);
    }

    public function create() {
        return Inertia::render('Microgreen/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'germination_min_days' => 'integer|min:0',
            'germination_max_days' => 'integer|min:0|gte:germination_min_days',
            'temperature_min' => 'numeric',
            'temperature_max' => 'numeric|gte:temperature_min',
            'light' => 'nullable|string',
        ]);

        Microgreen::create($data);

        return redirect()->route('microgreen.index');
    }

    public function edit(Microgreen $microgreen)
    {
        return Inertia::render('Microgreen/Edit', ['microgreen' => $microgreen]);
    }

    public function update(Request $request, Microgreen $microgreen)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'germination_min_days' => 'integer|min:0',
            'germination_max_days' => 'integer|min:0|gte:germination_min_days',
            'temperature_min' => 'numeric',
            'temperature_max' => 'numeric|gte:temperature_min',
            'light' => 'nullable|string',
        ]);

        $microgreen->update($data);
        return redirect()->route('microgreen.index');
    }

    public function destroy(Microgreen $microgreen)
    {
        $microgreen->delete();
        return redirect()->route('microgreen.index');
    }
}
