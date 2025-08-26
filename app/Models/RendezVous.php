<?php

namespace App\Models;

use App\Models\User;        // 🔹 importer User correctement
use App\Models\Specialite;  // 🔹 importer Specialite aussi

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    protected $primaryKey = 'id_rdv';  // clé primaire
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
        return $this->belongsTo(User::class, 'id_patient');
    }

    public function medecin()
    {
        return $this->belongsTo(User::class, 'id_medecin');
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'id_specialite');
    }
}
