@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Incorporaciones'])
<?php
use App\Models\Departamento;
use App\Models\Gerencia;

$gerencias = Gerencia::all();
$departamentos = Departamento::all();
?>

<div class="container-fluid py-4">
    <div id="importacion-page" class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 style="margin-bottom: 0;">Incorporaciones</h6>
                    <div class="search-form form-inline float-right d-flex ms-auto" style="margin-left: 10px; display: flex; flex-direction: row;">
                        <input class="form-control text-secondary text-xs font-weight-bold" type="text" v-model="nombreCompleto" placeholder="Buscar por nombre..." style="width: 100%; height: 5%; margin-left: 15px;">
                        <button class="btn btn-primary" @click="onFilter()" style="border-radius: 50%; padding: 5px; cursor: pointer; margin-left: 20px; margin-right: 20px;"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div v-if="listaPersonaPuesto.length == 0" class="card-body px-0 pt-0 pb-2">
                    <div class="alert" role="alert">
                        <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                        <strong>Importante!</strong> No hay datos importados...
                    </div>
                </div>
             <!------------------------------------------------------------------------------------------------>
             <div class="card-body pb-0">
                <div class="d-flex flex-wrap">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Persona</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Institucion</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="personaP in listaPersonaPuesto">
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">@{{personaP.item}}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img v-if="personaP.imagen" :src="'/imagen-persona/' + personaP.persona_id" class="avatar avatar-sm me-3">
                                                    <img v-else src="/img/team-2.jpg" class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">@{{personaP.nombreCompleto}}</h6>
                                                    <p class="text-xs text-secondary mb-0">@{{personaP.denominacion}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">@{{personaP.gerencia}}</p>
                                            <p class="text-xs text-secondary mb-0">@{{personaP.departamento}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span v-if="personaP.estado == 'Ocupado'" class="badge rounded-pill bg-success" style="font-size: 0.5em;">@{{personaP.estado}}</span>
                                            <span v-else class="badge rounded-pill bg-danger" style="font-size: 0.5em;">@{{personaP.estado}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-danger" style="padding: 5px; cursor: pointer; margin-left: 20px; margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#cambioItemModal">
                                                <i class="ni ni-badge"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </diV>
              <!-- ......................................Modal para Planilla------------------------------------------------->
              <div class="modal fade my-vue-modal" id="cambioItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form  enctype="multipart/form-data">
                            <div class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cambio de Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Nuevo Item</label>
                                                <input class="form-control" type="text" value="74">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Estado</label>
                                                <input class="form-control" type="text" value="Acefalia" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Quien Ocupa?</label>
                                                <input class="form-control" type="text" value="Marca" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Institucion</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Gerencia</label>
                                                <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                    <option selected>Selecciona una opción</option>
                                                    <option value="opcion1">Presidencia Ejecutiva</option>
                                                </select>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Departamento</label>
                                                <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                    <option selected>Selecciona una opción</option>
                                                    <option value="opcion1">AUDITORIA INTERNA</option>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Requisitos</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Exp. Profecional</th>
                                                        <th scope="col">Exp. Especifica</th>
                                                        <th scope="col">Exp. Mando</th>
                                                        <th scope="col">Formacion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Ninguna</td>
                                                        <td>Ninguna</td>
                                                        <td>Ninguna</td>
                                                        <td>Secretaria Ejecutiva entre otras</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Si</option>
                                                                <option value="opcion1">No</option>
                                                                <option value="opcion1">Corresponde</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Si</option>
                                                                <option value="opcion1">No</option>
                                                                <option value="opcion1">Corresponde</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Si</option>
                                                                <option value="opcion1">No</option>
                                                                <option value="opcion1">Corresponde</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Cumple</option>
                                                                <option value="opcion1">No Cumple</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Datos de la Persona</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Genero</th>
                                                        <th scope="col">Nombre Completo</th>
                                                        <th scope="col">CI</th>
                                                        <th scope="col">Exp</th>
                                                        <th scope="col">Carrera</th>
                                                        <th scope="col">Grado Academico</th>
                                                        <th scope="col">Universidad</th>
                                                        <th scope="col">Aña de Conclusion</th>
                                                        <th scope="col">Respaldo?</th>
                                                        <th scope="col">Fecha de Incorporacion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Masculino</option>
                                                                <option value="opcion1">Femenido</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="pedro" disabled>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="123" disabled>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="U" disabled>
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Auditoria</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Licenciatura</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Tomas Frias</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="2020">
                                                        </td>
                                                        <td>
                                                            <select class="form-select" id="exampleSelect" aria-label="Selecciona una opción">
                                                                <option value="opcion1">Si</option>
                                                                <option value="opcion1">No</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="date" value="2020">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Nota Minuta</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Hp</th>
                                                        <th scope="col">Cite (Minuta/Nota)</th>
                                                        <th scope="col">Codigo (Minuta)</th>
                                                        <th scope="col">Fecha (Minuta/Nota)</th>
                                                        <th scope="col">Fecha Recepcion (Nota)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" type="text" value="GRH-HP-734-2022" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="259" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="022200000258" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="date" value="27/06/2022" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Informe</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">CITE</th>
                                                        <th scope="col">FECHA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" type="text" value="412" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="date" value="07/07/2022" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Memorandum</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">CITE</th>
                                                        <th scope="col">CODIGO</th>
                                                        <th scope="col">FECHA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" type="text" value="2062" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="082200005400" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="date" value="07/07/2022" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">RAP</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">CITE</th>
                                                        <th scope="col">CODIGO</th>
                                                        <th scope="col">FECHA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" type="text" value="216" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="032200000489" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="date" value="07/07/2022" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">CAMBIO DE ITEM</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Item Actual</th>
                                                        <th scope="col">Gerencia</th>
                                                        <th scope="col">Departamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" type="text" value="74" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="GTIC" >
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="DID" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Referencias</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Referencia para el cite en informe de SIAT(Incorporaciones)</label>
                                                <input class="form-control" type="text" value="Evaluación curricular para designación como &$REGISTRO.B41& &$REGISTRO.B39&" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Referencia para el cite en informe de SIAT(Cambio de Item)</label>
                                                <input class="form-control" type="text" value="Evaluación curricular para designación como &$REGISTRO.B41& &$REGISTRO.B39&" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <!--------------------------------------------Pie de pagina------------------------------------------------------------------>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li :class="{'page-item': true, disabled: page == 1}">
                            <a class="page-link" aria-disabled="true" @click="onPaginate(page -1)"> <- </a>
                        </li>
                        <li v-if="page>3" class="page-item">
                            <a class="page-link" @click="onPaginate(1)">1</a>
                        </li>
                        <li v-if="page > 4" class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li v-for="i in 5" :class="{'page-item': true, 'active': (page - (3-i)) == page}">
                            <a v-if="(page - (3-i)) >= 1 && (page - (3-i)) <= lastPage" class="page-link" @click="onPaginate((page - (3-i)))">@{{ (page - (3-i)) }}</a>
                        </li>
                        <li v-if="page < lastPage - 3" class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li v-if="page < lastPage - 2" class="page-item">
                            <a class="page-link" @click="onPaginate(lastPage)">@{{ lastPage }}</a>
                        </li>
                        <li :class="{'page-item': true, disabled: page == lastPage}">
                            <a class="page-link" @click="onPaginate(page + 1)"> -> </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
<script>
    const {
        ref,
        createApp,
        computed
    } = Vue;
    createApp({
        setup() {
            const nombreCompleto = ref();
            const listaPersonaPuesto = ref([]);

            // Paginacion
            const page = ref(1);
            const limit = ref(8);
            const total = ref(0);
            const lastPage = ref(1);

            function onPaginate(pageNumber) {
                page.value = pageNumber;
                onFilter();
            }

            // Filtros
            function onFilter() {
                const filtros = {
                    nombreCompleto: nombreCompleto.value, 
                    page: page.value,
                    limit: limit.value
                };
                axios
                    .post("/api/persona-puesto/listar", filtros)
                    .then(function(response) {
                        if (response.data?.data) {
                            listaPersonaPuesto.value = response.data?.data;
                        }
                        if (response.data?.total) {
                            total.value = response.data?.total
                        }
                        if (response.data?.last_page) {
                            lastPage.value = response.data?.last_page
                        }
                })
        .catch(function(error) {
            console.log('error:', error.data)
        });  
            }

            onFilter();
            // Modal data
            const detallePersonaPuesto = ref({});

            // show form
            const showForm = ref(false);

            function toggleForm() {
                showForm.value = !showForm.value;
            }
            // obtener detalle de un registro
            const modalArgon = ref();

            function getDetalleReg(registroId) {
                axios
                    .get(`/api/persona-puesto/${registroId}`)
                    .then(function(response) {
                        if (response.data) {
                            console.log(response.data);
                            detallePersonaPuesto.value = response.data;
                            modalArgon.value?.modal('show');
                        }

                    })
                    .catch(function(error) {
                        console.log('error:', error.data)
                    });
            }

            function onCloseModal() {
                detallePersonaPuesto.value = {};
            }

            return {
                // Modal
                onCloseModal,
                getDetalleReg,
                // filtros
                //ci,
                nombreCompleto,
                onFilter,
                listaPersonaPuesto,
                detallePersonaPuesto,
                // Paginacion
                page,
                limit,
                total,
                lastPage,
                onPaginate,
                // mostrar formulario
                showForm,
                toggleForm,
            }
        }
    }).mount('#importacion-page')
</script>
<style>
    .my-vue-modal {
        width: 100%;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: #3339;
        z-index: 9999;
        overflow: auto;
    }
</style>
@endsection
