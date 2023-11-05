<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoDeDesvinculacion extends Model
{
    protected $table = 'proceso_de_desvinculaciones';

    protected $fillable = [
        'id', 
        'nombre', 
        'renunciaRetiro',
        'ultimoDiaTrabajo',
        'personal_id'
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
