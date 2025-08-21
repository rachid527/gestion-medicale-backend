<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialite;

class SpecialiteController extends Controller
{
    public function index()
    {
        $specialites = Specialite::with('service')->get(); // inclure nom du service
        return response()->json($specialites);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_specialite' => 'required|string',
            'description' => 'nullable|string',
            'id_service' => 'required|exists:services,id_service',
        ]);

        $specialite = Specialite::create($validated);

        return response()->json($specialite, 201);
    }

    public function show($id)
    {
        $specialite = Specialite::with('service')->findOrFail($id);
        return response()->json($specialite);
    }

    public function update(Request $request, $id)
    {
        $specialite = Specialite::findOrFail($id);

        $validated = $request->validate([
            'nom_specialite' => 'string',
            'description' => 'nullable|string',
            'id_service' => 'exists:services,id_service',
        ]);

        $specialite->update($validated);

        return response()->json($specialite);
    }

    public function destroy($id)
    {
        $specialite = Specialite::findOrFail($id);
        $specialite->delete();

        return response()->json(['message' => 'Spécialité supprimée avec succès']);
    }
}
