<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelData;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Puesto;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request) {
        $file = $request->file('file');
        Log::info('El controlador import excel');
        Excel::import(new ImportExcelData, $file);

        return redirect()->back()->with('message', 'Importación completada.');
    }

    /*public function mostrarDatosEnTabla(){
        $puestos = Puesto::all();
        return view('importaciones', ['puestos'->$puestos]);
    }*/

}
