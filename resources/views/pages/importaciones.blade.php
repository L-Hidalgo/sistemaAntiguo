@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Importaciones'])
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
                            <a class="nav-link mb-0 px-0 py-1 align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Nombre</th>                                        
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Fecha</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Estado</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                     <td>
                                        <div class="d-flex px-2 py-1">
                                            <h6 class="mb-0 text-sm">Spotify</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">15/07/2023</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">Estable</span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
                                                <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Actualizar
                                            </a>
                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                                                <i class="far fa-trash-alt me-2"></i>Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <h6 class="mb-0 text-sm">Spotify</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">15/07/2023</p>
                                    </td>                                        
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-secondary">Desestable</span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
                                                <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Actualizar
                                            </a>
                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                                                <i class="far fa-trash-alt me-2"></i>Eliminar
                                            </a>
                                        </div>                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalPlanilla" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
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
  <input type="file" class="custom-file-input" id="customFileLang" lang="es">
  <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
</div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
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