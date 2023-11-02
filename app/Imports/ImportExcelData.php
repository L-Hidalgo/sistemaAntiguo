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
use Maatwebsite\Excel\Concerns\ToModel;

class ImportExcelData implements ToModel
{
    public function model(array $row)
    {
        $gerencia =  new Gerencia([
            'nombre' => $row[3],
        ]);

        $departamento = new Departamento([
            'nombre' => $row[2],
            'gerencia_id' => $gerencia->id
        ]);

        return new Puesto([
            'item' => $row[1],
            'nombre' => $row[4],
            'salario' => $row[5],
            'salarioLiteral' => $row[6],
        ]);

        return new Personal([
            'ci' => $row[7],
            'an' => $row[8],
            'exp' => $row[9],
            'paterno' => $row[10],
            'materno' => $row[11],
            'nombre' => $row[12],
            'nombreApellido' => $row[13],
            'carreraIrregular' => $row[14],
            'formacion' => $row[15],
            'sexo' => $row[16],
            'fechaNacimiento' => $row[17],
            'departamento_id' => $departamento->id,
        ]);

        return new IntegracionDePersonal([
            'fileAc' => $row[18],
            'telefono' => $row[19],
            'fechaInicioSin' => $row[20],
            'fechaInicioCargo' => $row[21],
        ]);

        return new ProcesoDeIncorporacion([
            'propuestos' => $row[22],
            'estado' => $row[23],
            'remitente' => $row[24],
            'fechaAccion' => $row[25],
            'responsable' => $row[26],
            'informeCuadro' => $row[27],
            'fechaInformeCuadro' => $row[28],
            'hpHr' => $row[29],
            'sippase' => $row[30],
            'idioma' => $row[31],
            'fechaMovimiento' => $row[32],
            'nombreMovimiento' => $row[33],
            'itemOrigen' => $row[34],
            'cargoOrigen' => $row[35],
            'memorandum' => $row[36],
            'ra' => $row[37],
            'fechaMermorialRap' => $row[38],
            'sayri' => $row[39],
        ]);

        return new ProcesoDeDesvinculacion([
            'nombre' => $row[40],
            'renunciaRetiro' => $row[41],
            'ultimoDiaTrabajo' => $row[42],
        ]);

        return new RequisitosPuesto([
            'objetivoPuesto' => $row[43],
            'formacion' => $row[44],
            'experienciaProfesionalSegunCargo' => $row[45],
            'experienciaRelacionadaAlAreaFormacion' => $row[46],
            'experienciaEnFuncionesDeMando' => $row[47],
        ]);
    }
}
