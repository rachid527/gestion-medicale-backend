<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('id_utilisateur', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        // Valider et créer un nouvel utilisateur
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    public function update(Request $request, $id)
    {
        // Mettre à jour un utilisateur existant
    }

    public function destroy($id)
    {
        // Supprimer un utilisateur
    }

    // ✅ Marquer une notification comme lue
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->lu = true;
        $notification->save();

        return response()->json(['message' => 'Notification marquée comme lue']);
    }
}
