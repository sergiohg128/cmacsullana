    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a onclick="$('#modal-agregar').modal('open');" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>ÁREAS</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Nombre</th>
            <th>Abreviatura</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </thead>
          <tbody id="filas">
            @forelse($areas as $area)
                <tr id="fila{{$area->id}}">
                  <td id="filanombre{{$area->id}}">{{$area->nombre}}</td>
                  <td id="filanombre{{$area->id}}">{{$area->abreviatura}}</td>
                  <td id="filaeditar{{$area->id}}"><a onclick="modaleditararea({{$area->id}},'{{$area->nombre}}','{{$area->abreviatura}}')" class="btn green"><i class="material-icons">edit</i></a></td>
                  <td><a onclick="modaleliminar('area',{{$area->id}})" class="btn red"><i class="material-icons">delete</i></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="4">NO HAY ÁREAS</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$areas->links()}}
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
                <input type="text" name="abreviatura" required id="abreviatura-agregar">
                <label for="abreviatura-agregar">ABREVIATURA</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="areapost('agregar')" class="btn-large">GRABAR</button>
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
                <input type="text" name="abreviatura" required id="abreviatura-editar">
                <label for="abreviatura-editar" id="lbl-abreviatura-editar">ABREVIATURA</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="areapost('editar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
@include('include.modal-eliminar')