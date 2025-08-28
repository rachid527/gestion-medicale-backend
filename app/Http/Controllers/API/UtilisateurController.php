<?php

namespace App\Http\Controllers\API;

use App\Models\User;
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
            ->whereHas('rendezVousMedecin', function ($query) use ($id_specialite) {
                $query->where('id_specialite', $id_specialite);
            })
            ->get();

        return response()->json($medecins);
    }
}
