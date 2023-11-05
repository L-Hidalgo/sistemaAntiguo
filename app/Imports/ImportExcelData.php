<?php

namespace App\Imports;

use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\IntegracionDePersonal;
use App\Models\Personal;
use App\Models\ProcesoDeDesvinculacion;
use App\Models\ProcesoDeIncorporacion;
use App\Models\Puesto;
use App\Models\RequisitosPuesto;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ImportExcelData implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $gerencia =  $this->migrateGerencia($row[1]);

        $departamento =  $this->migrarDepartamento($row[2], $gerencia->id);

        $puesto = $this->migrarPuesto($row[0], $row[3], $row[4], $row[5]);

        
        /* ------------------------------ NO MIGRAR PERSONAL SI ES ASEFALIA ----------------------------- */
        if($row[9] != 'ACEFALIA' && $row[12] != 'ACEFALIA' && isset($row[6])){
            return new Personal([
                'ci' => $row[6],
                'an' => $row[7],
                'exp' => $row[8],
                'paterno' => $row[9],
                'materno' => $row[10],
                'nombre' => $row[11],
                'nombreApellido' => $row[11].' '.$row[9].' '.$row[10],
                'carreraIrregular' => $row[13],
                'formacion' => $row[14],
                'sexo' => $row[15],
                'fechaNacimiento' => $row[16],
                'departamento_id' => $departamento->id,
                'puesto_id' => $puesto->id,
            ]);
        }

        /*
        $personal = null;

        if ($row[9] != 'ACEFALIA' && $row[12] != 'ACEFALIA' && isset($row[6])) {
            $personal = new Personal([
                'ci' => $row[6],
                'an' => $row[7],
                'exp' => $row[8],
                'paterno' => $row[9],
                'materno' => $row[10],
                'nombre' => $row[11],
                'nombreApellido' => $row[11].' '.$row[9].' '.$row[10],
                'carreraIrregular' => $row[13],
                'formacion' => $row[14],
                'sexo' => $row[15],
                'fechaNacimiento' => $row[16],
                'departamento_id' => $departamento->id,
                'puesto_id' => $puesto->id,
            ]);
        }

        $integracionDePersonal = null;

        if ($personal) {
          /* $integracionDePersonal = new IntegracionDePersonal([
                'telefono' => $row[18],
                'fechaInicioSin' => $row[19], 
                'fechaInicioCargo' => $row[20],
                'personal_id' => $personal->id, 

            ]);
            $integracionDePersonal =$this->migrarIntegracionDePersonal( $row[18], $row[19], $row[20], $personal->id);

        }

        //$integracionDePersonal =$this->migrarIntegracionDePersonal($row[17], $row[18], $row[19], $row[20], $personal->id, $puesto->id);
        
        $procesoDeIncorporacion = $this->migrarProcesoDeIncorporacion($row[21], $row[22], $row[23], $row[24], $row[25], $row[26], $row[27], $row[28], $row[29], $row[30], $row[31], $row[32], $row[33], $row[34], $row[35], $row[36], $row[37], $row[38], $personal->id);
   
        $procesoDeDesvinculacion = $this->migrarProcesoDeDesvinculacion($row[39], $row[40], $row[41], $personal->id);

        $RequisitosPuesto = $this->migrarRequisitosPuesto($row[42], $row[43], $row[44], $row[45], $row[46], $puesto->id);
        */
    }

    /**!SECTION
     * Migrar Gerencia
     */
    public function migrateGerencia($nombre): Gerencia {
        $gerencia = Gerencia::where('nombre', $nombre)->first();
        if(!isset($gerencia)){
            Log::info('Creando gerencia');
            $gerencia = Gerencia::create([
                'nombre' => $nombre,
                // 'conector' => $conector
            ]);
        }
        return $gerencia;
    }

    public function migrarDepartamento($nombre, $gerenciaId): Departamento {
        $departamento = Departamento::where('nombre', $nombre)->where('gerencia_id', $gerenciaId)->first();
        if(!isset($departamento)){
            $departamento = Departamento::create([
                'nombre' => $nombre,
                'gerencia_id' => $gerenciaId,
                // 'conector' => $conector
            ]);
        }
        return $departamento;
    }

    public function migrarPuesto($item, $nombre, $salario, $salarioLiteral): Puesto {
        $puesto = Puesto::where('nombre', $nombre)->where('item', $item)->first();
        if(!isset($puesto)){
            $puesto = Puesto::create([
                'item' => $item,
                'nombre' => $nombre,
                'salario' => $salario,
                'salarioLiteral' => $salarioLiteral,
                // 'conector' => $conector
            ]);
        }
        return $puesto;
    }

    /*
    public function migrarPersonal($ci, $an, $exp, $paterno, $materno, $nombre, $nombreApellido, $carreraIrregular, $formacion, $sexo, $fechaNacimiento, $puesto_id, $departamento_id): Personal {
        $personal = Personal::where('ci', $ci)->where('puesto_id', $puesto_id)->where('departamento_id', $departamento_id)->first();
        if(!isset($personal)){
            $personal = Personal::create([
                'ci' => $ci,
                'an' => $an, 
                'exp' => $exp, 
                'paterno' => $paterno, 
                'materno' => $materno, 
                'nombre' => $nombre, 
                'nombreApellido' => $nombreApellido, 
                'carreraIrregular' => $carreraIrregular, 
                'formacion' => $formacion, 
                'sexo' => $sexo, 
                'fechaNacimiento' => $fechaNacimiento, 
                'puesto_id' => $puesto_id, 
                'departamento_id' => $departamento_id,
            ]);
        }
        return $personal;
    }

    
    public function migrarIntegracionDePersonal( $telefono, $fechaInicioSin, $fechaInicioCargo, $personalId): IntegracionDePersonal {
        $integracionDePersonal = IntegracionDePersonal::where('telefono', $telefono)->where('personal_id', $personalId)->first();
        if(!isset($integracionDePersonal)){
            $integracionDePersonal = IntegracionDePersonal::create([
                'telefono' => $telefono, 
                'fechaInicioSin' => $fechaInicioSin, 
                'fechaInicioCargo' => $fechaInicioCargo, 
                'personal_id' => $personalId, 
            ]);
        }
        return $integracionDePersonal;
    }

    public function migrarProcesoDeIncorporacion($propuestos, $estado, $remitente, $fechaAccion, $responsable, $informeCuadro, $fechaInformeCuadro, $hpHr, $sippase, $idioma, $fechaMovimiento, $nombreMovimiento, $itemOrigen, $cargoOrigen, $memorandum, $ra, $fechaMermorialRap, $sayri, $personalId): ProcesoDeIncorporacion {
        $procesoDeIncorporacion = ProcesoDeIncorporacion::where('propuestos', $propuestos)->where('personal_id', $personalId)->where('puesto_id', $puestoId)->first();
        if(!isset($procesoDeIncorporacion)){
            $procesoDeIncorporacion = ProcesoDeIncorporacion::create([
                'propuestos' => $propuestos, 
                'estado' => $estado, 
                'remitente' => $remitente, 
                'fechaAccion' => $fechaAccion, 
                'responsable' => $responsable, 
                'informeCuadro' => $informeCuadro, 
                'fechaInformeCuadro' => $fechaInformeCuadro,
                'hpHr' => $hpHr, 
                'sippase' => $sippase, 
                'idioma' => $idioma, 
                'fechaMovimiento' => $fechaMovimiento, 
                'nombreMovimiento' => $nombreMovimiento, 
                'itemOrigen' => $itemOrigen, 
                'cargoOrigen' => $cargoOrigen, 
                'memorandum' => $memorandum, 
                'ra' => $ra, 
                'fechaMermorialRap' => $fechaMermorialRap,
                'sayri' => $sayri,
                'personal_id' => $personalId
            ]);
        }
        return $procesoDeIncorporacion;
    }

    public function migrarProcesoDeDesvinculacion($nombre, $renunciaRetiro, $ultimoDiaTrabajo, $personalI): ProcesoDeDesvinculacion {
        $procesoDeDesvinculacion = ProcesoDeDesvinculacion::where('nombre', $nombre)->where('personal_id', $personalId)->first();
        if(!isset($procesoDeDesvinculacion)){
            $procesoDeDesvinculacion = ProcesoDeDesvinculacion::create([
                'fileAc' => $fileAc, 
                'telefono' => $telefono, 
                'fechaInicioSin' => $fechaInicioSin, 
                'fechaInicioCargo' => $fechaInicioCargo, 
                'personal_id' => $personalId
            ]);
        }
        return $procesoDeDesvinculacion;
    }

    public function migrarRequisitosPuesto($objetivoPuesto, $formacion, $experienciaProfesionalSegunCargo, $experienciaRelacionadaAlAreaFormacion, $experienciaEnFuncionesDeMando, $puestoId): RequisitosPuesto {
        $requisitosPuesto = RequisitosPuesto::where('objetivoPuesto', $objetivoPuesto)->where('puesto_id', $puestoId)->first();
        if(!isset($requisitosPuesto)){
            $requisitosPuesto = RequisitosPuesto::create([
                'objetivoPuesto' => $objetivoPuesto, 
                'formacion' => $formacion, 
                'experienciaProfesionalSegunCargo' => $experienciaProfesionalSegunCargo, 
                'experienciaRelacionadaAlAreaFormacion' => $experienciaRelacionadaAlAreaFormacion, 
                'experienciaEnFuncionesDeMando' => $experienciaEnFuncionesDeMando, 
                'puesto_id' => $puestoId
            ]);
        }
        return $requisitosPuesto;
    }*/
   
    
}
