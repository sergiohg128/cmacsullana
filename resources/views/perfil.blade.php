@include('include.head')
@include('include.menu-usuario')
@include('include.modal-logout')

<!--Cuerpo-->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header text-size-ssm"><i class="icon-user-tie mr-2 text-size-ssm"></i>Usuarios</div>
            <div class="card-body">
                
              <div class="card-body mx-2">
                  <div class="text-center">
                      <div class="icon-object border-primary-300 text-primary-300 mb-4"><i class="icon-reading"></i></div>
                  </div>
                  <!-- Formulario Usuario-->
                  <form id="formMantenimiento" action="mantenimiento/usuarios" onsubmit="validar();return false;">
                      {{ csrf_field() }}
                      <input type="hidden" name="modo" value="P">
                      <div class="row mb-3">
                          <div class="col">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="icon-user"></i></div>
                                  </div>
                                  <input type="text" class="form-control" name="nombres" id="txtNombre" placeholder="Nombre" value="{{$usuario->nombres}}">
                              </div>
                          </div>
                          <div class="col">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="icon-user"></i></div>
                                  </div>
                                  <input type="text" class="form-control" name="paterno" id="txtPaterno" placeholder="Apellidos Paterno" value="{{$usuario->paterno}}">
                              </div>
                          </div>
                          <div class="col">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="icon-user"></i></div>
                                  </div>
                                  <input type="text" class="form-control" name="materno" id="txtMaterno" placeholder="Apellido Materno" value="{{$usuario->materno}}">
                              </div>
                          </div>
                      </div>
                      <div class="row mb-3">
                          <div class="col">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="icon-envelop"></i></div>
                                  </div>
                                  <input type="email" class="form-control" name="correo" id="txtCorreo" placeholder="Correo" value="{{$usuario->correo}}">
                              </div>
                          </div>
                          <div class="col">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="icon-lock"></i></div>
                                  </div>
                                  <input type="text" class="form-control" name="password" id="txtClave" placeholder="Clave" value="{{$usuario->password}}">
                              </div>
                          </div>
                      </div> 
                  </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="validar();" id="btnRegistrar">Actualizar</button>
            </div>
        </div>
    </div>
</div>
<!--End Cuerpo-->

@include('include.footer2')
<script>
    
    function buscar(){
        mensajeToast("MENSAJE","GUARDADO CORRECTAMENTE");
        location.reload();
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
        if($("#txtCorreo").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CORREO");
            return false;
        }
        if($("#txtClave").val().toString().trim().length==0){
            mensajeToast("ERROR","NO HAS LLENADO EL CAMPO CLAVE");
            return false;
        }
        enviarForm("formMantenimiento","btnRegistrar");
        return false;
    }
    
</script>