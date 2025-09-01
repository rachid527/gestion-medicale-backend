<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'adresse',
        'sexe',
        'date_naissance',
        'role',
        'statut',
        'id_specialite',   // ✅ Ajout pour pouvoir assigner une spécialité à un médecin
    ];

    public static array $rules = [
        'prenom' => 'required|string',
        'nom' => 'required|string',
        'email' => 'required|unique:users|string|email',
        'phone' => 'nullable',
        'password' => 'required|string',
        'role' => "required|string|in:admin,patient,medecin",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // ================= Relations Eloquent =================

    // 🔹 Relation avec la spécialité (seulement pour les médecins)
    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'id_specialite');
    }

    // 🔹 Un patient peut avoir plusieurs rendez-vous
    public function rendezVousPatient()
    {
        return $this->hasMany(RendezVous::class, 'id_patient');
    }

    // 🔹 Un médecin peut avoir plusieurs rendez-vous
    public function rendezVousMedecin()
    {
        return $this->hasMany(RendezVous::class, 'id_medecin');
    }

    // 🔹 Un patient a un seul dossier médical
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class, 'id_patient');
    }

    // 🔹 Notifications reçues
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_utilisateur');
    }
}
