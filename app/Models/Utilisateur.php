<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Utilisateur extends Authenticatable  implements JWTSubject
{
    // Champs autorisés à l'insertion/modification
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'telephone',
        'adresse',
        'sexe',
        'date_naissance',
        'role',
        'statut'
    ];

    public static array $rules = [
        'prenom' => 'required|string',
        'nom' => 'required|string',
        'email' => 'required|unique:users|string|email',
        'phone' => 'nullable',
        'mot_de_passe' => 'required|string',
    ];

    // 🔐 Méthodes obligatoires pour JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relations Eloquent

    // Un patient peut avoir plusieurs rendez-vous
    public function rendezVousPatient()
    {
        return $this->hasMany(RendezVous::class, 'id_patient');
    }

    // Un médecin peut avoir plusieurs rendez-vous
    public function rendezVousMedecin()
    {
        return $this->hasMany(RendezVous::class, 'id_medecin');
    }

    // Un patient a un seul dossier médical
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class, 'id_patient');
    }

    // Notifications reçues
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_utilisateur');
    }
}
