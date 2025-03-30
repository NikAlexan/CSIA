<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ObservationController extends Controller
{
    public function index()
    {
        $observations = Observation::all();
        return Inertia::render('Observation/List', ['observations' => $observations]);
    }

    public function create()
    {
        return Inertia::render('Observation/Create', ['batches' => Batch::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'date' => 'required|date',
            'visualChanges' => 'required|string',
            'image' => 'required|image',
            'height' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $data['image'] = Storage::putFile('observations', $request->file('image'));

        Observation::create($data);
        return redirect()->route('observations.index');
    }

    public function edit(Observation $observation)
    {
        return Inertia::render('Observation/Edit', ['batches' => Batch::all(), 'observation' => $observation]);
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
        return redirect()->route('observations.index');
    }

    public function getImage(Observation $observation): StreamedResponse
    {
        if(!Storage::exists($observation->image)) {
            abort(404);
        }

        return Storage::response($observation->image);
    }
}
