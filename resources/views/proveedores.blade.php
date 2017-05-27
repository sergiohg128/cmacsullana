    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo"><a onclick="$('#modal-agregar').modal('open');" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>PROVEEDORES</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Nombre</th>
            <th>Técnicos</th>
            <th>Ver</th>
          </thead>
          <tbody id="filas">
            @forelse($proveedores as $proveedor)
                <tr id="fila{{$proveedor->id}}">
                  <td id="filarazon{{$proveedor->id}}">{{$proveedor->razon}}</td>
                  <td><a href="tecnicos?id={{$proveedor->id}}" class="btn green"><i class="material-icons">input</i></a></td>
                  <td><a onclick="verproveedor({{$proveedor->id}})" class="btn brown"><i class="material-icons">input</i></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="5">No hay proveedores</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$proveedores->links()}}
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
                <input type="text" name="razon" required id="razon-agregar">
                <label for="razon-agregar">RAZÓN SOCIAL(Obligatorio)</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="ruc" required id="ruc-agregar">
                <label for="ruc-agregar">RUC(Obligatorio)</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="correo" required id="correo-agregar">
                <label for="correo-agregar">CORREO(Obligatorio)</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="contacto" required id="contacto-agregar">
                <label for="contacto-agregar">CONTACTO</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="direccion" required id="direccion-agregar">
                <label for="direccion-agregar">DIRECCIÓN</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="fijo" required id="fijo-agregar">
                <label for="fijo-agregar">TELEFONO FIJO</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="celular" required id="celular-agregar">
                <label for="celular-agregar">CELULAR</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="pagina" required id="pagina-agregar">
                <label for="pagina-agregar">PÁGINA</label>
            </div>
            <div class="col s12 input-field">
                <select name="tipo" id="tipo-agregar" onchange="tipoproveedor()">
                    <option value="1">NACIONAL</option>
                    <option value="2">INTERNACIONAL</option>
                </select>
                <label for="tipo-agregar">TIPO</label>
            </div>
            <div class="col s12 input-field" id="divpais">
                <select name="pais" id="pais-agregar">
                    @forelse($paises as $pais)
                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                    @empty
                        <option value="0">No hay paises registrados</option>
                    @endforelse
                </select>
                <label for="pais-agregar">PAIS</label>
            </div>
            <div class="col s12 input-field" id="divnacional1">
                <select name="departamento" id="departamento-agregar" onchange="listarprovincias('agregar')">
                    <option value="0">Elija un departamento</option>
                    @forelse($departamentos as $departamento)
                    <option value="{{$departamento->id}}" id="departamento{{$departamento->id}}-agregar">{{$departamento->nombre}}</option>
                    @endforeach
                </select>
                <label for="departamento-agregar">DEPARTAMENTOS</label>
            </div>
            <div class="col s12 input-field" id="divnacional2">
                <select name="provincia" id="provincia-agregar" onchange="listardistritos('agregar')">
                    <option value="0">Elija una provincia</option>
                </select>
                <label for="provincia-agregar">PROVINCIAS</label>
            </div>
            <div class="col s12 input-field" id="divnacional3">
                <select name="distrito" id="distrito-agregar">
                    <option value="0">Elija un distrito</option>
                </select>
                <label for="distrito-agregar">DISTRITOS</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="codigopostal" required id="codigopostal-agregar">
                <label for="codigopostal-agregar">CÓDIGO POSTAL</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnagregar">
            <button onclick="proveedorpost('agregar')" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    
    
    
 <!--MODAL VER-->
<div id="modal-ver" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">VER PROVEEDOR</h4>
    </div>
  </div>
  <div class="row">
        <form id="formeditar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                <input type="text" name="razon" required id="razon-editar" readonly>
                <label for="razon-editar" id="lbl-razon-editar">RAZÓN SOCIAL</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="ruc" required id="ruc-editar" readonly>
                <label for="ruc-editar" id="lbl-ruc-editar">RUC</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="contacto" required id="contacto-editar" readonly>
                <label for="contacto-editar" id="lbl-contacto-editar">CONTACTO</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="direccion" required id="direccion-editar" readonly>
                <label for="direccion-editar" id="lbl-direccion-editar">DIRECCIÓN</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="fijo" required id="fijo-editar" readonly>
                <label for="fijo-editar" id="lbl-fijo-editar">TELEFONO FIJO</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="celular" required id="celular-editar" readonly>
                <label for="celular-editar" id="lbl-celular-editar">CELULAR</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="correo" required id="correo-editar" readonly>
                <label for="correo-editar" id="lbl-correo-editar">CORREO</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="pagina" required id="pagina-editar" readonly>
                <label for="pagina-editar" id="lbl-pagina-editar">PÁGINA</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="tipo" required id="tipo-editar" readonly>
                <label for="tipo-editar" id="lbl-tipo-editar">UBICACIÓN</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s12 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
    
    
<script>
    tipoproveedor();
</script>
    