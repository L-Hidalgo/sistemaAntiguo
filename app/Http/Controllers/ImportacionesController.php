<?php 

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\IntegracionDelPersonal;
use App\Models\Personal;
use App\Models\ProcesoDeDesvinculacion;
use App\Models\IntegracionDeIncorporacion;
use App\Models\Puesto;
use App\Models\RequisitosPuesto;
use Excel;
use Illuminate\Http\Request;

class ImportacionesController extends Controller
{
    public function importExcel(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data = Excel::load($file)->get(); 

            if ($data->count()) {
                foreach ($data as $key => $value) {
                    $departamento = new Departamento();
                    $departamento->conector = $value->conector;
                    $departamento->nombre = $value->nombre;
                    $departamento->save();

                    // Migración a la tabla Gerencia
                    $gerencia = new Gerencia();
                    $gerencia->conector = $value->conector;
                    $gerencia->nombre = $value->nombre;
                    $gerencia->save();

                    // Migración a la tabla IntegracionDelPersonal
                    $integracionDelPersonal = new IntegracionDelPersonal();
                    $integracionDelPersonal->fileAc = $value->fileAc;
                    $integracionDelPersonal->telefono = $value->telefono;
                    $integracionDelPersonal->fechaInicioSin = $value->fechaInicioSin;
                    $integracionDelPersonal->fechaInicioCargo = $value->fechaInicioCargo;
                    $integracionDelPersonal->save();

                    // Migración a la tabla Personal
                    $personal = new Personal();
                    $personal->ci= $value->ci;
                    $personal->an = $value->an;
                    $personal->exp= $value->exp;
                    $personal->paterno = $value->paterno;
                    $personal->materno= $value->materno;
                    $personal->nombre = $value->nombre;
                    $personal->nombreApellido= $value->nombreApellido;
                    $personal->carreraIrregular = $value->carreraIrregular;
                    $personal->formacion= $value->formacion;
                    $personal->sexo = $value->sexo;
                    $personal->fechaNacimiento= $value->fechaNacimiento;
                    $personal->save();

                    // Migración a la tabla proceso de desvinculacion
                    $procesoDeDesvinculacion = new ProcesoDeDesvinculacion();
                    $procesoDeDesvinculacion->nombre = $value->nombre;
                    $procesoDeDesvinculacion->renunciaRetiro = $value->renunciaRetiro;
                    $procesoDeDesvinculacion->ultimoDiaTrabajo = $value->ultimoDiaTrabajo;
                    $procesoDeDesvinculacion->save();

                    // Migración a la tabla proceso de desvinculacion
                    $procesoDeIncorporacion = new ProcesoDeIncorporacion();
                    $procesoDeIncorporacion->propuestos = $value->propuestos;
                    $procesoDeIncorporacion->estado= $value->estado;
                    $procesoDeIncorporacion->remitente = $value->remitente;
                    $procesoDeIncorporacion->fechaAccion = $value->fechaAccion;
                    $procesoDeIncorporacion->responsable= $value->responsable;
                    $procesoDeIncorporacion->informeCuadro = $value->informeCuadro;
                    $procesoDeIncorporacion->fechaInformeCuadro= $value->fechaInformeCuadro;
                    $procesoDeIncorporacion->hpHr = $value->hpHr;
                    $procesoDeIncorporacion->sippase= $value->sippase;
                    $procesoDeIncorporacion->idioma= $value->idioma;
                    $procesoDeIncorporacion->fechaMovimiento = $value->fechaMovimiento;
                    $procesoDeIncorporacion->nombreMovimiento= $value->nombreMovimiento;
                    $procesoDeIncorporacion->itemOrigen = $value->itemOrigen;
                    $procesoDeIncorporacion->cargoOrigen = $value->cargoOrigen;
                    $procesoDeIncorporacion->memorandum= $value->memorandum;
                    $procesoDeIncorporacion->RA = $value->RA;
                    $procesoDeIncorporacion->fechaMemorialRap = $value->fechaMemorialRap;
                    $procesoDeIncorporacion->sayri= $value->sayri;
                    $procesoDeIncorporacion->save();

                    // Migración a la tabla Puesto
                    $puesto = new Puesto();
                    $puesto->nombre = $value->nombre;
                    $puesto->salario = $value->salario;
                    $puesto->salarioLiteral = $value->salarioLiteral;
                    $puesto->save();

                    // Migración a la tabla Requisitps de Puesto
                    $requisitosPuesto = new RequisitosPuesto();
                    $requisitosPuesto->objetivoPuesto = $value->objetivoPuesto;
                    $requisitosPuesto->formacion = $value->formacion;
                    $requisitosPuesto->experienciaProfesionalSegunCargo = $value->experienciaProfesionalSegunCargo;
                    $requisitosPuesto->experienciaRelacionadoAlAreaFormacion = $value->experienciaRelacionadoAlAreaFormacion;
                    $requisitosPuesto->experienciaEnFuncionesDeMando = $value->experienciaEnFuncionesDeMando;
                    $requisitosPuesto->save();
                }
                return "Datos importados correctamente.";
            }
        }

        return "No se pudo importar el archivo.";
    }



}
