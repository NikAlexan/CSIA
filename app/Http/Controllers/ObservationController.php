<?php
namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    public function index()
    {
        return Observation::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date',
            'visualChanges' => 'required|string',
            'image' => 'required|string', // путь к изображению
            'height' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $observation = Observation::create($data);
        return response()->json($observation, 201);
    }

    public function show(Observation $observation)
    {
        return $observation;
    }

    public function update(Request $request, Observation $observation)
    {
        $data = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date',
            'visualChanges' => 'required|string',
            'image' => 'required|string',
            'height' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $observation->update($data);
        return response()->json($observation);
    }

    public function destroy(Observation $observation)
    {
        $observation->delete();
        return response()->json(['message' => 'Observation deleted']);
    }
}
