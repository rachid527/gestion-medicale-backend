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
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|string|min:6',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'sexe' => 'required|in:Homme,Femme',
            'date_naissance' => 'nullable|date',
            'role' => 'required|in:admin,medecin,patient',
            'statut' => 'in:actif,desactive',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        $utilisateur = Utilisateur::create($validated);

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
            'email' => 'sometimes|email|unique:utilisateurs,email,',
            'mot_de_passe' => 'nullable|min:6',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'sexe' => 'nullable|in:Homme,Femme',
            'date_naissance' => 'nullable|date',
            'role' => 'nullable|in:admin,medecin,patient',
            'statut' => 'nullable|in:actif,desactive',
        ]);

        // Si un nouveau mot de passe est fourni
        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
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
}
