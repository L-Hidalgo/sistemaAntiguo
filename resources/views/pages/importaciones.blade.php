@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planilla'])
<?php

use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\PersonaPuesto;
$gerencias = Gerencia::all();
$departamentos = Departamento::all();
$personaPuesto = PersonaPuesto::all();
?>
<div class="container-fluid py-4">
    <div id="importacion-page" class="row">
    <!------------------------------------------------------------------------------------------>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header pb-0" style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 style="margin-bottom: 0;">Planilla</h6>
                    <div class="dropdown ms-auto">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ni ni-settings-gear-65"></i> Opciones
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
                <!--</div>    -->
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
                <div class="card-body pb-0" v-if="listaPersonaPuesto.length == 0">
                    <div class="alert" role="alert">
                        <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                        <strong>Importante!</strong> No hay datos importados...
                    </div>
                </div>
                <!-- </div> -->
                <!----------------formulario-------------------------------->
                <div v-if="showForm" class="search-form form-inline float-right d-flex" style="margin-left: 10px;display: none; flex-direction: row;">
                    <input class="form-control form-control-alternative text-secondary text-xs font-weight-bold" type="text" v-model="item" placeholder="Buscar por item" style="width: 14%; height: 5%; margin-left: 15px;">
                    <select class="form-control form-control-alternative text-secondary text-xs font-weight-bold" v-model="gerenciaId" style="width: 20%; height: 5%; margin-left: 25px;">
                        <option :value="undefined">Gerenecias </option>
                        @foreach($gerencias as $g)
                        <option :value="{{$g->id}}">{{$g->nombre}}</option>
                        @endforeach
                    </select>
                    <select class="form-control form-control-alternative text-secondary text-xs font-weight-bold" v-model="departamentoId" style="width: 20%; height: 5%; margin-left: 25px;">
                        <option :value="undefined">Departamentos <span order-radius: 50%; background-color: #3490dc; color: #fff; text-align: center; line-height: 20px; margin-left: 5px;"></span>
                        </option>
                        @foreach($departamentos as $d)
                        <option :value="{{$d->id}}">{{$d->nombre}}</option>
                        @endforeach
                    </select>
                    <!--<input class="form-control" type="text" v-model="nombreCompleto" placeholder="Buscar por nombre completo" style="width: 20%; height: 5%; margin-left: 10px;">-->
                    <select class="form-control form-control-alternative text-secondary text-xs font-weight-bold" v-model="estado" style="width: 15%; height: 5%; margin-left: 25px;">
                        <option :value="undefined">Estado</option>
                        <option value="Ocupado">Ocupado</option>
                        <option value="Desocupado">Desocupado</option>
                    </select>
                    <select class="form-control form-control-alternative text-secondary text-xs font-weight-bold" v-model="tipoMovimiento" style="width: 15%; height: 5%; margin-left: 20px;">
                        <option :value="undefined">Tipo de Movimiento</option>
                        <option value="Designacion">Designación</option>
                        <option value="Cambio de Item">Cambio de Item</option>
                    </select>
                    <button class="btn btn-primary" @click="onFilter()" style="border-radius: 50%; padding: 5px; font-size: 12px; cursor: pointer; margin-left: 20px; margin-right: 20px;"><i class="fas fa-search"></i></button>
                </div>
                <!----------------------------------------------------------------------------->
                <div class="card-body pb-0">
                    <div class="d-flex flex-wrap">
                        <!-------------------Cards------------------------>
                        <div v-for="personaP in listaPersonaPuesto" class="card shadow m-2" style="width: 13rem; position: relative;">
                            <div style="position: absolute; top: 0; left: 0; background-color: rgba(255, 255, 255, 0.8); padding: 5px;">
                                <span class="text-secondary text-xs font-weight-bold">@{{personaP.item}}</span>
                            </div>
                            <img v-if="personaP.imagen" :src="'/imagen-persona/' + personaP.persona_id" class="card-img-top">
                            <img v-else src="/img/team-2.jpg" class="card-img-top">
                            <div class="card-body">
                                <span class="badge rounded-pill bg-primary" style="font-size: 0.5em;" @click="getDetalleReg(personaP.id)">Detalle</span>
                                <span v-if="personaP.estado == 'Ocupado'" class="badge rounded-pill bg-success" style="font-size: 0.5em;">@{{personaP.estado}}</span>
                                <span v-else class="badge rounded-pill bg-danger" style="font-size: 0.5em;">@{{personaP.estado}}</span>
                                <h6 class="mb-0 text-sm card-title">@{{personaP.nombreCompleto}}</h6>
                                <span class="text-secondary text-xs font-weight-bold">@{{personaP.denominacion}}</span>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- ......................................Modal Detalle------------------------------------------------->
                <div v-if="detallePersonaPuesto?.id" class="my-vue-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 v-if="detallePersonaPuesto?.id" class="modal-title" id="exampleModalLabel">Perfil de @{{detallePersonaPuesto.persona.nombreCompleto}}</h5>
                                <button type="button" @click="onCloseModal" style="border: 0px solid; border-radius: 20px; padding: 5px 10px"><b>X</b></button>
                            </div>
                            <div v-if="detallePersonaPuesto?.id" class="modal-body">
                                <h6 class="modal-title">Datos de la Persona</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img v-if="detallePersonaPuesto?.persona?.imagen" :src="'/imagen-persona/' + detallePersonaPuesto?.persona_id" class="img-fluid img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                        <img v-else src="/img/team-2.jpg" class="img-fluid img-thumbnail">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <span class="text-secondary text-xs font-weight-bold"><b>Nombre Completo:</b> @{{detallePersonaPuesto.persona.nombreCompleto}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>CI.:</b> @{{detallePersonaPuesto.persona.ci}} @{{detallePersonaPuesto.persona.exp}}.</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Formacion:</b> @{{detallePersonaPuesto.formacion}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Nacimiento:</b> @{{detallePersonaPuesto.persona.fechaNacimiento}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Telefono:</b> @{{detallePersonaPuesto.persona.telefono}}</span><br>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <h6 class="modal-title">Datos como Funcionario</h6>
                                <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <span class="text-secondary text-xs font-weight-bold"><b>N° de Item:</b> @{{detallePersonaPuesto.puesto.item}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Departamento:</b> @{{detallePersonaPuesto.puesto.departamento.nombre}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Inicio en el SIN:</b> @{{detallePersonaPuesto.fechaInicioEnSin}}</span>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <span class="text-secondary text-xs font-weight-bold"><b>Gerencia:</b> @{{detallePersonaPuesto.puesto.departamento.gerencia.nombre}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Cargo:</b> @{{detallePersonaPuesto.puesto.denominacion}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Fch. de Inic. en el Cargo:</b> @{{detallePersonaPuesto.fechaInicio}}</span>
                                        </div>
                                    </div>
                                    <!--<div class="col-md-4">
                                        <div class="form-group">
                                            <span class="text-secondary text-xs font-weight-bold"><b>Nombre del Antiguo Personal:</b><br>@{{detallePersonaPuesto.nombreCompletoDesvinculacion}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Motivo de Baja:</b> @{{detallePersonaPuesto.motivoBaja}}</span><br>
                                            <span class="text-secondary text-xs font-weight-bold"><b>Ultimo dia de Trabajo:</b> @{{detallePersonaPuesto.fechaFin}}</span>
                                        </div>
                                    </div>-->
                                </div>
                                <hr class="horizontal dark">
                                <h6 class="modal-title">Requisitos de formacion</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-secondary text-xs font-weight-bold"><b>Objetivo del Puesto:</b> @{{detallePersonaPuesto.puesto.objetivo}}</span>
                                    </div>
                                    <template v-for="requisitoPuesto in detallePersonaPuesto.puesto.requisitos_puesto">
                                        <div class="col-md-12">
                                            <span v-if="requisitoPuesto.requisito" class="text-secondary text-xs font-weight-bold"><b>Formacion Requerida:</b> @{{requisitoPuesto.requisito.formacionRequerida}}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <span v-if="requisitoPuesto.requisito" class="text-secondary text-xs font-weight-bold"><b>Experiencia Profesional según Cargo:</b> @{{requisitoPuesto.requisito.experienciaProfesionalSegunCargo}}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <span v-if="requisitoPuesto.requisito" class="text-secondary text-xs font-weight-bold"><b>Experiencia Relacionado al Área:</b> @{{requisitoPuesto.requisito.experienciaRelacionadoAlArea}}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <span v-if="requisitoPuesto.requisito" class="text-secondary text-xs font-weight-bold"><b>Experiencia Relacionado en Función de Mando:</b> @{{requisitoPuesto.requisito.experienciaEnFuncionesDeMando}}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="onCloseModal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ......................................Modal------------------------------------------------->
                <!--------------------------------------------Pie de pagina------------------------------------------------------------------>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li :class="{'page-item': true, disabled: page == 1}">
                            <a class="page-link" aria-disabled="true" @click="onPaginate(page -1)"> <- </a>
                        </li>
                        <li v-if="page>2" class="page-item">
                            <a class="page-link" @click="onPaginate(1)">1</a>
                        </li>
                        <li v-if="page > 3" class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li v-for="i in 5" :class="{'page-item': true, 'active': (i-3) == page}">
                            <a v-if="(i-3) >= 1 && (i-3) <= lastPage" class="page-link" @click="onPaginate((i-3))">@{{ (i-3) }}</a>
                        </li>
                        <li v-if="page < lastPage -2" class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li v-if="page < lastPage - 1" class="page-item">
                            <a class="page-link" @click="onPaginate(lastPage)">@{{ lastPage }}</a>
                        </li>
                        <li :class="{'page-item': true, disabled: page == lastPage}">
                            <a class="page-link" @click="onPaginate(page + 1)"> -> </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-profile">
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    <h6>Filtros</h6>    
                </div>
                <div class="card-body pt-0">
                    <div  class="search-form">
                        <button class="btn btn-primary" @click="onFilter()" style="padding: 5px; font-size: 12px; width: 100%;"><i class="fas fa-search"></i> Buscar</button>
                        <input class="form-control form-control-alternative text-secondary text-xs font-weight-bold" type="text" v-model="item" placeholder="Buscar por item"><br>
                        <!---------------------FALTA DEPARTAMENTO Y GERNECIA---------------->
                        <div v-model="gerenciaId" style="height: 200px; overflow-y: scroll;">
                            <span class="text-secondary text-xs font-weight-bold" :value="undefined">GERENCIAS</span>
                            @foreach($gerencias as $g)
                                <label>
                                     <input type="checkbox" :value="{{$g->id}}" > <span class="text-secondary text-xs font-weight-bold">{{$g->nombre}}</span>
                                </label><br>
                            @endforeach
                        </div>                        
                        <!------------------------------------------------------------------>
                        <select class="form-control form-control-alternative text-secondary text-xs font-weight-bold" v-model="estado">
                            <option :value="undefined">Estado</option>
                            <option value="Ocupado">Ocupado</option>
                            <option value="Desocupado">Acefalias</option>
                        </select><br>
                        <select class="form-control form-control-alternative text-secondary text-xs font-weight-bold" v-model="tipoMovimiento">
                            <option :value="undefined">Tipo de Movimiento</option>
                            <option value="Designacion">Designación</option>
                            <option value="Cambio de Item">Cambio de Item</option>
                        </select><br>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------------------------------>
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
            const item = ref();
            const gerenciaId = ref();
            const departamentoId = ref();
            //const nombreCompleto = ref();
            const estado = ref();
            const tipoMovimiento = ref();
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
                    gerenciaId: gerenciaId.value,
                    departamentoId: departamentoId.value,
                    item: item.value,
                    //nombreCompleto: nombreCompleto.value,
                    estado: estado.value,
                    tipoMovimiento: tipoMovimiento.value,
                    // Paginacion
                    page: page.value,
                    limit: limit.value,
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
                item,
                gerenciaId,
                departamentoId,
                //nombreCompleto,
                estado,
                tipoMovimiento,
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
