@include('include.head')
    @include('include.menu-usuario')
    @include('include.modal-logout')
    
<!--Cuerpo-->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header text-size-ssm"><i class="icon-user-tie mr-2 text-size-ssm"></i>Usuarios</div>
            <div class="card-body">
                
                <!--Search-->
                    <div>
                      <form id="formFiltros" action="ajax/listarusuarios?modo=tabla2" class="form-inline mb-3" onsubmit="buscar();">
                          <input type="hidden" name="id_ciclo" value="{{$id_ciclo}}">
                          <input type="hidden" name="id_carrera" value="{{$id_carrera}}">
                        <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                </form>
                    </div>
            <!--End Search-->

                <div class="table-responsive-lg">
                    <table class="table text-size-xm">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Proyectos</th> 
                                <th scope="col">Mensajes</th> 
                        </thead>
                        <tbody class="lead text-size-xm" id="tbContenido">
                        </tbody>
                    </table>
                    <div class="row center-block" id="divPagination"></div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--End Cuerpo-->

    @include('include.footer')
<script>
    
    function buscar(){
        console.log("BUSCANDO");
        cargarTabla_JSON('formFiltros','tbContenido','divPagination');
        return false;
    }
    
    buscar();
    
</script>