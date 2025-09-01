<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\RendezVous;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    // 🔍 Liste tous les utilisateurs
    public function index()
    {
        $utilisateurs = User::all();
        return response()->json($utilisateurs);
    }

    // ➕ Créer un nouvel utilisateur (ex : un admin crée un médecin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'sexe' => 'required|in:Homme,Femme',
            'date_naissance' => 'nullable|date',
            'role' => 'required|in:admin,medecin,patient',
            'statut' => 'in:actif,desactive',
            'id_specialite' => 'nullable|exists:specialites,id_specialite', // ✅ spécialité pour médecin
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $utilisateur = User::create($validated);

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $utilisateur
        ], 201);
    }

    // 🔎 Afficher les détails d’un utilisateur
    public function show($id)
    {
        $utilisateur = User::findOrFail($id);
        return response()->json($utilisateur);
    }

    // ✏️ Modifier un utilisateur
    public function update(Request $request, $id)
    {
        $utilisateur = User::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'sometimes|string',
            'prenom' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'sexe' => 'nullable|in:Homme,Femme',
            'date_naissance' => 'nullable|date',
            'role' => 'nullable|in:admin,medecin,patient',
            'statut' => 'nullable|in:actif,desactive',
            'id_specialite' => 'nullable|exists:specialites,id_specialite', // ✅ spécialité modifiable
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $utilisateur->update($validated);

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user' => $utilisateur
        ]);
    }

    // 🗑️ Supprimer un utilisateur
    public function destroy($id)
    {
        $utilisateur = User::findOrFail($id);
        $utilisateur->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }

    // 🔍 Récupérer tous les médecins d’une spécialité
    public function getMedecinsBySpecialite($id_specialite)
    {
        $medecins = User::where('role', 'medecin')
            ->where('id_specialite', $id_specialite)
            ->get();

        return response()->json($medecins);
    }

    // 🔍 Récupérer tous les patients suivis par un médecin
    public function getPatientsByMedecin($id_medecin)
    {
        $patients = RendezVous::where('id_medecin', $id_medecin)
            ->with('patient') // relation définie dans le modèle RendezVous
            ->get()
            ->pluck('patient') // on extrait uniquement l’objet patient
            ->unique('id');   // éviter les doublons si un patient a plusieurs RDV

        return response()->json($patients);
    }

    // 📊 Statistiques d’un médecin (patients + RDV + notifications)
    public function getMedecinStats($id_medecin)
    {
        // 🔹 Nombre de patients uniques suivis
        $patientsCount = RendezVous::where('id_medecin', $id_medecin)
            ->distinct('id_patient')
            ->count('id_patient');

        // 🔹 Nombre total de rendez-vous
        $rdvCount = RendezVous::where('id_medecin', $id_medecin)->count();

        // 🔹 Nombre de notifications destinées à ce médecin
        // ⚠️ Ici la table notifications contient bien `id_user`
        $notificationsCount = Notification::where('id_user', $id_medecin)->count();

        return response()->json([
            'patients' => $patientsCount,
            'rendezvous' => $rdvCount,
            'notifications' => $notificationsCount
        ]);
    }
}
