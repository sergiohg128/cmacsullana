    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a onclick="$('#modal-agregar').modal('open');" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>TIPOS</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Nombre</th>
            <th>Permisos</th>
            <th>Usuarios</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </thead>
          <tbody id="filas">
            @forelse($tiposusuario as $tipo)
                <tr id="fila{{$tipo->id}}">
                  @if($tipo->id==2)
                    <td id="filanombre{{$tipo->id}}">{{$tipo->nombre}}</td>
                    <td><a class="btn disabled"><i class="material-icons">input</i></a></td>  
                    <td><a href="usuarios?id={{$tipo->id}}" class="btn brown"><i class="material-icons">input</i></a></td>
                    <td id="filaeditar{{$tipo->id}}"><a onclick="modaleditartipousuario({{$tipo->id}},'{{$tipo->nombre}}')" class="btn green"><i class="material-icons">edit</i></a></td>
                    <td><a class="btn disabled"><i class="material-icons">delete</i></a></td>
                  @else
                    <td id="filanombre{{$tipo->id}}">{{$tipo->nombre}}</td>
                    <td><a href="permisos?id={{$tipo->id}}" class="btn"><i class="material-icons">input</i></a></td>  
                    <td><a href="usuarios?id={{$tipo->id}}" class="btn brown"><i class="material-icons">input</i></a></td>
                    <td id="filaeditar{{$tipo->id}}"><a onclick="modaleditartipousuario({{$tipo->id}},'{{$tipo->nombre}}')" class="btn green"><i class="material-icons">edit</i></a></td>
                    @if($tipo->id==1)
                        <td><a class="btn disabled"><i class="material-icons">delete</i></a></td>
                    @else
                        <td><a onclick="modaleliminar('tipousuario',{{$tipo->id}})" class="btn red"><i class="material-icons">delete</i></a></td>
                    @endif
                  @endif
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="5">No hay tipos de usuario</td>
                </tr>
            @endforelse
          </tbody>
        </table>
          <div class="row center">
            {{$tiposusuario->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')
    <!--MODAL AGREGAR-->
<div id="modal-agregar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">NUEVO</h4>
    </div>
  </div>
  <div class="row">
      <form id="formagregar" accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="agregar">
                <input type="text" name="nombre" required id="nombre-agregar">
                <label for="nombre-agregar">NOMBRE</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="tipousuariopost('agregar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    
<!--MODAL EDITAR-->
<div id="modal-editar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">EDITAR</h4>
    </div>
  </div>
  <div class="row">
        <form id="formeditar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="editar">
                <input type="hidden" name="id" id="id-editar">
                <input type="text" name="nombre" required id="nombre-editar">
                <label for="nombre-editar" id="lbl-nombre-editar">NOMBRE</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="tipousuariopost('editar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    @include('include.modal-eliminar')