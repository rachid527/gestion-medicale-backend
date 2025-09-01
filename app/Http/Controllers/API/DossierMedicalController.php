<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DossierMedicalRequest;
use App\Models\DossierMedical;
use Illuminate\Http\Request;

class DossierMedicalController extends Controller
{
    /**
     * 📌 Lister tous les dossiers médicaux
     */
    public function index()
    {
        $dossiers = DossierMedical::with('patient')->get();

        return response()->json($dossiers);
    }

    /**
     * 📌 Créer un nouveau dossier médical
     */
    public function store(DossierMedicalRequest $request)
    {
        $dossier = DossierMedical::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => '✅ Dossier médical créé avec succès',
            'data'    => $dossier
        ], 201);
    }

    /**
     * 📌 Afficher le dossier médical d’un patient via son id_patient
     */
    public function show($id)
    {
        $dossier = DossierMedical::where('id_patient', $id)
            ->with('patient')
            ->first();

        if (!$dossier) {
            return response()->json([
                'success' => false,
                'message' => '❌ Dossier médical non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $dossier
        ]);
    }

    /**
     * 📌 Mettre à jour le dossier médical d’un patient
     */
    public function update(DossierMedicalRequest $request, $id)
    {
        $dossier = DossierMedical::where('id_patient', $id)->firstOrFail();

        $dossier->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => '✅ Dossier médical mis à jour avec succès',
            'data'    => $dossier
        ]);
    }

    /**
     * 📌 Supprimer le dossier médical d’un patient
     */
    public function destroy($id)
    {
        $dossier = DossierMedical::where('id_patient', $id)->firstOrFail();
        $dossier->delete();

        return response()->json([
            'success' => true,
            'message' => '🗑️ Dossier médical supprimé avec succès'
        ]);
    }
}
