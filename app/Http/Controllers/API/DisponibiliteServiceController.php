<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DisponibiliteService;

class DisponibiliteServiceController extends Controller
{
    public function index()
    {
        $dispos = DisponibiliteService::with('service')->get();
        return response()->json($dispos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_service' => 'required|exists:services,id_service',
            'jour_semaine' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'estOuvert' => 'boolean',
        ]);

        $dispo = DisponibiliteService::create($validated);

        return response()->json($dispo, 201);
    }

    public function show($id)
    {
        $dispo = DisponibiliteService::with('service')->findOrFail($id);
        return response()->json($dispo);
    }

    public function update(Request $request, $id)
    {
        $dispo = DisponibiliteService::findOrFail($id);

        $validated = $request->validate([
            'id_service' => 'exists:services,id_service',
            'jour_semaine' => 'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'heure_debut' => 'date_format:H:i',
            'heure_fin' => 'date_format:H:i|after:heure_debut',
            'estOuvert' => 'boolean',
        ]);

        $dispo->update($validated);

        return response()->json($dispo);
    }

    public function destroy($id)
    {
        $dispo = DisponibiliteService::findOrFail($id);
        $dispo->delete();

        return response()->json(['message' => 'Disponibilité supprimée avec succès']);
    }
}
