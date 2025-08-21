<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'id_utilisateur',
        'id_rdv',
        'type_notification',
        'contenu',
        'lu'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class, 'id_rdv');
    }
}
