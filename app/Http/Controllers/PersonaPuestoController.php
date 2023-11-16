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

class PersonaPuestoController extends Controller
{
    public function listarPersonaPuesto(Request $request)
    {
        $limit = $request->input('limit', 10); // Default limit of 10 posts per page
        $page = $request->input('page', 1); // Default starting page

        /* ------------------------------------------- FILTROS ------------------------------------------ */
        $gerenciaId = $request->input('gerenciaId');
        $departamentoId = $request->input('departamentoId');
        $item = $request->input('item');

        $query = DB::table('personas_puestos')
        ->join('puestos', 'personas_puestos.puesto_id', '=', 'puestos.id')
        ->join('personas', 'personas.id', '=', 'personas_puestos.persona_id')
        ->join('departamentos', 'puestos.departamento_id', '=', 'departamentos.id');

        if(isset($departamentoId)) {
            $query = $query->where('departamentos.id', $departamentoId);
        }
        if(isset($gerenciaId)) {
          $query = $query->where('departamentos.gerencia_id', $gerenciaId);
        }
        if(isset($item)) {
            $query = $query->where('puestos.item', $item);
          }

        $query = $query->select(['puestos.denominacion', 'puestos.item', 'personas_puestos.id', 'personas_puestos.estado', 'personas_puestos.persona_id', 'personas.nombreCompleto', 'personas.imagen']);

        $personaPuestos = $query->paginate($limit, ['*'], 'page', $page); // Paginate the personaPuestos

        return response()->json($personaPuestos);
    }

    public function obtenerInfoDePersonapuesto($personaPuestoId) {
        // por completar
    }
}

