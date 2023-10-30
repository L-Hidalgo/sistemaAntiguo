<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = [
        'id',
        'ci',
        'an',
        'exp',
        'paterno',
        'materno',
        'nombre',
        'nombreApellido',
        'carreraIrregular',
        'formacion',
        'sexo',
        'fechaNacimiento'
    ];

    public function puesto()
    {
        return $this->hasOne(Puesto::class);
    }
    
    public function integracionDelPersonal()
    {
        return $this->hasOne(IntegracionDelPersonal::class);
    }

    public function procesoDeIncorporacion()
    {
        return $this->hasOne(ProcesoDeIncorporacion::class);
    }
    
    public function procesoDeDesvinculacion()
    {
        return $this->hasOne(ProcesoDeDesvinculacion::class);
    }

}