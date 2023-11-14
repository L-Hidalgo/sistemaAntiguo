<?php

namespace App\Imports;

use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\Persona;
use App\Models\PersonaPuesto;
use App\Models\ProcesoDeIncorporacion;
use App\Models\Puesto;
use App\Models\RequisitosPuesto;
use App\Models\Requisitos;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ImportExcelData implements ToModel, WithStartRow
{

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $gerencia =  $this->migrateGerencia($row[1]);

        $departamento =  $this->migrarDepartamento($row[2], $gerencia->id);

        $persona = $this->migrarPersona($row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[11] . ' ' . $row[9] . ' ' . $row[10], $row[15], $row[16], $row[18]);

        $puesto = $this->migrarPuesto($row[0], $row[3], $row[4], $row[5], $row[42], $departamento->id);

        $personaPuesto = $this->migrarPersonaPuesto($row[13], $row[14], $row[0] . ' ' . $row[6] , $row[19], $row[20], $row[39], $row[40], $row[41], $row[9], $puesto->id, $persona->id);
        
        $procesoDeIncorporacion = $this->migrarProcesoDeIncorporacion($row[21], $row[22], $row[23], $row[24], $row[25], $row[26], $row[27], $row[28], $row[29], $row[30], $row[31], $row[32], $row[33], $row[34], $row[35], $row[36], $row[37], $row[38], $puesto->id);
   
        $requisitos = $this->migrarRequisitos($row[43], $row[44], $row[45], $row[46]);

        $requisitoPuesto = $this->migrarRequisitosPuesto($puesto->id, $requisitos->id);

    }

    /**!SECTION
     * Migrar Gerencia
     */
    public function migrateGerencia($nombre): Gerencia {
        $gerencia = Gerencia::where('nombre', $nombre)->first();
        if(!isset($gerencia)){
            $gerencia = Gerencia::create([
                'nombre' => $nombre
            ]);
        }
        return $gerencia;
    }

    public function migrarDepartamento($nombre, $gerenciaId): Departamento {
        $departamento = Departamento::where('nombre', $nombre)->where('gerencia_id', $gerenciaId)->first();
        if(!isset($departamento)){
            $departamento = Departamento::create([
                'nombre' => $nombre,
                'gerencia_id' => $gerenciaId
            ]);
        }
        return $departamento;
    }

    public function migrarPersona($ci, $an, $exp, $primerApellido, $segundoApellido, $nombres, $nombreCompleto, $sexo, $fechaNacimiento, $telefono): Persona {
        $persona = Persona::where('ci', $ci)->first();
        if (!isset($persona)) {
            $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($fechaNacimiento);
            $fechaNacimiento = Carbon::createFromTimestamp($timestamp)->format('Y-m-d');
            $persona = Persona::create([
                'ci' => $ci,
                'an'=> $an,
                'exp'=> $exp,
                'primerApellido'=> $primerApellido,
                'segundoApellido'=> $segundoApellido,
                'nombres'=> $nombres,
                'nombreCompleto' => $nombres . ' ' . $primerApellido . ' ' . $segundoApellido,
                'sexo'=> $sexo,
                'fechaNacimiento'=> $fechaNacimiento,
                'telefono'=> $telefono
            ]);
        }
        return $persona;
    }

    public function migrarPuesto($item, $denominacion, $salario, $salarioLiteral, $objetivo, $departamentoId): Puesto {
        $puesto = Puesto::where('denominacion', $denominacion)->where('item', $item)->where('departamento_id', $departamentoId)->first();
        if(!isset($puesto)){
            $puesto = Puesto::create([
                'item' => $item,
                'denominacion' => $denominacion,
                'salario' => $salario,
                'salarioLiteral' => $salarioLiteral,
                'objetivo' => $objetivo,
                'departamento_id' => $departamentoId
            ]);
        }
        return $puesto;
    }  

    public function migrarPersonaPuesto($estadoFormacion, $formacion, $fileAc, $fechaInicioEnSin, $fechaInicio, $nombreCompletoDesvinculacion, $motivoBaja, $fechaFin, $estado, $puestoId, $personaId): PersonaPuesto {
        $persona = Persona::find($personaId);
        $puesto = Puesto::find($puestoId);

        if (!$persona || !$puesto) {
            return null;
        }

        $fileAc = $puesto->item . '-' . $persona->ci;

        if ($estado === 'ACEFALIA') {
            $estado = 'Desocupado';
        } else {
            $estado = 'Ocupado';
        }

        $personaPuesto = PersonaPuesto::where('estadoFormacion', $estadoFormacion)
            ->where('puesto_id', $puestoId)
            ->where('persona_id', $personaId)
            ->first();
    
        if (!isset($personaPuesto)) {
            $timestampFechaInicioEnSin = is_numeric($fechaInicioEnSin) ? $fechaInicioEnSin : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($fechaInicioEnSin);
            $fechaInicioEnSin = Carbon::createFromTimestamp($timestampFechaInicioEnSin)->format('Y-m-d');

            $timestampFechaInicio = is_numeric($fechaInicio) ? $fechaInicio : (is_numeric($fechaInicio) ? $fechaInicio : strtotime($fechaInicio));
            $timestampFechaInicio = is_numeric($timestampFechaInicio) ? $timestampFechaInicio : 0;
            $fechaInicio = Carbon::createFromTimestamp($timestampFechaInicio)->format('Y-m-d');

            $timestampFechaFin = is_numeric($fechaFin) ? $fechaFin : (is_numeric($fechaFin) ? $fechaFin : strtotime($fechaFin));
            $timestampFechaFin = is_numeric($timestampFechaFin) ? $timestampFechaFin : 0;
            $fechaFin = Carbon::createFromTimestamp($timestampFechaFin)->format('Y-m-d');

            $personaPuesto = PersonaPuesto::create([
                'estadoFormacion' => $estadoFormacion,
                'formacion' => $formacion,
                'fileAc' => $fileAc,
                'fechaInicioEnSin' => $fechaInicioEnSin,
                'fechaInicio' => $fechaInicio,
                'nombreCompletoDesvinculacion' => $nombreCompletoDesvinculacion,
                'motivoBaja' => $motivoBaja,
                'fechaFin' => $fechaFin,
                'estado' => $estado,
                'puesto_id' => $puestoId,
                'persona_id' => $personaId
            ]);
        }
        return $personaPuesto;
    }
    
    public function migrarProcesoDeIncorporacion($propuestos, $estado, $remitente, $fechaAccion, $responsable, $informeCuadro, $fechaInformeCuadro, $hpHr, $sippase, $idioma, $fechaMovimiento, $tipoMovimiento, $itemOrigen, $cargoOrigen, $memorandum, $ra, $fechaMermorialRap, $sayri, $puestoId): ProcesoDeIncorporacion {
        $procesoDeIncorporacion = ProcesoDeIncorporacion::where('propuestos', $propuestos)->where('puesto_id', $puestoId)->first();
    
        if (!isset($procesoDeIncorporacion)) {
            $timestampFechaAccion = is_numeric($fechaAccion) ? $fechaAccion : strtotime($fechaAccion);
            $fechaAccion = Carbon::createFromTimestamp($timestampFechaAccion)->format('Y-m-d');
    
            $timestampFechaInformeCuadro = is_numeric($fechaInformeCuadro) ? $fechaInformeCuadro : strtotime($fechaInformeCuadro);
            $fechaInformeCuadro = Carbon::createFromTimestamp($timestampFechaInformeCuadro)->format('Y-m-d');
    
            $timestampFechaMovimiento = is_numeric($fechaMovimiento) ? $fechaMovimiento : strtotime($fechaMovimiento);
            $fechaMovimiento = Carbon::createFromTimestamp($timestampFechaMovimiento)->format('Y-m-d');
    
            $timestampFechaMermorialRap = is_numeric($fechaMermorialRap) ? $fechaMermorialRap : strtotime($fechaMermorialRap);
            $fechaMermorialRap = Carbon::createFromTimestamp($timestampFechaMermorialRap)->format('Y-m-d');
    
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
                'tipoMovimiento' => $tipoMovimiento,
                'itemOrigen' => $itemOrigen,
                'cargoOrigen' => $cargoOrigen,
                'memorandum' => $memorandum,
                'ra' => $ra,
                'fechaMermorialRap' => $fechaMermorialRap,
                'sayri' => $sayri,
                'puesto_id' => $puestoId,
            ]);
        }
    
        return $procesoDeIncorporacion;
    }
    
    public function migrarRequisitos($formacionRequerida, $experienciaProfesionalSegunCargo, $experienciaRelacionadoAlArea, $experienciaEnFuncionesDeMando): Requisitos {
        $requisitos = Requisitos::where('formacionRequerida', $formacionRequerida)->first();
        if(!isset($requisitos)){
            $requisitos = Requisitos::create([
                'formacionRequerida' => $formacionRequerida,
                'experienciaProfesionalSegunCargo' => $experienciaProfesionalSegunCargo,
                'experienciaRelacionadoAlArea' => $experienciaRelacionadoAlArea,
                'experienciaEnFuncionesDeMando' => $experienciaEnFuncionesDeMando
            ]);
        }
        return $requisitos;
    }
    
    public function migrarRequisitosPuesto($puestoId, $requisitoId): RequisitosPuesto {
        $requisitoPuesto = RequisitosPuesto::where('puesto_id', $puestoId)->where('requisito_id', $requisitoId)->first();
        if(!isset($requisitoPuesto)){
            $requisitoPuesto = RequisitosPuesto::create([
                'puesto_id' => $puestoId,
                'requisito_id' => $requisitoId
            ]);
        }
        return $requisitoPuesto;
    }
}
