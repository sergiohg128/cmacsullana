    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a onclick="$('#modal-agregar').modal('open');" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>TÉCNICOS DE {{$proveedor->razon}}</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Nombre</th>
            <th>Eliminar</th>
          </thead>
          <tbody id="filas">
            @forelse($tecnicos as $tecnico)
                <tr id="fila{{$tecnico->id}}">
                  <td id="filanombre{{$tecnico->id}}">{{$tecnico->apellidos}} {{$tecnico->nombre}}</td>
                  <td><a onclick="modaleliminar('tecnico',{{$tecnico->id}})" class="btn red"><i class="material-icons">delete</i></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="3">No hay técnicos</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$tecnicos->appends(['id'=>$proveedor->id])->links()}}
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
                <input type="hidden" name="proveedor" value="{{$proveedor->id}}">
                <input type="text" name="nombre" required id="nombre-agregar">
                <label for="nombre-agregar">NOMBRE</label>
            </div>
          <div class="col s12 input-field">
                <input type="text" name="apellidos" required id="apellidos-agregar">
                <label for="apellidos-agregar">APELLIDOS</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="tecnicopost()" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    
@include('include.modal-eliminar')
