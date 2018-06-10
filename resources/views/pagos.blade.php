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
                      <form id="formFiltros" action="ajax/listarpagos?modo=tabla" class="form-inline mb-3" onsubmit="buscar();">
                          <input type="hidden" name="id_cuota" value="{{$id_cuota}}">
                   <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="nuevo();">Nuevo Pago</button>
                </form>
                    </div>
            <!--End Search-->

                <!-- Modal TipoUsuario -->
                <div class="modal fade bd-example-modal-sm" id="modalPagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title w-100">Registro de Pagos</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-2">
                            <div class="text-center">
                                <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                            </div>
                            <!-- Formulario TipoUsuario-->
                            <form id="formMantenimiento" action="mantenimiento/pagos" onsubmit="validar();return false;">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_cuota" value="{{$id_cuota}}">
                                <input type="hidden" name="modo" id="inptModo">
                                <input type="hidden" name="id" id="inptId">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="number" name="monto" class="form-control" id="txtMonto" placeholder="Monto pagado">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-calendar"></i></div>
                                            </div>
                                            <input type="date" name="fecha" class="form-control" id="txtFecha" placeholder="Fecha de Pago">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group" id="divCuentaForm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <select class="custom-select" name="cuenta" id="slcCuenta">
                                                <option value="0">ELIJA UNA CUENTA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="text" name="operacion" class="form-control" id="txtOperacion" placeholder="N° de Recibo">
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
                    <th scope="col">Monto</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Cuenta</th>
                    <th scope="col">N° de Recibo</th>
                    <th scope="col">Editar</th>
                    @if($usuario->id_tipo)
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
        $("#txtOperacion").val("");
        $("#inptModo").val("N");
        $("#modalPagos").modal();
        selectAJAX_JSON("ajax/listarcuentas","modo=select","icon-office","id","nombre","divCuentaForm","id_cuenta","slcCuenta","","","Seleccione Cuenta...");
    }
    
    function editar(id){
        $.ajax({
            type: 'GET',
            url: "ajax/listarpagos",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                data = data[0];
                $("#inptId").val(data.id);
                $("#txtMonto").val(data.monto);
                $("#txtFecha").val(data.fecha);
                $("#txtOperacion").val(data.operacion);
                $("#inptModo").val("E");
                selectAJAX_JSON("ajax/listarcuentas","modo=select","icon-office","id","nombre","divCuentaForm","id_cuenta","slcCuenta",data.id_cuenta,"","Seleccione Cuenta...");
                $("#modalPagos").modal();
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
        if(!($("#slcCuenta").val()>0)){
            mensajeToast("ERROR","NO HAS SELECCIONADO ALGUNA CUENTA");
            return false;
        }
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
    buscar();
    
</script>