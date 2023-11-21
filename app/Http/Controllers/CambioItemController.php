<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CambioItemController extends Controller
{
    public function mostrarCambioDeItem()
    {
        
        return view('registrarCambioDeItem');
    }
}
