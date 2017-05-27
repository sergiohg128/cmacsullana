    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a onclick="$('#modal-agregar').modal('open');" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
        <a onclick="$('#formlistarmodelos').submit()" class="btn-floating btn-large waves-effect left"><i class="material-icons">search</i></a>
      <div class="row titulo center">
        <h4>PRODUCTOS</h4>
      </div>
      <div class="col s10 offset-s1">
            <form id="formlistarmodelos" action="modelos" method="GET">
                {{ csrf_field() }}
                <div class="col s12 l6 center">
                    <label for="marcaform">MARCAS</label>
                    <select id="marcaform" name="id_marca" style="width: 100%;">
                        <option value="0">TODAS LAS MARCAS</option>
                        @forelse($marcas as $marca)
                            <option value="{{$marca->id}}" @if($marca->id==$idmarca) selected @endif>{{$marca->nombre}}</option>
                        @empty
                            <option value="0">NO HAY MARCAS</option>
                        @endforelse
                    </select>
                </div>
                <div class="col s12 l6 center">
                    <label for="tiposform">TIPOS DE EQUIPO</label>
                    <select id="tiposform" name="id_tipoequipo" style="width: 100%;">
                        <option value="0">TODOS LOS TIPOS</option>
                        @forelse($tiposequipo as $tipoequipo)
                            <option value="{{$tipoequipo->id}}" @if($tipoequipo->id==$idtipoequipo) selected @endif>{{$tipoequipo->nombre}}</option>
                        @empty
                        <option value="0">NO HAY TIPOS DE EQUIPO</option>
                        @endforelse
                    </select>
                </div>
                
            </form>
        </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Nombre</th>
            <th>Marca</th>
            <th>Tipo</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </thead>
          <tbody id="filas">
            @forelse($modelos as $modelo)
                <tr id="fila{{$modelo->id}}">
                  <td id="filanombre{{$modelo->id}}">{{$modelo->nombre}}</td>
                  <td id="filatipo{{$modelo->id}}">{{$modelo->marca()->nombre}}</td>
                  <td id="filatipo{{$modelo->id}}">{{$modelo->tipoequipo()->nombre}}</td>
                  <td id="filaeditar{{$modelo->id}}"><a onclick="modaleditarmodelo({{$modelo->id}},'{{$modelo->nombre}}',{{$modelo->id_tipo_equipo}},{{$modelo->id_marca}})" class="btn green"><i class="material-icons">edit</i></a></td>
                  <td><a onclick="modaleliminar('modelo',{{$modelo->id}})" class="btn red"><i class="material-icons">delete</i></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="5">No hay modelos</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$modelos->appends(['id_marca'=>$idmarca,'id_tipoequipo'=>$idtipoequipo])->links()}}
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
                <input type="text" name="nombre" required id="nombre-agregar"  placeholder="Ejemplo: L22W831">
                <label for="nombre-agregar">NOMBRE</label>
            </div>
            <div class="col s12">
                <label for="marca-agregar">MARCAS</label>
                <select name="marca" id="marca-agregar" style="width: 100%;">
                    <option value="0">ELIJA UNA MARCA</option>
                    @foreach($marcas as $marca)
                        <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s12">
                <label for="tiposequipo-agregar">TIPOS</label>
                <select name="tipo" id="tiposequipo-agregar" style="width: 100%;">
                    <option value="0">ELIJA UN TIPO</option>
                    @foreach($tiposequipo as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                    @endforeach
                </select>
            </div>
            
        </form>
  </div>
    <div class="row center botones" style="margin-top: 20px;">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="modelopost('agregar')" class="btn-large">GRABAR</button>
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
                <input type="text" name="nombre" required id="nombre-editar" placeholder="Ejemplo: L22W831">
                <label for="nombre-editar" id="lbl-nombre-editar">NOMBRE</label>
            </div>
            <div class="col s12">
                <label for="marca-editar">MARCA</label>
                <select name="marca" id="marca-editar" style="width: 100%;">
                    <option value="0">ELIJA UNA MARCA</option>
                    @foreach($marcas as $marca)
                        <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s12">
                <label for="tiposequipo-editar">TIPO</label>
                <select name="tipo" id="tiposequipo-editar" style="width: 100%;">
                    <option value="0">ELIJA UN TIPO</option>
                    @foreach($tiposequipo as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                    @endforeach
                </select>
            </div>
            
        </form>
  </div>
    <div class="row center botones" style="margin-top: 15px;">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="modelopost('editar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
@include('include.modal-eliminar')

<script>
    $('#tiposequipo-agregar').select2();
    $('#tiposequipo-editar').select2();
    $('#marca-agregar').select2();
    $('#marca-editar').select2();
    $('#marcaform').select2();
    $('#tiposform').select2();
</script>