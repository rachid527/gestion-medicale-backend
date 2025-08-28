<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RendezVousRequest;
use App\Models\RendezVous;
use Carbon\Carbon;

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

    // 📌 Mettre à jour un rendez-vous (annulation / reprogrammation / confirmation)
    public function update(RendezVousRequest $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        $data = $request->validated();

        // Vérifier les règles métier
        if (isset($data['modifie_par']) && in_array($data['modifie_par'], ['patient', 'medecin'])) {
            $now = Carbon::now();
            $rdvDateTime = Carbon::parse($rdv->date_rdv . ' ' . $rdv->heure_rdv);

            if ($data['modifie_par'] === 'patient') {
                // Patient : doit annuler/reprogrammer ≥ 48h avant
                if ($now->diffInHours($rdvDateTime, false) < 48) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Un patient ne peut annuler ou reprogrammer qu’au moins 48h avant le rendez-vous.'
                    ], 403);
                }
            }

            if ($data['modifie_par'] === 'medecin') {
                // Médecin : doit annuler/reprogrammer ≥ 24h avant
                if ($now->diffInHours($rdvDateTime, false) < 24) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Un médecin ne peut annuler ou reprogrammer qu’au moins 24h avant le rendez-vous.'
                    ], 403);
                }
            }
        }

        // Mise à jour avec historique
        $data['date_modification'] = Carbon::now();
        $data['date_precedente'] = $rdv->date_rdv; // si reprogrammé

        $rdv->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous mis à jour avec succès',
            'data'    => $rdv
        ]);
    }

    // 📌 Supprimer un rendez-vous (optionnel, sinon utiliser update avec état "annulé")
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
