<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{

    protected $fillable = [
        'date_rdv',
        'heure_rdv',
        'etat',
        'motif',
        'modifie_par',
        'type_action',
        'date_modification',
        'date_precedente',
        'id_patient',
        'id_medecin',
        'id_specialite'
    ];

    public function patient()
    {
        return $this->belongsTo(Utilisateur::class, 'id_patient');
    }

    public function medecin()
    {
        return $this->belongsTo(Utilisateur::class, 'id_medecin');
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'id_specialite');
    }
}
