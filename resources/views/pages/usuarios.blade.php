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
                        <button class="btn btn-primary btn-sm " type="button" id="dropdownMenuButton" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
                        <i class="ni ni-fat-add"></i> Añadir Usuario
                        </button>
                    </div>
                </div>
                <!-- ......................................Modal para Planilla------------------------------------------------->
                <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('registrar') }}" enctype="multipart/form-data">
                            <div class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <label for="ci">Buscar por CI:</label>
                                    <input type="text" name="ci" required>
                                    <label for="usuario">Usuario:</label>
                                    <input type="text" name="usuario" required>
                                    <label for="contrasena">Contraseña:</label>
                                    <input type="password" name="contraseña" required>  
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
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
