<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $primaryKey = 'id_specialite'; // 👈 corrige ici
    protected $fillable = [
        'nom_specialite',
        'description',
        'id_service'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'id_specialite');
    }
}
