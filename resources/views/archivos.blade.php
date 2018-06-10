@include('include.head')
    @include('include.menu-usuario')
    @include('include.modal-logout')
    
    <!--Cuerpo-->
      <div class="content-wrapper">
          <div class="container-fluid">
              <div class="card mb-3">
                  <div class="card-header text-size-ssm"><i class="icon-user-tie mr-2 text-size-ssm"></i>Usuarios</div>
                  <div class="card-body">
                      <form id="formMantenimiento" action="mantenimiento/archivo" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="modo" value="{{$tipo}}">
                                <input type="hidden" name="id" id="inptId">
                            </form>
            <div class="table-responsive-lg">
                      <table class="table text-size-xm">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">N°</th>
                    @if($tipo=="P")
                    <th scope="col">Mensaje</th>
                    <th scope="col">Fecha</th>
                    @endif
                    <th scope="col">Nombre</th>
                    <th scope="col">Extension</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Descargar</th>
                    @if($usuario->id_tipo==1)
                      <th scope="col">Eliminar</th>
                    @endif
                  </tr>
                </thead>
                <tbody class="lead text-size-xm" id="tbContenido">
                    @foreach($archivos as $archivo)
                    <tr>
                        <td>{{$w = $w+1}}</td>
                        @if($tipo=="P")
                        <td>{{$archivo->titulo}}</td>
                        <td>{{date_format(date_create($archivo->fecha), "d/m/Y h:i A")}}</td>
                        @endif
                        <td>{{$archivo->nombre}}</td>
                        <td>{{$archivo->extension}}</td>
                        <td>{{round($archivo->peso/1048576,2)}} MB</td>
                        <td><a target="_blank" href="download/archivo?id={{$archivo->id}}"><img class="icon-t" src="img/iconos/editar.svg" alt="Descargar"></a></td>
                        @if($usuario->id_tipo==1)
                          <td><img class="icon-t" src="img/iconos/borrar.svg" alt="Eliminar" onclick="eliminar({{$archivo->id}});"></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
              </table>
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
    
    function eliminar(id){
        $("#inptId").val(id);
        //AlertaForm("formMantenimiento","¿DESEAS ELIMINAR EL REGISTRO?","","enviarForm('formMantenimiento','xyz');");
        $('#formMantenimiento').submit();
    }
    
</script>