    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h5>USUARIOS DE TIPO {{$tipousuario->nombre}}</h5>
      </div>
        <div class="row">
            <a onclick="$('#modal-agregar').modal('open')" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
            <div class="col s10 offset-s1 tabla">
             <table class="centered striped resp2">
               <thead>
                 <th>Nombre</th>
                 <th>Correo</th>
                 <th>Editar</th>
                 <th>Restablecer Contraseña</th>
                 <!--<th>Desactivar</th>-->
                 <th>Eliminar</th>
               </thead>
               <tbody id="filas">
                 @forelse($usuarios as $usuariox)
                    <tr id="fila{{$usuariox->id}}">
                       <td>{{$usuariox->apellidos}} {{$usuariox->nombre}}</td>
                       <td>{{$usuariox->correo}}</td>
                       <td><a onclick="modaleditarusuario({{$usuariox->id}},'{{$usuariox->apellidos}} {{$usuariox->nombre}}','editar')" class="btn green"><i class="material-icons">edit</i></a></td>
                       <td><a onclick="modaleditarusuario({{$usuariox->id}},'{{$usuariox->apellidos}} {{$usuariox->nombre}}','restablecer')" class="btn"><i class="material-icons">replay</i></a></td>
                       <!--<td><a onclick="modaldesactivarusuario({{$usuariox->id}},'{{$usuariox->apellidos}} {{$usuariox->nombre}}')" class="btn grey"><i class="material-icons">block</i></a></td>-->
                       <td><a onclick="modaleditarusuario({{$usuariox->id}},'{{$usuariox->apellidos}} {{$usuariox->nombre}}','eliminar')" class="btn red"><i class="material-icons">delete</i></a></td>
                     </tr>
                 @empty
                     <tr id="filaempty">
                         <td colspan="6">No hay usuarios</td>
                     </tr>
                 @endforelse
               </tbody>
             </table>
             <div class="row center">
                {{$usuarios->appends(['id'=>$tipousuario->id])->links()}}
            </div>
           </div> 
        </div>
    </div>
    @include('include.footer')
    

    <!--MODAL AGREGAR-->
<div id="modal-agregar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">NUEVO USUARIO</h4>
    </div>
  </div>
  <div class="row">
        <form id="formagregar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="agregar">
                <input type="hidden" name="tipo" value="{{$tipousuario->id}}">
                <input type="text" name="nombre" required id="nombre-agregar">
                <label for="nombre-agregar">NOMBRE</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="apellidos" required id="apellidos-agregar">
                <label for="apellidos-agregar">APELLIDOS</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="correo" required id="correo-agregar">
                <label for="correo-agregar">CORREO</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="usuariopost('agregar')" class="btn-large">GRABAR</button>
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
        <h5 class="center" id="subtitulo-editar"></h5>
    </div>
  </div>
  <div class="row">
        <form id="formeditar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="editar">
                <input type="hidden" name="id" id="id-editar">
            </div>
            <div class="col s12 input-field">
                <select name="tipo" required id="tipo-editar">
                    @forelse($tiposusuario as $tipousuariox)
                        <option value="{{$tipousuariox->id}}">{{$tipousuariox->nombre}}</option>
                    @empty
                        <option value="0" disabled>No hay otros tipos de usuario</option>
                    @endforelse
                </select>
                <label for="tipo-editar">Tipo</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="usuariopost('editar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    
    
    <!--MODAL ELIMINAR-->
<div id="modal-eliminar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">ELIMINAR</h4>
        <h5 class="center" id="subtitulo-eliminar"></h5>
    </div>
  </div>
  <div class="row">
        <form id="formeliminar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="eliminar">
                <input type="hidden" name="id" id="id-eliminar">
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneliminar">
            <button onclick="usuariopost('eliminar')" class="btn-large">Eliminar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>
    
    <!--MODAL DESACTIVAR-->
<div id="modal-desactivar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">DESACTIVAR</h4>
        <h5 class="center" id="subtitulo-desactivar"></h5>
    </div>
  </div>
  <div class="row">
        <form id="formdesactivar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="desactivar">
                <input type="hidden" name="id" id="id-desactivar">
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtndesactivar">
            <button onclick="usuariopost('desactivar')" class="btn-large">DESACTIVAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    
        <!--MODAL ELIMINAR-->
<div id="modal-restablecer" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">RESTABLECER CONTRASEÑA</h4>
        <h5 class="center" id="subtitulo-restablecer"></h5>
    </div>
  </div>
  <div class="row">
        <form id="formrestablecer"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="restablecer">
                <input type="hidden" name="id" id="id-restablecer">
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnrestablecer">
            <button onclick="usuariopost('restablecer')" class="btn-large">RESTABLECER</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>