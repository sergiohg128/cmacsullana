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
                      <form id="formFiltros" action="ajax/listaruniversidades?modo=tabla" class="form-inline mb-3" onsubmit="buscar();">
                   <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="nuevo();">Nueva Universidad</button>
                </form>
                    </div>
            <!--End Search-->

                <!-- Modal TipoUsuario -->
                <div class="modal fade bd-example-modal-sm" id="modalUniversidades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title w-100">Registro de Universidades</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-2">
                            <div class="text-center">
                                <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                            </div>
                            <!-- Formulario TipoUsuario-->
                            <form id="formMantenimiento" action="mantenimiento/universidades" onsubmit="validar();return false;">
                                {{ csrf_field() }}
                                <input type="hidden" name="modo" id="inptModo">
                                <input type="hidden" name="id" id="inptId">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="text" name="nombre" class="form-control" id="txtNombre" placeholder="Nombre">
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
                    <th scope="col">Nombre</th>
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
        $("#inptModo").val("N");
        $("#modalUniversidades").modal();
    }
    
    function editar(id){
        $.ajax({
            type: 'GET',
            url: "ajax/listaruniversidades",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                data = data[0];
                $("#inptId").val(data.id);
                $("#txtNombre").val(data.nombre);
                $("#inptModo").val("E");
                $("#modalUniversidades").modal();
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
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
    buscar();
    
</script>