<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DossierMedical;
use App\Models\Utilisateur;

class DossierMedicalController extends Controller
{
    public function index()
    {
        // Renvoyer tous les utilisateurs
    }

    public function store(Request $request)
    {
        // Valider et créer un nouvel utilisateur
    }

    public function show($id)
    {
        $patient = Utilisateur::findOrFail($id);

        $dossier = DossierMedical::where('id_patient', $patient->id)->first();

        if (!$dossier) {
            return response()->json(['message' => 'Dossier médical non trouvé'], 404);
        }

        return response()->json($dossier);
    }

    public function update(Request $request, $id)
    {
        $dossier = DossierMedical::where('id_patient', $id)->firstOrFail();

        $validated = $request->validate([
            'groupe_sanguin' => 'nullable|string',
            'allergies' => 'nullable|string',
            'antecedents' => 'nullable|string',
            'poids' => 'nullable|numeric',
            'remarques' => 'nullable|string',
        ]);

        $dossier->update($validated);

        return response()->json($dossier);
    }

    public function destroy($id)
    {
        // Supprimer un utilisateur
    }
}
