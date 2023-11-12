<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelData;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Puesto;
use App\Models\Persona;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request) {
        $file = $request->file('file');
        Log::info('Import excel');
        Excel::import(new ImportExcelData, $file);

        $message ='Datos importados correctamente.';
        $redirectUrl = route('importaciones');
        //return response()->json(['message' => $message]);
        return response()->json(['message' => $message, 'redirect' => $redirectUrl]);
    }
}
