<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas'; 

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
        'imagen'
    ];

    public function personaPuesto()
    {
        return $this->hasMany(PersonaPuesto::class);
    }

}