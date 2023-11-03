<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitosPuesto extends Model
{
    protected $fillable = [
        'id',
        'objetivoPuesto',
        'formacion',
        'experienciaProfesionalSegunCargo',
        'experienciaRelacionadaAlAreaFormacion',
        'ExperienciaEnFuncionesDeMando'
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }
}
