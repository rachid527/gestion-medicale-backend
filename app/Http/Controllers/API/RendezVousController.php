<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RendezVousRequest; // 👉 utilisation du FormRequest
use App\Models\RendezVous;

class RendezVousController extends Controller
{
    // 📌 Lister tous les rendez-vous
    public function index()
    {
        $rdvs = RendezVous::with(['patient', 'medecin', 'specialite'])->get();
        return response()->json($rdvs);
    }

    // 📌 Créer un rendez-vous
    public function store(RendezVousRequest $request)
    {
        $data = $request->validated();

        // Valeurs par défaut
        $data['etat'] = 'en_attente';
        $data['type_action'] = 'prise';

        $rdv = RendezVous::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous créé avec succès',
            'data'    => $rdv
        ], 201);
    }

    // 📌 Afficher un rendez-vous par ID
    public function show($id)
    {
        $rdv = RendezVous::with(['patient', 'medecin', 'specialite'])->findOrFail($id);
        return response()->json($rdv);
    }

    // 📌 Mettre à jour un rendez-vous
    public function update(RendezVousRequest $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);

        $rdv->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous mis à jour avec succès',
            'data'    => $rdv
        ]);
    }

    // 📌 Supprimer un rendez-vous
    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous supprimé avec succès'
        ]);
    }
}
