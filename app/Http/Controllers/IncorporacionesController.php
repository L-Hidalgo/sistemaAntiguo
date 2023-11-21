<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\PersonaPuesto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class IncorporacionesController extends Controller
{
    public function mostarIncorporaciones()
    {
        return view('incorporaciones');
    }

    public function listarPersonaPuesto(Request $request)
{
    $limit = $request->input('limit', 10);
    $page = $request->input('page', 1);
    $nombreCompleto = $request->input('nombreCompleto');

    $query = DB::table('personas_puestos')
        ->join('puestos', 'personas_puestos.puesto_id', '=', 'puestos.id')
        ->join('personas', 'personas.id', '=', 'personas_puestos.persona_id')
        ->join('departamentos', 'puestos.departamento_id', '=', 'departamentos.id')
        ->join('gerencias', 'departamentos.gerencia_id', '=', 'gerencias.id')
        ->join('proceso_de_incorporaciones', 'puestos.id', '=', 'proceso_de_incorporaciones.puesto_id');

    if ($nombreCompleto) {
        $query = $query->where('personas.nombreCompleto', 'LIKE', '%' . $nombreCompleto . '%');
    }

    $query = $query->select(['puestos.denominacion', 'puestos.item', 'personas_puestos.id', 'personas_puestos.estado', 'personas_puestos.persona_id', 'personas.nombreCompleto', 'personas.imagen', 'departamentos.nombre as departamento', 'gerencias.nombre as gerencia']);

    $personaPuestos = $query->paginate($limit, ['*'], 'page', $page);

    return response()->json($personaPuestos);
}



    public function obtenerInfoDePersonapuesto($personaPuestoId)
    {
        $personaPuesto = PersonaPuesto::with(['persona','puesto.departamento.gerencia', 'puesto.requisitosPuesto.requisito'])->find($personaPuestoId);
        
        return response()->json($personaPuesto);
    }

    public function mostrarCambioDeItem(){
        return view('cambioDeItem');
    }
}