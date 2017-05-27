    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>PRODUCTOS</h4>
      </div>
        <a onclick="$('#formlistarproductos').submit()" class="btn-floating btn-large waves-effect left"><i class="material-icons">search</i></a>
      <div class="col s10 offset-s1">
            <form id="formlistarproductos" action="productos" method="GET">
                {{ csrf_field() }}
                <input type="hidden" name="listar" value="S">
                <div class="col s12 l4 center">
                    <label for="proveedor">PROVEEDORES</label>
                    <select id="proveedores" name="id_proveedor" style="width: 100%;">
                        <option value="x">TODOS</option>
                        <option value="0" @if($idproveedor=="0") selected @endif >COMPRA PROPIA</option>
                        @forelse($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}" @if($proveedor->id==$idproveedor) selected @endif>{{$proveedor->razon}}</option>
                        @empty
                            <option value="0">No hay proveedores</option>
                        @endforelse
                    </select>
                    
                </div>
                <div class="col s12 l4 center">
                    <label for="tiposequipo">TIPOS</label>
                    <select id="tiposequipo" name="id_tipo_equipo"  onchange="listarmodelos()"  style="width: 100%;">
                        <option value="0">TODAS</option>
                        @forelse($tiposequipo as $tipo)
                            <option value="{{$tipo->id}}" @if($tipo->id==$idtipoequipo) selected @endif>{{$tipo->nombre}}</option>
                        @empty
                            <option value="0">No hay tipos de equipo</option>
                        @endforelse
                    </select>
                </div>
                <div class="col s12 l4 center">
                    <label for="marcas">MARCAS</label>
                    <select id="marcas" name="id_marca" onchange="listarmodelos()"  style="width: 100%;">
                        <option value="0">TODAS</option>
                        @forelse($marcas as $marca)
                            <option value="{{$marca->id}}" @if($marca->id==$idmarca) selected @endif>{{$marca->nombre}}</option>
                        @empty
                            <option value="0">No hay marcas</option>
                        @endforelse
                    </select>
                </div>
                <div class="col s12 l4 center">
                    <label for="modelos">MODELOS</label>
                    <select id="modelos" name="id_modelo"  style="width: 100%;">
                        <option value="0">ELIJA UNA MARCA</option>
                    </select>
                </div>
                <div class="col s12 l4 center">
                    <label for="sucursales">SUCURSALES</label>
                    <select id="sucursales" name="id_sucursal"  style="width: 100%;">
                        <option value="0">TODAS</option>
                        @forelse($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}" @if($sucursal->id==$idsucursal) selected @endif>{{$sucursal->nombre}}</option>
                        @empty
                            <option value="0">No hay sucursales</option>
                        @endforelse
                    </select>
                </div>
            </form>
                
        </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp">
          <thead>
            <th>N</th>
            <th>Proveedor</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Tipo</th>
            <th>Sucursal</th>
            <th>Cantidad</th>
            <th>Detalle</th>
          </thead>
          <tbody>
            @forelse($productos as $producto)
                <tr>
                  <td>{{$w=$w+1}}</td>
                  @if($producto->nombreproveedor==null)
                    <td>COMPRA PROPIA</td>
                  @else
                    <td>{{$producto->nombreproveedor}}</td>
                  @endif
                  <td>{{$producto->nombremarca}}</td>
                  <td>{{$producto->nombremodelo}}</td>
                  <td>{{$producto->nombretipoequipo}}</td>
                  <td>{{$producto->nombresucursal}}</td>
                  <td>{{$producto->cantidad}}</td>
                  <td><a href="" class="btn"><i class="material-icons">input</i></a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay productos</td>
                </tr>
            @endforelse
          </tbody>
        </table>
         <div class="row center">
            {{$productos->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')
    <script>
        $('#proveedores').select2();
        $('#marcas').select2();
        $('#modelos').select2();
        $('#tiposequipo').select2();
        $('#sucursales').select2();
    </script>
    @if($idmarca>0)
        <script>listarmodelos();</script>
    @endif
    