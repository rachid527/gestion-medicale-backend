<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisponibiliteServiceRequest;
use App\Models\DisponibiliteService;

class DisponibiliteServiceController extends Controller
{
    // ✅ Lister toutes les disponibilités
    public function index()
    {
        $dispos = DisponibiliteService::with('service')->get();
        return response()->json($dispos);
    }

    // ✅ Créer une nouvelle disponibilité
    public function store(DisponibiliteServiceRequest $request)
    {
        $dispo = DisponibiliteService::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Disponibilité créée avec succès',
            'data'    => $dispo
        ], 201);
    }

    // ✅ Afficher une disponibilité précise
    public function show($id)
    {
        $dispo = DisponibiliteService::with('service')->findOrFail($id);

        return response()->json($dispo);
    }

    // ✅ Mettre à jour une disponibilité
    public function update(DisponibiliteServiceRequest $request, $id)
    {
        $dispo = DisponibiliteService::findOrFail($id);
        $dispo->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Disponibilité mise à jour avec succès',
            'data'    => $dispo
        ]);
    }

    // ✅ Supprimer une disponibilité
    public function destroy($id)
    {
        $dispo = DisponibiliteService::findOrFail($id);
        $dispo->delete();

        return response()->json(['message' => 'Disponibilité supprimée avec succès']);
    }
}
