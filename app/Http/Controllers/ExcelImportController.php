<?php 

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\IntegracionDelPersonal;
use App\Models\Personal;
use App\Models\ProcesoDeDesvinculacion;
use App\Models\IntegracionDeIncorporacion;
use App\Models\Puesto;
use App\Models\RequisitosPuesto;
use App\Imports\ImportExcelData; 


class ExcelImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        
        Excel::import(new ImportExcelData, $file); 

        return redirect()->back()->with('message', 'Importación completada.');
    }
}
