@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Importaciones'])
<?php
    use App\Models\Puesto;
    //$puestos = Puesto::all();
    $puestos = Puesto::paginate(10);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items: center;">
                    <h6 style="margin-bottom: 0;">Importación de planilla</h6>
                    <button class="btn btn-primary btn-sm ms-auto" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true" data-toggle="modal" data-target="#modalPlanilla">Guardar datos</button>
                </div>    
                <div class="card-body px-0 pt-0 pb-2">
                    @if ($puestos->isEmpty())
                        <div class="alert" role="alert">
                            <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                            <strong>Importante!</strong> No hay datos importados...
                        </div>
                    @else
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Personal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Posicion</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Migracio</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha de Actualizacion</th>
                                </tr>
                            </thead>
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
                                            <!----------------------------------------------------MOSTRAR INFORMACION DEL PERSONAL--------------------------------------------->
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
                                                                        <img src="/img/team-2.jpg" style="width: 250px; height: 100px;">
                                                                    </div>
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
                                                                <h6 class="modal-title">Datos de la Instition</h6>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>N° de Item:</b> {{$puesto->item}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Cargo:</b> {{$puesto->denominacion}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Salario:</b> {{$puesto->salario}} bs.</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Inicio en el Cargo:</b> {{$personaP->fechaInicio}}</span>
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
                                                                <h6 class="modal-title">Datos de su proceso de Incorporacion</h6>
                                                                <div class="row">
                                                                @foreach($puesto->procesoDeIncorporacion as $proceso)
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Propuesto:</b> {{$proceso->propuestos}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Responsable:</b> {{$proceso->responsable}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Estado:</b> {{$proceso->estado}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Accion:</b> {{$proceso->fechaAccion}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Item Origen:</b> {{$proceso->itemOrigen}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Cargo Origen:</b> {{$proceso->cargoOrigen}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Tipo de Movimiento:</b> {{$proceso->tipoMovimiento}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Movimiento:</b> {{$proceso->fechaMovimiento}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Remitente:</b> {{$proceso->remite}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Informe/Cuadro:</b> {{$proceso->infoCuadro}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha Informe/Cuadro:</b> {{$proceso->fechaInfCuadro}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>hp/hr:</b> {{$proceso->hp_hr}}</span><br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Memorandum:</b> {{$proceso->memorandum}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Ra:</b> {{$proceso->ra}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha Memorandum/Ra:</b> {{$proceso->fechaMemoYRap}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>SIPPASE:</b> {{$proceso->sippase}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>Idioma:</b> {{$proceso->idioma}}</span><br>
                                                                            <span class="text-secondary text-xs font-weight-bold"><b>SAYRI:</b> {{$proceso->sayri}}</span>                       
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
                                            <!--------------------------------------------------------------------------------------------------------------------------------->
                                        </div>
                                        @else
                                            <div>ACEFALIA</div>
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
                                    <span class="text-secondary text-xs font-weight-bold"></span>
                                </td>
                                <td class="align-middle text-center">
                                @foreach($puesto->personaPuesto as $personaP)
                                    <span class="text-secondary text-xs font-weight-bold">{{$personaP->created_at}}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary text-xs font-weight-bold">{{$personaP->updated_at}}</span>
                                @endforeach
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><br>
                    <!-----------------------------------------------------------Paginacion--------------------------------------->
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
                @endif
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info" style="background-color: #fb6340;">Guardar datos</button>
                </div>
            </form>
        </div>
    </div>


    @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
    <span class="alert-text"><strong>Éxito!</strong> {{ session('success') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
    
    @include('layouts.footers.auth.footer')
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                    });
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo salió mal.',
                    });
                }
            });
        });
    });
</script>