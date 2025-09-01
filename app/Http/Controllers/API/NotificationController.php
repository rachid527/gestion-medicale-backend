<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * 📌 Récupérer toutes les notifications de l’utilisateur connecté
     */
    public function index(Request $request)
    {
        $user = $request->user(); // utilisateur connecté (via token JWT)

        $notifications = Notification::where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    /**
     * 📌 Récupérer une notification précise
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    /**
     * 📌 Créer une notification (optionnel)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'type_notification' => 'required|string',
            'contenu' => 'required|string',
            'id_rdv' => 'nullable|exists:rendez_vous,id_rdv',
        ]);

        $notification = Notification::create([
            'id_user' => $request->id_user,
            'id_rdv' => $request->id_rdv,
            'type_notification' => $request->type_notification,
            'contenu' => $request->contenu,
            'lu' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification créée avec succès',
            'data' => $notification
        ], 201);
    }

    /**
     * 📌 Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->lu = true;
        $notification->save();

        return response()->json(['message' => 'Notification marquée comme lue']);
    }

    /**
     * 📌 Supprimer une notification
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification supprimée avec succès']);
    }
}
