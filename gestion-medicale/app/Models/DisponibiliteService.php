<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisponibiliteService extends Model
{

    protected $fillable = [
        'id_service',
        'jour_semaine',
        'heure_debut',
        'heure_fin',
        'estOuvert'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
