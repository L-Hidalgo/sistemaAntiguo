<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use App\Models\Persona;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelData;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Validators\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request) {
        try {
            $file = $request->file('archivoPlanilla'); 
            Log::info('El controlador import excel');
            Excel::import(new ImportExcelData, $file);

            Alert::success('Importación completada', 'La importación se ha realizado con éxito.')->persistent(true, true);
        } catch (ValidationException $e) {
            $failures = $e->failures(); 
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Fila {$failure->row()}: {$failure->errors()[0]}";
            }

            Alert::error('Error en la importación', implode('<br>', $errorMessages))->persistent(true, true);
        } catch (\Exception $e) {
            Alert::error('Error en la importación', 'Se ha producido un error durante la importación.')->persistent(true, true);
        }

        return redirect()->back();
    }
}








