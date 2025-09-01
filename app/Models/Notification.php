<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Nom de la table (optionnel car Laravel devine "notifications")
    protected $table = 'notifications';

    protected $primaryKey = 'id_notification'; // clé primaire

    protected $fillable = [
        'id_user',
        'id_rdv',
        'type_notification',
        'contenu',
        'lu'
    ];

    // ✅ Relation vers l’utilisateur (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // ✅ Relation vers le rendez-vous
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class, 'id_rdv');
    }
}
