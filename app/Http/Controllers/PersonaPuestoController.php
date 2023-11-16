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
        $limit = $request->input('limit', 10); 
        $page = $request->input('page', 1); 

        /* ------------------------------------------- FILTROS ------------------------------------------ */
        $item = $request->input('item');
        $gerenciaId = $request->input('gerenciaId');
        $departamentoId = $request->input('departamentoId');
        //$nombreCompleto = $request->input('nombreCompleto');
        $estado = $request->input('estado');
        $tipoMovimiento = $request->input('tipoMovimiento');

        $query = DB::table('personas_puestos')
            ->join('puestos', 'personas_puestos.puesto_id', '=', 'puestos.id')
            ->join('personas', 'personas.id', '=', 'personas_puestos.persona_id')
            ->join('departamentos', 'puestos.departamento_id', '=', 'departamentos.id')
            ->join('proceso_de_incorporaciones', 'puestos.id', '=', 'proceso_de_incorporaciones.puesto_id');

        if(isset($item)) {
           $query = $query->where('puestos.item', $item);
        }
        if(isset($departamentoId)) {
            $query = $query->where('departamentos.id', $departamentoId);
        }
        if(isset($gerenciaId)) {
            $query = $query->where('departamentos.gerencia_id', $gerenciaId);
        }
        /*if(isset($nombreCompleto)) {
            $query = $query->where('personas.nombreCompleto', $nombreCompleto);
        }*/
        if(isset($estado)) {
            $query = $query->where('personas_puestos.estado', $estado);
        }
        if(isset($tipoMovimiento)) {
            $query = $query->where('proceso_de_incorporaciones.tipoMovimiento', $tipoMovimiento);
        }
        
        $query = $query->select(['puestos.denominacion', 'puestos.item', 'personas_puestos.id', 'personas_puestos.estado', 'personas_puestos.persona_id', 'personas.nombreCompleto', 'personas.imagen']);

        $personaPuestos = $query->paginate($limit, ['*'], 'page', $page); // Paginate the personaPuestos

        return response()->json($personaPuestos);
    }

    public function obtenerInfoDePersonapuesto($personaPuestoId) {
        // por completar
    }
}

