<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{

    protected $fillable = [
        'id_patient',
        'groupe_sanguin',
        'allergies',
        'antecedents',
        'poids',
        'remarques'
    ];

    public function patient()
    {
        return $this->belongsTo(Utilisateur::class, 'id_patient');
    }
}
