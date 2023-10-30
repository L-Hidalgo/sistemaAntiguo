<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $fillable = [
        'id',
        'nombre', 
        'salario',
        'salarioLiteral'
    ];

    public function personal()
    {
        return $this->hasOne(Personsal::class);
    }

    public function requisitosPuesto()
    {
        return $this->hasMany(RequisitosPuesto::class);
    }
}
