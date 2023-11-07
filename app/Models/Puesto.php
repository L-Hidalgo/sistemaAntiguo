<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $fillable = [
        'id',
        'denominacion',
        'objetivo',
        'item',
        'estado',
        'salario',
        'salarioLiteral',
        'departamento_id'  
    ];

    public function departamento() {
        return $this->belongsTo(Departamento::class);
    }

    public function requisito(){
        return $this->belongsToMany(Requisitos::class);
    }

    public function personaPuesto(){
        return $this->hasMany(PersonaPuesto::class);
    }

    public function procesoDeIncorporacion(){
        return $this->hasMany(ProcesoDeIncorporacion::class);
    }

}
