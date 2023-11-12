<?php

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;

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
                            $ci = (int)$partesNombre['filename']; // Extraer el número de CI como parte del nombre del archivo
                            $extension = $partesNombre['extension']; // Obtener la extensión del archivo
    
                            $persona = Persona::where('ci', $ci)->first();
                            if ($persona) {
                                $nombreImagen = $ci . '.' . $extension; // Nombre final de la imagen a guardar
                                $zip->extractTo($directorioDestino, $nombreArchivo);
                                $nuevoNombreArchivo = $directorioDestino . '/' . $nombreArchivo;
                                $nuevoNombreImagen = $directorioDestino . '/' . $nombreImagen;
                                rename($nuevoNombreArchivo, $nuevoNombreImagen);
                                $persona->imagen = $nombreImagen; // Asignar el nombre de la imagen a la persona
                                $persona->save();
                            }
                        }
                        $zip->close();
                    }
                    // Eliminar el archivo ZIP después de extraer las imágenes
                    unlink($rutaArchivo);
    
                    return redirect()->back()->with('success', 'Imágenes importadas correctamente.');
                } else {
                    return redirect()->back()->with('error', 'El archivo no es un archivo ZIP.');
                }
            } else {
                return redirect()->back()->with('error', 'No se ha proporcionado un archivo.');
            }   
            return redirect()->back()->with('success', 'Imágenes importadas correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
   
    }
}

