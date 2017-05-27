    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a onclick="$('#modal-agregar').modal('open')" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>SUCURSALES</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Zona</th>
            <th>Tipo Territorio</th>
            <th>Tipo Sucursal</th>
            <th>Ubicación</th>
            <th>Áreas</th>
            <th>Ver</th>
          </thead>
          <tbody id="filas">
            @forelse($sucursales as $sucursal)
                <tr id="fila{{$sucursal->id}}">
                  <td id="filanombre{{$sucursal->id}}">{{$sucursal->nombre}}</td>
                  <td id="filadireccion{{$sucursal->id}}">{{$sucursal->direccion}}</td>
                  <td id="filazona{{$sucursal->id}}">{{$sucursal->zona()->nombre}}</td>
                  <td id="filatipoterritorio{{$sucursal->id}}">{{$sucursal->tipoterritorio()->nombre}}</td>
                  <td id="filatiposucursal{{$sucursal->id}}">{{$sucursal->tiposucursal()->nombre}}</td>
                  <td id="filaubicacion{{$sucursal->id}}">{{$sucursal->ubicacion()}}</td>
                  <td><a href="areas-sucursal?id={{$sucursal->id}}"><button class="btn brown"><i class="material-icons">input</i></button></a></td>
                  <td><a href="sucursal?id={{$sucursal->id}}"><button class="btn"><i class="material-icons">input</i></button></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="6">No hay sucursales registradas</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$sucursales->links()}}
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
        <form id="formagregar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="agregar">
                <input type="text" name="nombre" required id="nombre-agregar">
                <label for="nombre-agregar">NOMBRE</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="direccion" required id="direccion-agregar">
                <label for="direccion-agregar">DIRECCIÓN</label>
            </div>
            <div class="col s12 input-field">
                <select name="zona" id="zona-agregar">
                        <option value="0">ELIJA UNA ZONA</option>
                    @forelse($zonas as $zona)
                        <option value="{{$zona->id}}">{{$zona->nombre}}</option>
                    @empty
                        <option value="0">No hay zonas registradas</option>
                    @endforelse
                </select>
                <label for="zona-agregar">ZONA</label>
            </div>
            <div class="col s12 input-field">
                <select name="tipoterritorio" id="tipoterritorio-agregar">
                    <option value="0">ELIJA UN TIPO DE TERRITORIO</option>
                    @forelse($tiposterritorio as $tipoterritorio)
                        <option value="{{$tipoterritorio->id}}">{{$tipoterritorio->nombre}}</option>
                    @empty
                        <option value="0">No hay tipos de territorio registrados</option>
                    @endforelse
                </select>
                <label for="tipoterritorio-agregar">TIPO DE TERRITORIO</label>
            </div>
            <div class="col s12 input-field">
                <select name="tiposucursal" id="tiposucursal-agregar">
                    <option value="0">ELIJA UN TIPO DE SUCURSAL</option>
                    @forelse($tipossucursal as $tiposucursal)
                        <option value="{{$tiposucursal->id}}">{{$tiposucursal->nombre}}</option>
                    @empty
                        <option value="0">No hay tipos de sucursal registrados</option>
                    @endforelse
                </select>
                <label for="tiposucursal-agregar">TIPO DE SUCURSAL</label>
            </div>
            <div class="col s12 input-field">
                <select name="departamento" id="departamento-agregar" onchange="listarprovincias('agregar')">
                    <option value="0">Elija un departamento</option>
                    @forelse($departamentos as $departamento)
                    <option value="{{$departamento->id}}" id="departamento{{$departamento->id}}-agregar">{{$departamento->nombre}}</option>
                    @endforeach
                </select>
                <label for="departamento-agregar">DEPARTAMENTOS</label>
            </div>
            <div class="col s12 input-field">
                <select name="provincia" id="provincia-agregar" onchange="listardistritos('agregar')">
                    <option value="0">Elija una provincia</option>
                </select>
                <label for="provincia-agregar">PROVINCIAS</label>
            </div>
            <div class="col s12 input-field">
                <select name="distrito" id="distrito-agregar">
                    <option value="0">Elija un distrito</option>
                </select>
                <label for="distrito-agregar">DISTRITOS</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="telefono1" required id="telefono1-agregar">
                <label for="telefono1-agregar">TELEFONO 1</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="telefono2" required id="telefono2-agregar">
                <label for="telefono2-agregar">TELEFONO 2</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="sucursalpost('agregar')" class="btn-large">GRABAR</button>
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
                <input type="text" name="nombre" required id="nombre-editar">
                <label for="nombre-editar">NOMBRE</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="direccion" required id="direccion-editar">
                <label for="direccion-editar">DIRECCIÓN</label>
            </div>
            <div class="col s12 input-field">
                <select name="zona" id="zona-editar">
                        <option value="0">ELIJA UNA ZONA</option>
                    @forelse($zonas as $zona)
                        <option value="{{$zona->id}}">{{$zona->nombre}}</option>
                    @empty
                        <option value="0">No hay zonas registradas</option>
                    @endforelse
                </select>
                <label for="zona-editar">ZONA</label>
            </div>
            <div class="col s12 input-field">
                <select name="tipoterritorio" id="tipoterritorio-editar">
                    <option value="0">ELIJA UN TIPO DE TERRITORIO</option>
                    @forelse($tiposterritorio as $tipoterritorio)
                        <option value="{{$tipoterritorio->id}}">{{$tipoterritorio->nombre}}</option>
                    @empty
                        <option value="0">No hay tipos de territorio registrados</option>
                    @endforelse
                </select>
                <label for="tipoterritorio-editar">TIPO DE TERRITORIO</label>
            </div>
            <div class="col s12 input-field">
                <select name="tiposucursal" id="tiposucursal-editar">
                    <option value="0">ELIJA UN TIPO DE SUCURSAL</option>
                    @forelse($tipossucursal as $tiposucursal)
                        <option value="{{$tiposucursal->id}}">{{$tiposucursal->nombre}}</option>
                    @empty
                        <option value="0">No hay tipos de sucursal registrados</option>
                    @endforelse
                </select>
                <label for="tiposucursal-editar">TIPO DE SUCURSAL</label>
            </div>
            <div class="col s12 input-field">
                <select name="departamento" id="departamento-editar" onchange="listarprovincias('editar')">
                    <option value="0">Elija un departamento</option>
                    @forelse($departamentos as $departamento)
                    <option value="{{$departamento->id}}" id="departamento{{$departamento->id}}-editar">{{$departamento->nombre}}</option>
                    @endforeach
                </select>
                <label for="departamento-editar">DEPARTAMENTOS</label>
            </div>
            <div class="col s12 input-field">
                <select name="provincia" id="provincia-editar" onchange="listardistritos('editar')">
                    <option value="0">Elija una provincia</option>
                </select>
                <label for="provincia-editar">PROVINCIAS</label>
            </div>
            <div class="col s12 input-field">
                <select name="distrito" id="distrito-editar">
                    <option value="0">Elija un distrito</option>
                </select>
                <label for="distrito-editar">DISTRITOS</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="telefono1" required id="telefono1-editar">
                <label for="telefono1-editar">TELEFONO 1</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="telefono2" required id="telefono2-editar">
                <label for="telefono2-editar">TELEFONO 2</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="sucursalpost('editar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    