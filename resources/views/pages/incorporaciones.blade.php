@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Incorporaciones'])
<div class="container-fluid py-4">
    <!-- Large modal -->
    <div id="importacion-page" class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 style="margin-bottom: 0;">Incorporaciones</h6>
                    <div class="dropdown ms-auto">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-settings-gear-65"></i> Opciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item text-secondary font-weight-bold" data-bs-toggle="modal" data-bs-target="#agregarNuevoPersonalModal"><i class="ni ni-folder-17"></i> Agregar Personal</a>
                            <a class="dropdown-item text-secondary font-weight-bold" data-bs-toggle="modal" data-bs-target="#migrarImagenesModal"><i class="ni ni-image"></i> Migrar Imagenes</a>
                            <a class="dropdown-item text-secondary font-weight-bold" @click="toggleForm"> <i class="ni ni-tag"></i> Buscar Datos</a>
                        </div>
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
                <!-- ......................................------------------------------------------------------------------------>
                <div v-if="listaPersonaPuesto.length == 0" class="card-body px-0 pt-0 pb-2">
                    <div class="alert" role="alert">
                        <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                        <strong>Importante!</strong> No hay datos importados...
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection