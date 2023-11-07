@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Importaciones'])
    <?php
        use App\Models\Puesto;
        $puestos = Puesto::all();
        // dd($puestos);
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
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false" data-toggle="modal" data-target="#modalDarDeBaja">
                                <i class="ni ni-chart-bar-32" style="font-size: 1em;"></i>
                                <span class="ms-2" style="font-size: 1em;">Dar de Baja</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false" data-toggle="modal" data-target="#modalInformes">
                                <i class="ni ni-chart-bar-32" style="font-size: 1em;"></i>
                                <span class="ms-2" style="font-size: 1em;">Informes</span>
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
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Actualizacion</th>
                                    </tr>
                                </thead>
                                @if ($puestos->isEmpty())
                                    <div>No hay datos importados</div>
                                @else
                                <tbody>
                                    @foreach ($puestos as $puesto)
                                    <tr>
                                    <td>{{ $puesto->item }}</td>
                                        <td>
                                            @foreach($puesto->personaPuesto as $personaP)
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="/img/team-2.jpg" class="avatar avatar-sm me-3"
                                                        alt="user1">
                                                </div>
                                                @if (isset($personaP))
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$personaP->persona->nombreCompleto}}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{$personaP->persona->ci}}</p>
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
                                        <td class="align-middle text-center text-sm"><span class="badge badge-sm bg-gradient-success">Online</span></td>
                                        <td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">23/04/18</span></td>
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
    <!--Modal Para Añadir-->
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
    <!--Modal Para Dar De Baja-->
    <div class="modal" id="#modalDarDeBaja" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dar de Baja Planilla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">De:</label>
                                    <div class="custom-file">
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Hasta:</label>
                                    <div class="custom-file">
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Guardar datos</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
