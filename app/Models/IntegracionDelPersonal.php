<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegracionDelPersonal extends Model
{
    protected $fillable = [
        'id',
        'fileAc', 
        'telefono', 
        'fechaInicioSin', 
        'fechaInicioCargo',
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
