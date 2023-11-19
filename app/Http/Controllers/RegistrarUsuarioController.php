<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Usuario;

class RegistrarUsuarioController extends Controller
{
    public function mostrarUsuarios()
    {
        return view('registro.usuarios');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'ci' => 'required|exists:personas,ci',
            'usuario' => 'required|unique:users,usuario',
            'contrasena' => 'required|min:6',
        ]);

        // Obtener la persona por su número de cédula
        $persona = Persona::where('ci', $request->input('ci'))->first();

        // Crear el usuario
        User::create([
            'usuario' => $request->input('usuario'),
            'contrasena' => bcrypt($request->input('contrasena')),
            'persona_id' => $persona->id,
        ]);

        return redirect()->route('usuarios')->with('success', 'Registro exitoso');
    }
   
}

