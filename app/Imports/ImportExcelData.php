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

        // return new IntegracionDePersonal([
        //     'fileAc' => $row[18],
        //     'telefono' => $row[19],
        //     'fechaInicioSin' => $row[20],
        //     'fechaInicioCargo' => $row[21],
        // ]);

        // return new ProcesoDeIncorporacion([
        //     'propuestos' => $row[22],
        //     'estado' => $row[23],
        //     'remitente' => $row[24],
        //     'fechaAccion' => $row[25],
        //     'responsable' => $row[26],
        //     'informeCuadro' => $row[27],
        //     'fechaInformeCuadro' => $row[28],
        //     'hpHr' => $row[29],
        //     'sippase' => $row[30],
        //     'idioma' => $row[31],
        //     'fechaMovimiento' => $row[32],
        //     'nombreMovimiento' => $row[33],
        //     'itemOrigen' => $row[34],
        //     'cargoOrigen' => $row[35],
        //     'memorandum' => $row[36],
        //     'ra' => $row[37],
        //     'fechaMermorialRap' => $row[38],
        //     'sayri' => $row[39],
        // ]);

        // return new ProcesoDeDesvinculacion([
        //     'nombre' => $row[40],
        //     'renunciaRetiro' => $row[41],
        //     'ultimoDiaTrabajo' => $row[42],
        // ]);

        // return new RequisitosPuesto([
        //     'objetivoPuesto' => $row[43],
        //     'formacion' => $row[44],
        //     'experienciaProfesionalSegunCargo' => $row[45],
        //     'experienciaRelacionadaAlAreaFormacion' => $row[46],
        //     'experienciaEnFuncionesDeMando' => $row[47],
        // ]);
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
}
