@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Usuarios'])
<div class="container-fluid py-4">
    <!-- Large modal -->
    <div id="importacion-page" class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 style="margin-bottom: 0;">Usuarios</h6>
                    <div class="dropdown ms-auto">
                        <button class="btn btn-primary btn-sm " type="button" id="dropdownMenuButton" data-bs-toggle="modal" data-bs-target="#migrarPlanillaModal">
                        <i class="ni ni-fat-add"></i> Añadir
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item text-secondary font-weight-bold" data-bs-toggle="modal" data-bs-target="#migrarPlanillaModal"><i class="ni ni-folder-17"></i> Migrar Planilla</a>
                            <a class="dropdown-item text-secondary font-weight-bold" data-bs-toggle="modal" data-bs-target="#migrarImagenesModal"><i class="ni ni-image"></i> Migrar Imagenes</a>
                            <a class="dropdown-item text-secondary font-weight-bold" @click="toggleForm"> <i class="ni ni-tag"></i> Buscar Datos</a>
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
                <!-- ......................................------------------------------------------------------------------------>
                <div v-if="listaPersonaPuesto.length == 0" class="card-body px-0 pt-0 pb-2">
                    <div class="alert" role="alert">
                        <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                        <strong>Importante!</strong> No hay datos importados...
                    </div>
                </div>
                <!----------------------------------------------------------------------------->
                <div class="d-flex flex-wrap">
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection
