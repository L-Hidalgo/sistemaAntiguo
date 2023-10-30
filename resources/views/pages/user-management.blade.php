@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
<!--             <div class="alert alert-light" role="alert">
                 This feature is sdajflkavailable in <strong>Argon Dashboard 2 Pro Laravel</strong>. Check it
                <strong>
                    <a href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank">
                        here
                    </a>
                </strong>
             </div>
 -->            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Lista de Funcionarios Publicos</h6>
                </div>


                <div class="row">

                        <div class="col-6 d-flex align-items-center">
<!--                                 <button type="submit" class="btn btn-primary btn-sm ms-auto nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">Nuevo Usuario
                                 <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                                 
                                </button>
 -->
                                <form role="form"  method="get" action="{{ url('/profile') }}">
                                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Nuevo Usuario</button>
                                </form>

<!--                                 
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
 -->                    </div>


                    <span class="nav-link-text ms-1">Usuarios</span>
                    </a>



                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre y Apellidos</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Roles
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Fecha de Creacion</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Admin</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Admin</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">22/03/2022</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                                class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>

                                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                                class="far fa-trash-alt me-2"></i>Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="./img/team-2.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Creator</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Creator</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">22/03/2022</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                                    class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>

                                                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="./img/team-3.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Member</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Member</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">22/03/2022</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                                    class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>

                                                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
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
@endsection
