@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Importaciones'])
<?php

use App\Models\Departamento;
use App\Models\Gerencia;
use App\Models\PersonaPuesto;
// use App\Models\Puesto;

// $personaPuesto = PersonaPuesto::paginate(8);
$gerencias = Gerencia::all();
$departamentos = Departamento::all();
?>
<div id="importacion-page" class="container-fluid py-4">
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
                            <a class="dropdown-item"><i class="ni ni-tag"></i>  Buscar Datos</a>
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
                <!-- ......................................------------------------------------------------------------------------>
                <!----------------formulario-------------------------------->
                <div v-if="listaPersonaPuesto.length == 0" class="card-body px-0 pt-0 pb-2">
                    <div class="alert" role="alert">
                        <span class="alert-icon"><i class="ni ni-notification-70"></i></span>
                        <strong>Importante!</strong> No hay datos importados...
                    </div>
                </div>
                <!-- </div> -->
                <!----------------formulario-------------------------------->
                <div class="form-inline float-right">
                    <input class="ml-2" type="text" v-model="item" placeholder="Buscar por item">
                    <select class="m-2" v-model="gerenciaId">
                        <option :value="undefined">TODOS</option>
                        @foreach($gerencias as $g)
                        <option :value="{{$g->id}}">{{$g->nombre}}</option>
                        @endforeach
                    </select>
                    <select class="m-2" v-model="departamentoId">
                        <option :value="undefined">TODOS</option>
                        @foreach($departamentos as $d)
                        <option :value="{{$d->id}}">{{$d->nombre}}</option>
                        @endforeach
                    </select>
                    <!-- <select id="estado">
                        <option value="Ocupado">Ocupado</option>
                        <option value="Desocupado">Desocupado</option>
                    </select>
                    <select id="tipoMovimiento">
                        <option value="Designacion">Designación</option>
                        <option value="Cambio">Cambio</option>
                    </select> -->
                    <button @click="onFilter()">Buscar</button>
                </div>
                <!----------------------------------------------------------------------------->

                    <div class="d-flex flex-wrap">
                        <!-------------------Cards------------------------>
                        <div v-for="personaP in listaPersonaPuesto" class="card shadow m-4" style="width: 13rem;">
                            <img v-if="personaP.imagen" :src="'/imagen-persona/' + personaP.persona_id" class="card-img-top">
                            <img v-else src="/img/team-2.jpg" class="card-img-top">
                            <div class="card-body">
                                <span class="badge rounded-pill bg-primary" data-bs-toggle="modal" :data-bs-target="'#informacionModal' + personaP.id" style="font-size: 0.5em;">Detalle</span>
                                <span v-if="personaP.estado == 'Ocupado'" class="badge rounded-pill bg-danger" style="font-size: 0.5em;">@{{personaP.estado}}</span>
                                <span v-else class="badge rounded-pill bg-success" style="font-size: 0.5em;">@{{personaP.estado}}</span>
                                <!-- ......................................Modal Detalle------------------------------------------------->
                                <div v-if="detallePersonaPuesto?.id" class="modal fade modal-dialog-scrollable" :id="'informacionModal' + personaP.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Perfil de @{{personaP.nombreCompleto}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="modal-title">Datos de la Persona</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img v-if="personaP.imagen" :src="'/imagen-persona/' + personaP.persona_id" class="img-fluid">
                                                        <img v-else src="/img/team-2.jpg" class="img-fluid">
                                                    </div>
                                                    <div class="col-md-6">
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
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>N° de Item:</b> @{{detallePersonaPuesto.puesto.item}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Cargo:</b> @{{detallePersonaPuesto.puesto.denominacion}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Inicio en el Cargo:</b> @{{detallePersonaPuesto.fechaInicio}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Salario:</b> @{{detallePersonaPuesto.puesto.salario}} bs.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Gerencia:</b> @{{detallePersonaPuesto.puesto.departamento.gerencia.nombre}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Departamento:</b> @{{detallePersonaPuesto.puesto.departamento.nombre}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Fecha de Inicio en el SIN:</b> @{{detallePersonaPuesto.fechaInicioEnSin}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Nombre del Antiguo Personal:</b><br>@{{detallePersonaPuesto.nombreCompletoDesvinculacion}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Motivo de Baja:</b> @{{detallePersonaPuesto.motivoBaja}}</span><br>
                                                            <span class="text-secondary text-xs font-weight-bold"><b>Ultimo dia de Trabajo:</b> @{{detallePersonaPuesto.fechaFin}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark">
                                                <h6 class="modal-title">Requisitos de formacion</h6>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span class="text-secondary text-xs font-weight-bold"><b>Objetivo del Puesto:</b> @{{detallePersonaPuesto.puesto.objetivo}}</span>
                                                    </div>
                                                    <template v-for="requisitoPuesto in detallePersonaPuesto.puesto.requisitosPuesto">
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <!-- ......................................Modal------------------------------------------------->
                                <h6 class="mb-0 text-sm card-title">@{{personaP.nombreCompleto}}</h6>
                                <span class="text-secondary text-xs font-weight-bold">@{{personaP.denominacion}}</span>
                            </div>
                        </div>
                    </div>
                    <!--------------------------------------------Pie de pagina------------------------------------------------------------------>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination ml-auto justify-content-end">
                            <li :class="'page-item'+ page == 1? ' disabled' : '' ">
                                <a class="page-link" aria-disabled="true" @click="onPaginate(page -1)"> <- </a>
                            </li>
                            <li v-if="page>2" class="page-item">
                                <a class="page-link" @click="onPaginate(1)">1</a>
                            </li>
                            <li v-if="page > 3" class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            <li v-for="i in pagesToJump" :class="'page-item' + i == page ? ' active' : ''">
                                <a class="page-link" @click="onPaginate(i)">@{{ i }}</a>
                            </li>
                            <li v-if="page < lastPage -2" class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            <li v-if="page < lastPage - 1" class="page-item">
                                <a class="page-link" @click="onPaginate(lastPage)">@{{ lastPage }}</a>
                            </li>
                            <li :class="'page-item'+ page === lastPage ? ' disabled' : ''">
                                 <a class="page-link" @click="onPaginate(page + 1)"> -> </a>
                            </li>
                        </ul>
                    </nav>
                    <!------------------------------------------------------------------------------------->
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
<script>
    const { ref, createApp, computed } = Vue;
    createApp({
    setup() {
        const datoDesdeVue = ref("DESDE VUE")
        const gerenciaId = ref();
        const departamentoId = ref();
        const item = ref();
        const listaPersonaPuesto = ref([]);

        // Paginacion
        const page = ref(1);
        const limit = ref(3);
        const total = ref(0);
        const lastPage = ref(1);
        const pagesToJump = computed(() => {
            let pagesJup = [];
            for(let i = Math.max(page.value -1 , 1); i< Math.min(page.value + 1, lastPage.value); i++){
                pagesJup.push(i);
            }
            return pagesJup;
        });
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
                // Paginacion
                page: page.value,
                limit: limit.value,
            };
            axios
                .post("/api/listar-persona-puesto", filtros)
                .then(function(response) {
                    if(response.data?.data) {
                        listaPersonaPuesto.value = response.data?.data;
                    }
                    if(response.data?.total) {
                        total.value = response.data?.total
                    }
                    if(response.data?.last_page) {
                        lastPage.value = response.data?.last_page
                    }
                })
                .catch(function(error) {
                    console.log('error:', error.data)
                })
                .then(function() {
                });
        }

        onFilter();
        // Modal data
        const detallePersonaPuesto = ref({});
        return {
            item,
            gerenciaId,
            departamentoId,
            datoDesdeVue,
            onFilter,
            listaPersonaPuesto,
            detallePersonaPuesto,
            // Paginacion
            page,
            limit,
            total,
            lastPage,
            onPaginate,
            pagesToJump,
        }
    }
    }).mount('#importacion-page')
</script>
@endsection

