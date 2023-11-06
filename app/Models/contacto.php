<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable = [
        'id',
        'numero',
        'tipo',
        'descripcion'
    ];

    public function contactoPersona()
    {
        return $this->hasMany(ContactoPersona::class);
    }

}