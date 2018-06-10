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
                      <form id="formFiltros" action="ajax/listarusuarios?modo=tabla" class="form-inline mb-3" onsubmit="buscar();">
                        <input class="form-control mr-sm-2 text-size-xm" name="nombre" type="search" placeholder="Buscar..." aria-label="Search">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="nuevo();">Nuevo Usuario</button>
                </form>
                    </div>
            <!--End Search-->

                <!-- Modal Usuario -->
                <div class="modal fade bd-example-modal-sm" id="modalUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title w-100">Registro de Usuario</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-2">
                            <div class="text-center">
                                <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                            </div>
                            <!-- Formulario Usuario-->
                            <form id="formMantenimiento" action="mantenimiento/usuarios" onsubmit="validar();return false;">
                                {{ csrf_field() }}
                                <input type="hidden" name="modo" id="inptModo">
                                <input type="hidden" name="id" id="inptId">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="nombres" id="txtNombre" placeholder="Nombre">
                                        </div>
                                    </div>
                                    <!--div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user-tie"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtCuenta" placeholder="Cuenta">
                                        </div>
                                    </div-->
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="paterno" id="txtPaterno" placeholder="Apellidos Paterno">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="materno" id="txtMaterno" placeholder="Apellido Materno">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-phone"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="celular" id="txtTelefono" placeholder="Telefono">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-envelop"></i></div>
                                            </div>
                                            <input type="email" class="form-control" name="correo" id="txtCorreo" placeholder="Correo">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-lock"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="password" id="txtClave" placeholder="Clave">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group" id="divSedeForm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-office"></i></div>
                                            </div>
                                            <select class="custom-select" id="selectSede">
                                                <option selected>Seleccione Sede...</option>
                                                <option value="1">Chiclayo</option>
                                                <option value="2">Lima</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group" id="divTipoForm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icon-user-tie"></i></div>
                                            </div>
                                            <select class="custom-select" id="inputGroupSelect01">
                                                <option selected>Seleccione Tipo...</option>
                                                <option value="1">Administrador</option>
                                                <option value="2">Cliente</option>
                                                <option value="2">Trabajador</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 divClientes">
                                    <div class="col">
                                        <div class="input-group" id="divUniversidadForm">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group" id="divCarreraForm">
                                        </div>
                                    </div>
                                </div>  
                                <div class="row mb-3 divClientes">
                                    <div class="col">
                                        <div class="input-group" id="divCicloForm">
                                        </div>
                                    </div>
                                    <div class="col"></div>
                                </div>
                            </form>
                            <!-- End Formulario Usuario-->    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success" onclick="validar();" id="btnRegistrar">Registrar</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Usuario-->

                <div class="table-responsive-lg">
                    <table class="table text-size-xm">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Tipo</th>
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
        $(".divClientes").hide();
        $("#inptId").val("");
        $("#txtNombre").val("");
        $("#txtCuenta").val("");
        $("#txtPaterno").val("");
        $("#txtMaterno").val("");
        $("#txtClave").val("");
        $("#txtCorreo").val("");
        $("#txtTelefono").val("");
        $("#inptModo").val("N");
        selectAJAX_JSON("ajax/listarsedes","modo=select","icon-office","id","nombre","divSedeForm","id_sede","slcSede","","","Seleccione Sede...");
        selectAJAX_JSON("ajax/listartiposusuario","modo=select","icon-user-tie","id","nombre","divTipoForm","id_tipo","slcTipo","","selectTipo('','','');","Seleccione Tipo...");
        $("#modalUsuarios").modal();
    }
    
    function editar(id){
        $.ajax({
            type: 'GET',
            url: "ajax/listarusuarios",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                data = data[0];
                $(".divClientes").hide();
                $("#inptId").val(data.id);
                $("#txtNombre").val(data.nombres);
                $("#txtCuenta").val(data.cuenta);
                $("#txtPaterno").val(data.paterno);
                $("#txtMaterno").val(data.materno);
                $("#txtClave").val(data.password);
                $("#txtCorreo").val(data.correo);
                $("#txtTelefono").val(data.celular);
                selectAJAX_JSON("ajax/listarsedes","modo=select","icon-office","id","nombre","divSedeForm","id_sede","slcSede",data.id_sede,"","Seleccione Sede...");
                selectAJAX_JSON("ajax/listartiposusuario","modo=select","icon-user-tie","id","nombre","divTipoForm","id_tipo","slcTipo",data.id_tipo,"selectTipo('"+data.id_universidad+"','"+data.id_carrera+"','"+data.id_ciclo+"')","Seleccione Tipo...","selectTipo('"+data.id_universidad+"','"+data.id_carrera+"','"+data.id_ciclo+"');");
                $("#inptModo").val("E");
                $("#modalUsuarios").modal();
            }
        });
    }
    
    function eliminar(id){
        //enviarURL($("#formMantenimiento").prop("action")+'?modo=A','&id='+id,"buscar();");
        $("#inptId").val(id);
        $("#inptModo").val("A");
        AlertaForm("formMantenimiento","¿DESEAS ELIMINAR EL REGISTRO?","","enviarForm('formMantenimiento','xyz');");
    }
    
    function selectTipo(id_universidad,id_carrera,id_ciclo){
        console.log("TIPO",id_universidad,id_carrera,id_ciclo);
        var idtipo = $("#slcTipo").val();
        if(idtipo == 2){
            $(".divClientes").show();
            selectAJAX_JSON("ajax/listaruniversidades","modo=select","icon-office","id","nombre","divUniversidadForm","id_universidad","slcUniversidad",id_universidad,"","Seleccione Universidad...");
            selectAJAX_JSON("ajax/listarcarreras","modo=select","icon-office","id","nombre","divCarreraForm","id_carrera","slcCarrera",id_carrera,"","Seleccione Carrera...");
            selectAJAX_JSON("ajax/listarciclos","modo=select","icon-office","id","nombre","divCicloForm","id_ciclo","slcCiclo",id_ciclo,"","Seleccione Ciclo...");
        }else{
            $(".divClientes").hide();
        }
    }
    
    function validar(){
        if($("#txtNombre").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO NOMBRE");
            return false;
        }
        if($("#txtPaterno").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO APELLIDO PATERNO");
            return false;
        }
        if($("#txtMaterno").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO APELLIDO MATERNO");
            return false;
        }
        if($("#txtTelefono").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CELULAR");
            return false;
        }
        if($("#txtCorreo").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CORREO");
            return false;
        }
        if($("#txtClave").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CLAVE");
            return false;
        }
        if(!($("#slcSede").val()>0)){
            mensajeToast("ERROR","NO HAS SELECCIONADO ALGUNA SEDE");
            return false;
        }
        if(!($("#slcTipo").val()>0)){
            mensajeToast("ERROR","NO HAS SELECCIONADO ALGUN TIPO DE USUARIO");
            return false;
        }
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
    buscar();
    
</script>