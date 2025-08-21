<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RendezVous;

class RendezVousController extends Controller
{
    public function index()
    {
        $rdvs = RendezVous::with(['patient', 'medecin', 'specialite'])->get();
        return response()->json($rdvs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_rdv' => 'required|date',
            'heure_rdv' => 'required',
            'motif' => 'nullable|string',
            'id_patient' => 'required|exists:utilisateurs,id',
            'id_medecin' => 'required|exists:utilisateurs,id',
            'id_specialite' => 'required|exists:specialites,id',
        ]);

        $validated['etat'] = 'en_attente';
        $validated['type_action'] = 'prise';

        $rdv = RendezVous::create($validated);

        return response()->json($rdv, 201);
    }

    public function show($id)
    {
        $rdv = RendezVous::with(['patient', 'medecin', 'specialite'])->findOrFail($id);
        return response()->json($rdv);
    }

    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);

        $validated = $request->validate([
            'etat' => 'in:en_attente,confirme,annule,reprogramme',
            'motif' => 'nullable|string',
            'modifie_par' => 'in:patient,medecin',
            'type_action' => 'in:prise,confirmation,annulation,reprogrammation',
            'date_modification' => 'nullable|date',
            'date_precedente' => 'nullable|date',
            'date_rdv' => 'nullable|date',
            'heure_rdv' => 'nullable',
        ]);

        $rdv->update($validated);

        return response()->json($rdv);
    }

    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->delete();

        return response()->json(['message' => 'Rendez-vous supprimé avec succès']);
    }
}
