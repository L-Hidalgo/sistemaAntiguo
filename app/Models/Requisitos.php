<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisitos extends Model
{
    protected $fillable = [
        'id',
        'formacionRequerida',
        'experienciaProfesionalSegunCargo',
        'experienciaRelacionadoAlArea',
        'experienciaEnFuncionesDeMando'
    ];

    public function puesto()
    {
        return $this->belongsToMany(Puesto::class);
    }
}
