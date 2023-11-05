<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegracionDePersonal extends Model
{
    protected $table = 'integracion_de_personales';

    protected $fillables = [
        'id',
        'fileAc', 
        'telefono', 
        'fechaInicioSin', 
        'fechaInicioCargo',
        'personal_id'
    ];

    public function personal()
    {
        return $this->hasOne(Personal::class);
    }

    public function puesto()
    {
        return $this->hasMany(Puesto::class);
    }
}
