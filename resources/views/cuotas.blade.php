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
                      <form id="formFiltros" action="ajax/listarcuotas?modo=tabla" class="form-inline mb-3" onsubmit="buscar();">
                          <input type="hidden" name="id_proyecto" value="{{$id_proyecto}}">
                   <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="nuevo();">Nuevo Cuota</button>
                </form>
                    </div>
            <!--End Search-->

                <!-- Modal TipoUsuario -->
                <div class="modal fade bd-example-modal-sm" id="modalCuotas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title w-100">Registro de Cuotas</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-2">
                            <div class="text-center">
                                <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                            </div>
                            <!-- Formulario TipoUsuario-->
                            <form id="formMantenimiento" action="mantenimiento/cuotas" onsubmit="validar();return false;">
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
                                            <input type="number" name="monto" class="form-control" id="txtMonto" placeholder="Monto a pagar">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-calendar"></i></div>
                                            </div>
                                            <input type="date" name="fecha" class="form-control" id="txtFecha" placeholder="Fecha a pagar">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <textarea class="form-control" name="detalle" id="txtDetalle" placeholder="Detalle de la cuota"></textarea>
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
                    <th scope="col">Detalle</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Cancelado</th>
                    <th scope="col">Pagos</th>
                    <th scope="col">Editar</th>
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
    
    function buscar(){
        console.log("BUSCANDO");
        cargarTabla_JSON('formFiltros','tbContenido','divPagination');
        return false;
    }
    
    function nuevo(){
        $("#inptId").val("");
        $("#txtMonto").val("");
        $("#txtFecha").val("");
        $("#txtDetalle").val("");
        $("#inptModo").val("N");
        $("#modalCuotas").modal();
    }
    
    function editar(id){
        $.ajax({
            type: 'GET',
            url: "ajax/listarcuotas",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                data = data[0];
                $("#inptId").val(data.id);
                $("#txtMonto").val(data.monto);
                $("#txtFecha").val(data.fecha);
                $("#txtDetalle").val(data.detalle);
                $("#inptModo").val("E");
                $("#modalCuotas").modal();
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
        if($("#txtMonto").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO MONTO A PAGAR");
            return false;
        }
        if($("#txtFecha").val().toString().trim().length!=10){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO FECHA A PAGAR");
            return false;
        }
        if($("#txtDetalle").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO DETALLE");
            return false;
        }
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
    buscar();
    
</script>