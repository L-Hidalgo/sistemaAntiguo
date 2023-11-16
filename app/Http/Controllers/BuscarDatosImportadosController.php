<?php
namespace App\Http\Controllers;
use App\Models\PersonaPuesto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuscarDatosImportadosController extends Controller
{
    public function buscarDatosImportados(Request $request)
    {
        $estado = $request->get('buscarpor');

        dd($estado);
        //$personaPuesto = PersonaPuesto::where('estado', 'LIKE', "%$estado%")->paginate(8);
        $personaPuesto = PersonaPuesto::paginate(8);
        return view('importaciones.buscar', compact('personaPuesto'));
    }
}




