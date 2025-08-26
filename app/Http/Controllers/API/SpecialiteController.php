<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Specialite;
use App\Http\Requests\CreateSpecialiteRequest;
use App\Http\Requests\UpdateSpecialiteRequest;

class SpecialiteController extends Controller
{
    // Liste des spécialités
    public function index()
    {
        $specialites = Specialite::with('service')->get();
        return response()->json($specialites);
    }

    // Création d’une spécialité
    public function store(CreateSpecialiteRequest $request)
    {
        $specialite = Specialite::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Spécialité créée avec succès',
            'data'    => $specialite
        ], 201);
    }

    // Détails d’une spécialité
    public function show($id)
    {
        $specialite = Specialite::with('service')->findOrFail($id);
        return response()->json($specialite);
    }

    // Mise à jour d’une spécialité
    public function update(UpdateSpecialiteRequest $request, $id)
    {
        $specialite = Specialite::findOrFail($id);
        $specialite->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Spécialité mise à jour avec succès',
            'data'    => $specialite
        ]);
    }

    // Suppression d’une spécialité
    public function destroy($id)
    {
        $specialite = Specialite::findOrFail($id);
        $specialite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Spécialité supprimée avec succès'
        ]);
    }
}
