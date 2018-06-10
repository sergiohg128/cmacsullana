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
                      <form id="formFiltros" action="ajax/listarmensajes?modo=tabla" class="form-inline mb-3" onsubmit="buscar();">
                   <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="nuevo();">Nuevo Mensaje</button>
                </form>
                    </div>
            <!--End Search-->

                <!-- Modal TipoUsuario -->
                <div class="modal fade bd-example-modal-sm" id="modalMensajes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title w-100">Registro de Mensajes</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-2">
                            <div class="text-center">
                                <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                            </div>
                            <!-- Formulario TipoUsuario-->
                            <form id="formMantenimiento" action="mantenimiento/mensajes" onsubmit="validar();return false;">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_proyecto" value="{{$id_proyecto}}">
                                <input type="hidden" name="modo" id="inptModo">
                                <input type="hidden" name="id" id="inptId">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="text" name="titulo" class="form-control" id="txtTitulo" placeholder="Titulo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <textarea class="form-control" name="contenido" id="txtContenido" placeholder="Contenido de Mensaje"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="file" name="archivos[]" class="form-control" id="txtArchivo" placeholder="Subir Archivo" multiple>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- End Formulario TipoUsuario-->    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success" onclick="validar();" id="btnRegistrar">Registrar</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal TipoUsuario-->

            <div class="table-responsive-lg">
                      <table class="table text-size-xm">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Contenido</th>
                    <th scope="col">Leido</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Archivos</th>
                    <!--<th scope="col">Editar</th>-->
                    @if($usuario->id_tipo==1)
                    <th scope="col">Eliminar</th>
                    @endif
                  </tr>
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
    
    function archivo(id){
        window.open('download/archivo?id='+id);
    }
    
    function buscar(){
        console.log("BUSCANDO");
        cargarTabla_JSON('formFiltros','tbContenido','divPagination');
        return false;
    }
    
    function nuevo(){
        $("#inptId").val("");
        $("#txtTitulo").val("");
        $("#txtContenido").val("");
        $("#txtArchivo").val("");
        $("#inptModo").val("N");
        $("#modalMensajes").modal();
    }
    
    function editar(id){
        $.ajax({
            type: 'GET',
            url: "ajax/listarmensajes",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                data = data[0];
                $("#inptId").val(data.id);
                $("#txtTitulo").val(data.titulo);
                $("#txtContenido").val(data.contenido);
                $("#txtArchivo").val("");
                $("#inptModo").val("E");
                $("#modalMensajes").modal();
            }
        });
    }
    
    function eliminar(id){
        //enviarURL($("#formMantenimiento").prop("action")+'?modo=A','&id='+id,"buscar();");
        $("#inptId").val(id);
        $("#inptModo").val("A");
        AlertaForm("formMantenimiento","¿DESEAS ELIMINAR EL REGISTRO?","","enviarForm('formMantenimiento','xyz');");
    }
    
    function validar(){
        if($("#txtTitulo").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO TITULO");
            return false;
        }
        if($("#txtContenido").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CONTENIDO");
            return false;
        }
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
    buscar();
    
</script>