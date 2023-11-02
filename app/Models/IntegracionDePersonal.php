<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegracionDePersonal extends Model
{
    protected $fillable = [
        'id',
        'fileAc', 
        'telefono', 
        'fechaInicioSin', 
        'fechaInicioCargo',
        'personal_id',
        'puesto_id'
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
