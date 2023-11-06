<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\ImportExcelData;
use Illuminate\Support\Facades\Log;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        Log::info('El controlador import excel');
        Excel::import(new ImportExcelData, $file);

        return redirect()->back()->with('message', 'Importación completada.');
    }
}
