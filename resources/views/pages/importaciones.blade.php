@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Importaciones'])
<?php
    use App\Models\Puesto;
    //$puestos = Puesto::all();
    $puestos = Puesto::paginate(8);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 style="margin-bottom: 0;">Importación de planilla</h6>
                    <div class="dropdown ms-auto">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-settings-gear-65"></i>  Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#migrarPlanillaModal"><i class="ni ni-folder-17"></i>  Migrar Planilla</a>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#migrarImagenesModal"><i class="ni ni-image"></i>  Migrar Imagenes</a>
                            <a class="dropdown-item">
                                <i class="ni ni-tag"></i>  Buscar Datos
                            </a>
                        </div>
                    </div>
                </div>
                <!-- ......................................Modal para Planilla------------------------------------------------->
                <div class="modal fade" id="migrarPlanillaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <form action="{{ route('importaciones') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                        @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Migrar Planilla</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="archivoPlanilla" class="form-label">Seleccione un archivo .xlsx, .xls, .xlsm, .csv, .ods:</label>
                                        <input type="file" class="form-control" id="archivoPlanilla" name="archivoPlanilla" accept=".xlsx, .xls, .xlsm, .csv, .ods">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Migrar</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <!-- ......................................Modal para Imagenes------------------------------------------------->
                <div class="modal fade" id="migrarImagenesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <form method="POST" action="{{ route('importar.imagenes') }}" enctype="multipart/form-data">>
                        <div class="modal-content">
                        @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Migrar Imagenes</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="directoryInput" class="form-label">Seleccione un archivo .zip:</label>
                                        <input type="file" name="file" class="form-control" accept=".zip">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Migrar</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- ......................................Modal Final------------------------------------------------->
                @if ($puestos->isEmpty())
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="alert" role="alert">
                        <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                        <strong>Importante!</strong> No hay datos importados...
                    </div>
                @else
                    <div class="d-flex flex-wrap">
                    @foreach ($puestos as $puesto)
                        <!-------------------Cards------------------------>
                        <div class="card shadow m-4" style="width: 13rem;">
                        @foreach($puesto->personaPuesto as $personaP)
                            <img src="/img/team-2.jpg" class="card-img-top">
                            @if (isset($personaP))
                            <div class="card-body">
                                <span class="badge rounded-pill bg-primary" data-bs-toggle="modal" data-bs-target="#informacionModal">Detalle</span>
                                <!-- ......................................Modal Detalle------------------------------------------------->
                                <div class="modal fade modal-dialog-scrollable" id="informacionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Perfil de {{$personaP->persona->nombreCompleto}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="modal-title">Datos de la Persona</h6>
                                                <div class="row">
                                                    @if(isset($personaP->persona->imagen))
                                                    <div class="col-md-6">
                                                        <img src="{{ route('imagen-persona', ['personaId' => $personaP->persona->id]) }}" class="img-fluid">
                                                    </div>
                                                    @else
                                                    <div class="col-md-6">
                                                        <img src="/img/team-2.jpg" class="img-fluid">
                                                    </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Nombre Completo:</b> {{$personaP->persona->nombreCompleto}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>CI.:</b> {{$personaP->persona->ci}} {{$personaP->persona->exp}}.</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Formacion:</b> {{$personaP->formacion}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Nacimiento:</b> {{$personaP->persona->fechaNacimiento}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Telefono:</b> {{$personaP->persona->telefono}}</span><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark">
                                                <h6 class="modal-title">Datos como Funcionario</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>N° de Item:</b> {{$puesto->item}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Cargo:</b> {{$puesto->denominacion}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Inicio en el Cargo:</b> {{$personaP->fechaInicio}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Salario:</b> {{$puesto->salario}} bs.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Gerencia:</b> {{$puesto->departamento->gerencia->nombre}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Departamento:</b> {{$puesto->departamento->nombre}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Inicio en el SIN:</b> {{$personaP->fechaInicioEnSin}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Nombre del Antiguo Personal:</b><br>{{$personaP->nombreCompletoDesvinculacion}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Motivo de Baja:</b> {{$personaP->motivoBaja}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Ultimo dia de Trabajo:</b> {{$personaP->fechaFin}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark">
                                                <h6 class="modal-title">Requisitos de formacion</h6>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span class="text-secondary text-xs font-weight-bold"><b>Objetivo del Puesto:</b> {{$puesto->objetivo}}</span>
                                                    </div>
                                                    @foreach ($puesto->requisitosPuesto as $requisitoPuesto)
                                                    <div class="col-md-12">
                                                        @if ($requisitoPuesto->requisito)
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Formacion Requerida:</b> {{$requisitoPuesto->requisito->formacionRequerida}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        @if ($requisitoPuesto->requisito)
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Experiencia Profesional según Cargo:</b> {{$requisitoPuesto->requisito->experienciaProfesionalSegunCargo}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        @if ($requisitoPuesto->requisito)
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Experiencia Relacionado al Área:</b> {{$requisitoPuesto->requisito->experienciaRelacionadoAlArea}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        @if ($requisitoPuesto->requisito)
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Experiencia Relacionado en Función de Mando:</b> {{$requisitoPuesto->requisito->experienciaEnFuncionesDeMando}}</span>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <!-- ......................................Modal------------------------------------------------->
                                <h6 class="mb-0 text-sm card-title">{{$personaP->persona->nombreCompleto}}</h6>
                                <span class="text-secondary text-xs font-weight-bold">{{$puesto->denominacion}}</span>
                            </div>
                            @endif
                        @endforeach
                        </div>
                    @endforeach
                    </div>
                    <!--------------------------------------------Pie de pagina------------------------------------------------------------------>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination ml-auto justify-content-end">
                            <li class="page-item {{ $puestos->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $puestos->previousPageUrl() }}" tabindex="-1" aria-disabled="true"> <- </a>
                            </li>
                            @if ($puestos->currentPage() > 2)
                            <li class="page-item">
                                <a class="page-link" href="{{ $puestos->url(1) }}">1</a>
                            </li>
                             @endif
                             @if ($puestos->currentPage() > 3)
                             <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            @endif
                            @for ($i = max(1, $puestos->currentPage() - 1); $i <= min($puestos->currentPage() + 1, $puestos->lastPage()); $i++)
                            <li class="page-item {{ $i === $puestos->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $puestos->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            @if ($puestos->currentPage() < $puestos->lastPage() - 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            @endif
                            @if ($puestos->currentPage() < $puestos->lastPage() - 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $puestos->url($puestos->lastPage()) }}">{{ $puestos->lastPage() }}</a>
                            </li>
                            @endif
                            <li class="page-item {{ $puestos->currentPage() === $puestos->lastPage() ? 'disabled' : '' }}">
                                 <a class="page-link" href="{{ $puestos->nextPageUrl() }}"> -> </a>
                            </li>
                        </ul>
                    </nav>
                    <!------------------------------------------------------------------------------------->
                </div>
                @endif
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection



