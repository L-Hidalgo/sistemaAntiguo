<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    protected $fillable = [
        'id',
        'conector', 
        'nombre'];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

}
