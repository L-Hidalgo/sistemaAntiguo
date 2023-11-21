<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class ImportImagesController extends Controller
{
    public function importImagenes(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $archivo = $request->file('file');
                $nombreArchivo = $archivo->getClientOriginalName();
                $directorioDestino = public_path('imagenes_personas');

                $archivo->move($directorioDestino, $nombreArchivo);

                $rutaArchivo = $directorioDestino . '/' . $nombreArchivo;
                // Verificar si es un archivo ZIP
                if (pathinfo($rutaArchivo, PATHINFO_EXTENSION) === 'zip') {
                    $zip = new ZipArchive;
                    if ($zip->open($rutaArchivo) === true) {
                        for ($i = 0; $i < $zip->numFiles; $i++) {
                            $nombreArchivo = $zip->getNameIndex($i);
                            $partesNombre = pathinfo($nombreArchivo);
                            $ci = $partesNombre['filename']; // Extraer el número de CI como parte del nombre del archivo
                            $extension = $partesNombre['extension']; // Obtener la extensión del archivo
                            $persona = Persona::where('ci', $ci)->first();
                            if ($persona) {
                                $nombreImagen = $ci . '.' . $extension;
                                $zip->extractTo(Storage::disk('img_personas')->path('/'), $nombreArchivo);
                                $persona->imagen = $nombreImagen; // Asignar el nombre de la imagen a la persona
                                $persona->save();
                            }
                        }
                        $zip->close();
                    }
                    unlink($rutaArchivo);

                    Alert::success('Éxito', 'Imágenes importadas correctamente.')->persistent(true, true);
                    return redirect()->back();
                } else {
                    Alert::error('Error', 'El archivo no es un archivo ZIP.')->persistent(true, true);
                    return redirect()->back();
                }
            } else {
                Alert::error('Error', 'No se ha proporcionado un archivo.')->persistent(true, true);
                return redirect()->back();
            }
            return redirect()->back()->with('success', 'Imágenes importadas correctamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error: ' . $e->getMessage())->persistent(true, true);
            return redirect()->back();
        }
    }

    public function getImagenPersona($personaId) {
        $persona = Persona::where('id', $personaId)->first();
        if(isset($persona)) {
            $disk = Storage::disk('img_personas');
            $content = $disk->get($persona->imagen);
            $mime = File::mimeType($disk->path($persona->imagen));
            return response($content)->header('Content-Type', $mime);
        } else {
            return response('',404);
        }
    }
}

