<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = [
        'nom_service',
        'description'
    ];

    public function specialites()
    {
        return $this->hasMany(Specialite::class, 'id_service');
    }

    public function disponibilites()
    {
        return $this->hasMany(DisponibiliteService::class, 'id_service');
    }
}
