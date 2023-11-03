<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personales';
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
        'fechaNacimiento',
        'puesto_id'
    ];

    public function puesto()
    {
        return $this->hasOne(Puesto::class);
    }

    public function integracionDePersonal()
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
