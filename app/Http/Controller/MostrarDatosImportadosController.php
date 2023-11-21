<?php

use App\Models\Persona;
use App\Models\PersonaPuesto;
use App\Models\Puesto;

class PersonaController extends Controller
{
    public function mostrarDatosEnTabla()
    {
        $personas = Persona::with('puestoPersona.puesto')->get();
        return view('tu_vista', compact('personas'));
    }
}
