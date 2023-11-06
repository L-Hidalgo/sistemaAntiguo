<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactoPersona extends Model
{
    protected $fillable = [
        'id',
        'persona_id',
        'contacto_id',
        'estado'
    ];
}