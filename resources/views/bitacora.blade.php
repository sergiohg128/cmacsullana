    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <a onclick="$('#formbitacora').submit()" class="btn-floating btn-large waves-effect left"><i class="material-icons">search</i></a>
      <div class="row titulo center">
        <h4>TRASLADOS</h4>
      </div>
      <div class="col s10 offset-s1">
            <form id="formbitacora" action="bitacora" method="GET">
                {{ csrf_field() }}
                <div class="col s12 l4 center">
                    <label for="tabla">TABLA</label>
                    <select id="tabla" name="tabla" style="width: 100%;" required>
                        <option value="archivo" @if($tabla=="archivo") selected @endif >ARCHIVO</option>
                        <option value="area" @if($tabla=="area") selected @endif >ÁREA</option>
                        <option value="caso" @if($tabla=="caso") selected @endif >CASO</option>
                        <option value="compra" @if($tabla=="compra") selected @endif >COMPRA</option>
                        <option value="contrato" @if($tabla=="contrato") selected @endif >CONTRATO</option>
                        <option value="guia" @if($tabla=="guia") selected @endif >GUIA DE ENTRADA</option>
                        <option value="baja" @if($tabla=="baja") selected @endif >GUIA DE BAJA</option>
                        <option value="marca" @if($tabla=="marca") selected @endif >MARCA</option>
                        <option value="modelo" @if($tabla=="modelo") selected @endif >MODELO</option>
                        <option value="permiso" @if($tabla=="permiso") selected @endif >PERMISO</option>
                        <option value="proveedor" @if($tabla=="proveedor") selected @endif >PROVEEDOR</option>
                        <option value="sucursal" @if($tabla=="sucursal") selected @endif >SUCURSAL</option>
                        <option value="tipoequipo" @if($tabla=="tipoequipo") selected @endif >TIPO DE EQUIPO</option>
                        <option value="tiposucursal" @if($tabla=="tiposucursal") selected @endif >TIPO DE SUCURSAL</option>
                        <option value="tipoterritorio" @if($tabla=="tipoterritorio") selected @endif >TIPO DE TERRITORIO</option>
                        <option value="tipousuario" @if($tabla=="tipousuario") selected @endif >TIPOS DE USUARIO</option>
                        <option value="traslado" @if($tabla=="traslado") selected @endif >TRASLADO</option>
                        <option value="usuario" @if($tabla=="usuario") selected @endif >USUARIO</option>
                        <option value="zona" @if($tabla=="zona") selected @endif >ZONA</option>
                    </select>
                </div>
                <div class="col s12 m6 l4 center input-field">
                    <div class="col s3">
                        <label>Desde</label>
                    </div>
                    <div class="col s9">
                        <input type="date" id="desde" name="desde" value="{{$desde}}">
                    </div>
                </div>
                <div class="col s12 m6 l4 center input-field">
                    <div class="col s3">
                        <label>Hasta</label>
                    </div>
                    <div class="col s9">
                        <input type="date" id="hasta" name="hasta" value="{{$hasta}}">
                    </div>
                </div>
            </form>
                
        </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Tabla</th>
            <th>Acción</th>
            <th>Detalle</th>
            <th>Fecha</th>
            <th>Usuario</th>
          </thead>
          <tbody>
            @forelse($bitacoras as $bitacora)
                <tr>
                  <td>{{$bitacora->tabla}}</td>
                  <td>{{$bitacora->tipo}}</td>
                  <td>{{$bitacora->accion}}</td>
                  <td>{{date('d/m/Y H:i',strtotime($bitacora->fecha))}}</td>
                  <td>{{$bitacora->apellidos}} {{$bitacora->nombre}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay acciones</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$bitacoras->appends(['tabla'=>$tabla,'desde'=>$desde,'hasta'=>$hasta])->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')
    <script>
        $('#tabla').select2();
    </script>