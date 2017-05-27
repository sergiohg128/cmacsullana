    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a onclick="$('#modal-agregar').modal('open')" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>ZONAS</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>NOMBRE</th>
            <th>ABREVIATURA</th>
            <th>EDITAR</th>
            <th>ELIMINAR</th>
          </thead>
          <tbody id="filas">
            @forelse($zonas as $zona)
                <tr id="fila{{$zona->id}}">
                  <td id="filanombre{{$zona->id}}">{{$zona->nombre}}</td>
                  <td id="filadescripcion{{$zona->id}}">{{$zona->abreviatura}}</td>
                  <td id="filaeditar{{$zona->id}}"><a onclick="modaleditarzona({{$zona->id}},'{{$zona->nombre}}','{{$zona->descripcion}}')" class="btn green"><i class="material-icons">edit</i></a></td>
                  <td><a onclick="modaleliminar('zona',{{$zona->id}})" class="btn red"><i class="material-icons">delete</i></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="5">No hay zonas registradas</td>
                </tr>
            @endforelse
          </tbody>
        </table>
          <div class="row center">
            {{$zonas->links()}}
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
            <div class="col s12 input-field">
                <input type="text" name="descripcion" required id="descripcion-agregar">
                <label for="descripcion-agregar">ABREVIATURA</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="zonapost('agregar')" class="btn-large">GRABAR</button>
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
            <div class="col s12 input-field">
                <input type="text" name="descripcion" required id="descripcion-editar">
                <label for="descripcion-editar" id="lbl-descripcion-editar">ABREVIATURA</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="zonapost('editar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
@include('include.modal-eliminar')