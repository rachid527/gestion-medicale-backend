<?php

namespace App\Models;

use App\Models\User;
use App\Models\Specialite;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    // 👇 corrige le problème de nom de table
    protected $table = 'rendez_vous';

    // clé primaire
    protected $primaryKey = 'id_rdv';

    // champs remplissables
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

    // Relations
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
