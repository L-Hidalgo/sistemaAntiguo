<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonaPuesto;

class PersonaPuestoController extends Controller
{
    public function buscarDatos(Request $request)
    {
        $item = $request->input('item');
        $estado = $request->input('estado');
        $tipoMovimiento = $request->input('tipoMovimiento');

        $query = PersonaPuesto::query();

        if ($item) {
            $query->whereHas('puesto', function ($q) use ($item) {
                $q->where('item', 'LIKE', "%$item%");
            });
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        if ($tipoMovimiento) {
            $query->whereHas('puesto.procesoDeIncorporacion', function (Builder $q) use ($tipoMovimiento) {
                $q->where('tipoMovimiento', $tipoMovimiento);
            });
        }

        $resultados = $query->paginate(8);

        return response()->json($resultados);
    }
}




