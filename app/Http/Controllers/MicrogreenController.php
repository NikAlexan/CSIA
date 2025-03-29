<?php

namespace App\Http\Controllers;

use App\Models\Microgreen;
use Illuminate\Http\Request;

class MicrogreenController extends Controller
{
    public function index()
    {
        return Microgreen::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'germination_time' => 'nullable|string',
            'temperature' => 'nullable|string',
            'light' => 'nullable|string',
        ]);

        return Microgreen::create($data);
    }

    public function show(Microgreen $microgreen)
    {
        return $microgreen;
    }

    public function update(Request $request, Microgreen $microgreen)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'germination_time' => 'nullable|string',
            'temperature' => 'nullable|string',
            'light' => 'nullable|string',
        ]);

        $microgreen->update($data);
        return $microgreen;
    }

    public function destroy(Microgreen $microgreen)
    {
        $microgreen->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
