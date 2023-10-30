<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'id',
        'conector', 
        'nombre'
    ];

    public function gerencia()
    {
        return $this->belongsTo(Gerencia::class);
    }

    public function personal()
    {
        return $this->hasMany(Personal::class);
    }
}


