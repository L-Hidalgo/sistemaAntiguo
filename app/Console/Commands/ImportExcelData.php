<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\IntegracionDelPersonal;
use App\Models\Personal;
use App\Models\ProcesoDeDesvinculacion;
use App\Models\ProcesoDeIncorporacion;
use App\Models\Puesto;
use App\Models\RequisitosPuesto;

class ImportExcelData extends Command
{
    protected $signature = 'import:excel';

    protected $description = 'Importar datos de Excel a la base de datos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $excelData = Excel::toCollection('ruta/del/archivo/excel.xlsx')->first(); // Reemplaza 'ruta/del/archivo/excel.xlsx' con la ruta de tu archivo Excel

        foreach ($excelData as $row) {
            $gerencia = Gerencia::firstOrCreate(['nombre' => $row['GERENCIA']]);
            $departamento = Departamento::firstOrCreate(['nombre' => $row['DEPARTAMENTO']]);
            $puesto = Puesto::create([
                'denominacion' => $row['DENOMINACIÓN DEL PUESTO'],
                'salario' => $row['salario'],
                'salario_literal' => $row['salario_literal'],
                'departamento_id' => $departamento->id,
                'gerencia_id' => $gerencia->id
            ]);
        }

        $this->info('Data imported successfully.');
    }
}
