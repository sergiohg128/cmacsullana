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
                            <form id="formFiltros" action="ajax/listarsedes?modo=tabla" class="form-inline mb-3" onsubmit="buscar();">
                                <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                                <button type="button" class="btn btn-success btn-sm" onclick="nuevo();">Nueva Sede</button>
                            </form>
                        </div>
                    <!--End Search-->

                        <!-- Modal Sede -->
                        <div class="modal fade bd-example-modal-sm" id="modalSede" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title w-100">Registro de Sede</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body mx-2">
                                    <div class="text-center">
                                        <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                                    </div>
                                    <!-- Formulario Sede-->
                                    <form id="formMantenimiento" action="mantenimiento/sedes" onsubmit="validar();return false;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="modo" id="inptModo">
                                        <input type="hidden" name="id" id="inptId">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="icon-user"></i></div>
                                                    </div>
                                                    <input type="text" class="form-control" name="nombre" id="txtNombre" placeholder="Nombre">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="icon-user-tie"></i></div>
                                                    </div>
                                                    <input type="text" class="form-control" name="direccion" id="txtDireccion" placeholder="Direccion">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="icon-user"></i></div>
                                                    </div>
                                                    <input type="text" class="form-control" name="telefono" id="txtTelefono" placeholder="Telefono">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="icon-user-tie"></i></div>
                                                    </div>
                                                    <input type="email" class="form-control" name="correo" id="txtCorreo" placeholder="Correo">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Formulario Sede-->    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-success" onclick="validar();" id="btnRegistrar">Registrar</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Sede-->

                    <div class="table-responsive-lg">
                              <table class="table text-size-xm">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Eliminar</th>
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
    
    function buscar(){
        console.log("BUSCANDO");
        cargarTabla_JSON('formFiltros','tbContenido','divPagination');
        return false;
    }
    
    function nuevo(){
        $("#inptId").val("");
        $("#txtNombre").val("");
        $("#txtDireccion").val("");
        $("#txtTelefono").val("");
        $("#txtCorreo").val("");
        $("#inptModo").val("N");
        $("#modalSede").modal();
    }
    
    function editar(id){
        $.ajax({
            type: 'GET',
            url: "ajax/listarsedes",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                data = data[0];
                $("#inptId").val(data.id);
                $("#txtNombre").val(data.nombre);
                $("#txtDireccion").val(data.direccion);
                $("#txtTelefono").val(data.telefono);
                $("#txtCorreo").val(data.correo);
                $("#inptModo").val("E");
                $("#modalSede").modal();
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
        if($("#txtNombre").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO NOMBRE");
            return false;
        }
        if($("#txtDireccion").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO DIRECCION");
            return false;
        }
        if($("#txtTelefono").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO TELEFONO");
            return false;
        }
        if($("#txtCorreo").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CORREO");
            return false;
        }
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
    buscar();
    
</script>