    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>DAR DE BAJA</h4>
        <h5>DESDE: {{$sucursal->nombre}}</h5>
      </div>
      <div class="row">
            <div class="col s10 offset-s1 m6 offset-m3 center">
                <form id="bajaform" method="POST">
                    {{ csrf_field() }}
                    <div id="otrosinput"></div>
                    <input type="hidden" name="origen" id="origen" value="{{$sucursal->id}}">
                    <div class="col s12 m6 l6 input-field">
                        <input type="text" name="interno" id="interno">
                        <label for="interno">NÚMERO INTERNO</label>
                    </div>
                    <div class="col s12 m6 l6 input-field">
                        <input type="text" name="numero" id="numero">
                        <label for="numero">GUIA DE REMISIÓN</label>
                    </div>
                    <div class="col s12 input-field">
                        <div class="col s2">
                            <label>FECHA</label>
                        </div>
                        <div class="col s10">
                            <input type="date" id="fecha" name="fecha" value="{{$hoy}}">
                        </div>
                    </div>
                    <div class="col s12 input-field">
                        <textarea class="materialize-textarea" name="descripcion" id="descripcion"></textarea>
                        <label for="descripcion">DESCRIPCION</label>
                    </div>
                </form>
            </div>
        </div>
      <div class="col s10 offset-s1">
          <div class="row titulo center">
            <h5>IMPORTAR EXCEL</h5>
          </div>
          <div class="row">
              <div class="col s10 offset-s1">
                  <form id="bajaexcelform">
                      {{ csrf_field() }}
                      <input type="hidden" name="origen" value="{{$sucursal->id}}">
                      <input type="hidden" name="tipo" value="1">
                      <div class="col s12 m6 l10 input-field file-field">
                        <div class="btn green"><span>EXCEL</span>
                          <input id="excel" name="excel" type="file" accept=".xlsx">
                        </div>
                        <div class="file-path-wrapper">
                          <input type="text" class="file-path validate" placeholder="Suba un archivo en formato .xlsx">
                        </div>
                    </div>
                    <div class="col s12 m6 l1 offset-s1 input-field" id="divbtnagregar1">
                        <a onclick="agregardetallebaja(1)" class="btn red"><i class="material-icons">add</i></a>
                    </div>
                  </form>
            </div>
          </div>
          <div class="row titulo center">
            <h5>INGRESAR SERIE MANUAL</h5>
          </div>
          <div class="row">
              <div class="col s10 offset-s1">
                    <div class="col s12 m8 offset-m2 l6 offset-l3 input-field">
                      <input type="text" name="serie" id="seriemanual" placeholder="Ejemplo: MX125648972T2">
                      <label for="seriemanual">SERIE</label>
                    </div>
                    <div class="col s12 m6 l1 offset-s1 input-field" id="divbtnagregar2">
                        <a onclick="agregardetallebaja(2)" class="btn red"><i class="material-icons">add</i></a>
                    </div>
            </div>
          </div>
          <div class="row titulo center">
            <h5>SELECCIONAR SERIES</h5>
          </div>
          <div class="row">
              <div class="col s12 m6 l4">
                  <label>TIPOS DE EQUIPO</label>
                  <select id="tiposequipo" style="width: 100%;"  onchange="listarmodelos()">
                    <option value="0">TODOS</option>
                    @forelse($tiposequipo as $tipoequipo)
                        <option value="{{$tipoequipo->id}}">{{$tipoequipo->nombre}}</option>
                    @empty
                        <option value="0">NO HAY TIPOS DE PRODUCTO</option>
                    @endforelse
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label>MARCAS</label>
                  <select id="marcas" style="width: 100%;" onchange="listarmodelos()">
                    <option value="0">TODAS</option>
                    @forelse($marcas as $marca)
                        <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                    @empty
                        <option value="0">NO HAY MARCAS</option>
                    @endforelse
                  </select>
              </div>
              <div class="col s12 m6 l3" id="divmodelos">
                  <label>PRODUCTOS</label>
                  <select  id="modelos" style="width: 100%;">
                    <option value="0">TODOS</option>
                  </select>
              </div>
              <div class="col s12 m6 l1 input-field" id="divbtnbuscar">
                  <a onclick="buscarseriesbaja()" class="btn green"><i class="material-icons">search</i></a>
              </div>
              <div class="col s12 m6 l11 input-field" id="divseries">
                  <label>SERIES</label>
                  <select  id="series" style="width: 100%;">
                      <option value="0">ELIJA UNA SERIE</option>
                  </select>
              </div>
              <div class="col s12 m6 l1  input-field" id="divbtnagregar3">
                  <a onclick="agregardetallebaja(3)" class="btn red"><i class="material-icons">add</i></a>
              </div>
          </div>
      </div>
      <div class="col s12 tabla">
          <div class="row">
            <table class="centered striped">
              <thead>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Series</th>
                <th>Quitar</th>
              </thead>
              <tbody id="filas">
              </tbody>
            </table>  
          </div>
        <div class="col s12 center input-field" id="divbtnregistrar">
            <a onclick="registrarbaja()" class="btn-large">GUARDAR<i class="material-icons right">save</i></a>
        </div>
      </div>
    </div>
    @include('include.footer')
    <script>
        var detalles = [];
        $('#tiposequipo').select2();
        $('#marcas').select2();
        $('#modelos').select2();
        $('#series').select2();
    </script>
    
            <!--MODAL SERIES-->
<div id="modal-series" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h5 class="center" id="nombre-producto"></h5>
        <h5 class="center" id="cantidad-series"></h5>
    </div>
  </div>
  <div class="row">
      <table class="striped centered">
          <thead>
              <tr>
                  <th>SERIES</th>
                  <th>QUITAR</th>
              </tr>
          </thead>
          <tbody id="modal-filas">
          </tbody>
      </table>
  </div>
    <div class="row center botones" style="margin-top: 15px;">
        <div class="col s12 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>
            
    <!--MODAL ERRORES-->
<div id="modal-errores" class="modal" style="width: 80% !important;">
  <div class="row">
    <div class="titulo red darken-1">
        <h5 class="center">ERRORES</h5>
    </div>
  </div>
  <div class="row">
      <table class="striped centered">
          <thead>
              <tr>
                  <th>SERIE</th>
                  <th>ERROR</th>
              </tr>
          </thead>
          <tbody id="modal-filas-errores">
          </tbody>
      </table>
  </div>
    <div class="row center botones" style="margin-top: 15px;">
        <div class="col s12 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>