<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcelData;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Puesto;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request) {
        $file = $request->file('file');
        Log::info('Import excel');
        Excel::import(new ImportExcelData, $file);

        $message ='Datos importados correctamente.';
        return response()->json(['message' => $message]);
        //return redirect()->back()->with('success', 'Datos importados correctamente.');
    }

    public function importImages(Request $request)
    {
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                // Procesar y guardar cada imagen, por ejemplo:
                $imageName = $image->getClientOriginalName();
                $image->storeAs('images', $imageName);
                // Realiza aquí la lógica necesaria para guardar las imágenes en tu directorio.
            }
            return response()->json(['message' => 'Success']);
        }
        return response()->json(['message' => 'No images found'], 400);
    }

}
