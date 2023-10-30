<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desvinculacion extends Model
{
    protected $fillable = [
        'id', 
        'nombre', 
        'renunciaRetiro',
        'ultimoDiaTrabajo'
    ];

    public function personal()
    {
        return $this->hasOne(Personal::class);
    }

    public function puesto()
    {
        return $this->hasOne(Puesto::class);
    }


}
