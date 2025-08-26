<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    protected $primaryKey = 'id_dossier';  // clé primaire
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
        return $this->belongsTo(User::class, 'id_patient');
    }
}
