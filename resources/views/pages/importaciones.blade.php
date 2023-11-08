@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Importaciones'])
<?php
    use App\Models\Puesto;
    $puestos = Puesto::all();
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items: center;">
                    <h6 style="margin-bottom: 0;">Importación de planilla</h6>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist" style="display: flex;">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true" data-toggle="modal" data-target="#modalPlanilla">
                                <i class="ni ni-folder-17" style="font-size: 1em;"></i>
                                <span class="ms-2" style="font-size: 1em;">Añadir</span>
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Personal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Posicion</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Ingreso</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Migracion</th>
                                </tr>
                            </thead>
                            @if ($puestos->isEmpty())
                                <div>No hay datos importados</div>
                            @else
                            <tbody>
                            @foreach ($puestos as $puesto)
                            <tr>
                                <td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">{{ $puesto->item }}</span></td>
                                <td>
                                @foreach($puesto->personaPuesto as $personaP)
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        @if (isset($personaP))
                                        <div class="d-flex flex-column justify-content-center">
                                            <a data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true" data-toggle="modal" data-target="#modalInformacion{{$personaP->id}}">
                                                <h6 class="mb-0 text-sm">{{$personaP->persona->nombreCompleto}}</h6>
                                            </a>
                                            <p class="text-xs text-secondary mb-0">{{$puesto->denominacion}}</p>
                                            <!--------------------------------------MOSTRAR INFORMACION DEL PERSONAL--------------------------------------------->
                                            <div class="modal" id="modalInformacion{{$personaP->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document" style="max-width: 55%; width: 55%;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Informacion de {{$personaP->persona->nombreCompleto}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h6 class="modal-title">Datos de la Persona</h6>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <img src="/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1" style="width: 100%; max-width: 100%;">
                                                                    </div>
                                                                   <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">Nombre Completo: {{$personaP->persona->nombreCompleto}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">CI.: {{$personaP->persona->ci}} {{$personaP->persona->exp}}.</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Formacion: {{$personaP->formacion}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha de Nacimiento: {{$personaP->persona->fechaNacimiento}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Telefono: {{$personaP->persona->telefono}}</span><br>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                                <hr class="horizontal dark">
                                                                <h6 class="modal-title">Datos de la Instition</h6>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">N° de Item: {{$puesto->item}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Cargo: {{$puesto->denominacion}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Salario: {{$puesto->salario}} bs.</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha de Inicio en el Cargo: {{$personaP->fechaInicio}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">Gerencia: {{$puesto->departamento->gerencia->nombre}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Departamento: {{$puesto->departamento->nombre}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha de Inicio en el SIN: {{$personaP->fechaInicioEnSin}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">Nombre del Antiguo Personal:<br>{{$personaP->nombreCompletoDesvinculacion}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Motivo de Baja: {{$personaP->motivoBaja}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Ultimo dia de Trabajo: {{$personaP->fechaFin}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="horizontal dark">
                                                                <h6 class="modal-title">Datos de su proceso de Incorporacion</h6>
                                                                <div class="row">
                                                                @foreach($puesto->procesoDeIncorporacion as $proceso)
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">Propuesto: {{$proceso->propuestos}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Responsable: {{$proceso->responsable}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Estado: {{$proceso->estado}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha de Accion: {{$proceso->fechaAccion}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Item Origen: {{$proceso->itemOrigen}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Cargo Origen: {{$proceso->cargoOrigen}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">Tipo de Movimiento: {{$proceso->tipoMovimiento}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha de Movimiento: {{$proceso->fechaMovimiento}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Remitente:{{$proceso->remite}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Informe/Cuadro: {{$proceso->infoCuadro}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha Informe/Cuadro: {{$proceso->fechaInfCuadro}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">hp/hr: {{$proceso->hp_hr}}</span><br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold">Memorandum: {{$proceso->memorandum}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Ra: {{$proceso->ra}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Fecha Memorandum/Ra: {{$proceso->fechaMemoYRap}}</span>
                                                                            <span class="text-secondary text-xs font-weight-bold">SIPPASE: {{$proceso->sippase}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">Idioma: {{$proceso->idioma}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold">SAYRI: {{$proceso->sayri}}</span>                       
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            <!----------------------------------------------------------------------------------->
                                        </div>
                                        @else
                                            <div>No hay datos importados</div>
                                        @endif
                                    </div>
                                @endforeach
                                </td>
                                <td>
                                @if(isset($puesto->departamento))
                                    <p class="text-xs font-weight-bold mb-0">{{ $puesto->departamento->gerencia->nombre }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $puesto->departamento->nombre }}</p>
                                @endif
                                </td>
                                <td class="align-middle text-center">
                                @foreach($puesto->personaPuesto as $personaP)
                                    <span class="text-secondary text-xs font-weight-bold">{{$personaP->fechaInicioEnSin}}</span>
                                @endforeach
                                </td>
                                <td class="align-middle"></td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--------------------------------------MODAL PARA AÑADIR--------------------------------------------->
    <div class="modal" id="modalPlanilla" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="{{ route('importaciones') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="modal-header">
                    <h5 class="modal-title">ImportarPlanilla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Planilla:</label>
                                    <div class="custom-file">
                                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .xlsm, .csv, .ods">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Guardar datos</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
    
    
    @include('layouts.footers.auth.footer')
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
