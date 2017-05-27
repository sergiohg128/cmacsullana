    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>COMPRA NUEVA</h4>
      </div>
      <div class="row">
            <div class="col s6 offset-s3 center">
                <form id="formcompra" method="POST">
                    {{ csrf_field() }}
                    <div id="otrosinput"></div>
                    <div class="col s12 input-field">
                        <input type="text" name="numero" id="numero">
                        <label for="numero">NÚMERO DE GUIA</label>
                    </div>
                    <div class="col s12 input-field">
                        <select id="proveedores" name="proveedor">
                            <option value="0">ELIJA UN PROVEEDOR</option>
                            @forelse($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}">{{$proveedor->razon}}</option>
                            @empty
                                <option value="0">No hay proveedores</option>
                            @endforelse
                          </select>
                        <label for="proveedor">PROVEEDOR</label>
                    </div>
                    <div class="col s12 input-field">
                        <select id="sucursales" name="sucursal">
                            <option value="0">ELIJA UNA SUCURSAL DE DESTINO</option>
                            @forelse($sucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                            @empty
                                <option value="0">NO HAY SUCURSALES</option>
                            @endforelse
                          </select>
                        <label for="sucursales">SUCURSAL</label>
                    </div>
                    <div class="col s12 input-field">
                        <div class="col s3">
                            <label>FECHA DE GUIA</label>
                        </div>
                        <div class="col s9">
                            <input type="date" id="fecha" name="fecha">
                        </div>
                    </div>
                    <div class="col s12 input-field">
                        <textarea name="comentario" id="comentario" class="materialize-textarea"></textarea>
                        <label for="comentario">COMENTARIO(Opcional)</label>
                    </div>
                </form>
            </div>
        </div>
      <div class="col s10 offset-s1">
          <div class="row">
              <form id="detallecompra" action="detallecompra" method="POST">
                  {{ csrf_field() }}
                  <div class="col s12 m12 l8 input-field">
                      <select name="modelo" id="modelos" style="width: 100%;">
                      <option value="0">ELIJA UN PRODUCTO</option>
                      @forelse($modelos as $modelo)
                      <option value="{{$modelo->id}}" id="modelo{{$modelo->id}}">{{$modelo->nombretipo}} {{$modelo->nombremarca}} {{$modelo->nombremodelo}}</option>
                      @empty
                          <option value="0">NO HAY PRODUCTOS</option>
                      @endforelse
                    </select>
                </div>
                <div class="col s12 m6 l3 offset-l1  input-field">
                    <input type="number" id="cantidad" min="1" step="1">
                    <label for="cantidad" id="lbl-cantidad">Cantidad a Recibir</label>
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
                    <form id="compraexcelform">
                        {{ csrf_field() }}
                        <input type="hidden" name="tipo" value="1">
                        <input type="hidden" name="modelo" id="modeloexcel">
                        <input type="hidden" name="cantidad" id="cantidadexcel">
                        <div class="col s12 m6 l10 input-field file-field">
                        <div class="btn green"><span>EXCEL</span>
                          <input id="excel" name="excel" type="file" accept=".xlsx">
                        </div>
                        <div class="file-path-wrapper">
                          <input type="text" class="file-path validate" placeholder="Suba un archivo en formato .xlsx">
                        </div>
                      </div>
                      <div class="col s12 m6 l1 offset-s1 input-field" id="divbtnagregar1">
                          <a onclick="agregardetallecompra(1)" class="btn red"><i class="material-icons">add</i></a>
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
                          <a onclick="agregardetallecompra(2)" class="btn red"><i class="material-icons">add</i></a>
                      </div>
              </div>
            </div>
        </div>
      <div class="col s12 tabla">
          <div class="row">
            <table class="centered striped">
              <thead>
                <th>Producto</th>
                <th>Cantidad a Ingresar</th>
                <th>Cantidad de series</th>
                <th>Series</th>
                <th>Quitar</th>
              </thead>
              <tbody id="filas">
                  <tr id="filaempty">
                      <td colspan="5">No ha añadido productos a la guia nueva</td>
                  </tr>
              </tbody>
            </table>  
          </div>
      </div>
      <div class="col s12 center input-field" id="divbtnregistrar">
            <a onclick="registrarcompra()" class="btn-large">REGISTRAR<i class="material-icons right">save</i></a>
        </div>
    </div>
    @include('include.footer')
    <script>
        var detalles = [];
        $('#modelos').select2();
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