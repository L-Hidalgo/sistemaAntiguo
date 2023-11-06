<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'id',
        'ci',
        'an',
        'exp',
        'nombres',
        'primerApellido',
        'segundoApellido',
        'nombreCompleto',
        'sexo',
        'fechaNacimiento',
        'telefono',
    ];

    public function personaPuesto()
    {
        return $this->hasMany(PersonaPuesto::class);
    }

    public function contactoPersona()
    {
        return $this->hasMany(ContactoPersona::class);
    }
}