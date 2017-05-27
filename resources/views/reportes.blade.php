    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>REPORTES</h4>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 center card fullcol">
                <div class="titulo row">
                    <h5>REPORTE DE PRODUCTOS</h5>
                </div>
                <form id="reporte1" method="POST" action="reportes">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="1">
                    <div class="col s12 m6 l4">
                        <label>TIPOS DE SUCURSAL</label>
                        <select name="tiposucursal" id="tipossucursal1" style="width: 100%;" onchange="reportelistarsucursales(1)">
                          <option value="0">TODOS</option>
                          @forelse($tipossucursal as $tiposucursal)
                              <option value="{{$tiposucursal->id}}">{{$tiposucursal->nombre}}</option>
                          @empty
                              <option value="0">No hay tipos de sucursal</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>TIPOS DE TERRITORIO</label>
                        <select name="tipoterritorio" id="tiposterritorio1" style="width: 100%;" onchange="reportelistarsucursales(1)">
                          <option value="0">TODOS</option>
                          @forelse($tiposterritorio as $tipoterritorio)
                              <option value="{{$tipoterritorio->id}}">{{$tipoterritorio->nombre}}</option>
                          @empty
                              <option value="0">No hay tipos de territorio</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4" id="divsucursales1">
                        <label>SUCURSAL</label>
                        <select name="sucursal" id="sucursales1" style="width: 100%;">
                          <option value="0">TODAS</option>
                          @forelse($sucursales as $sucursal)
                              <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                          @empty
                              <option value="0">No hay sucursales</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>TIPOS DE EQUIPO</label>
                        <select name="tipoequipo" id="tiposequipo1" style="width: 100%;" onchange="reportelistarmodelos(1)">
                          <option value="0">TODAS</option>
                          @forelse($tiposequipo as $tipoequipo)
                              <option value="{{$tipoequipo->id}}">{{$tipoequipo->nombre}}</option>
                          @empty
                              <option value="0">No hay tipos de equipo</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>MARCAS</label>
                        <select name="marca" id="marcas1" style="width: 100%;" onchange="reportelistarmodelos(1)">
                          <option value="0">TODAS</option>
                          @forelse($marcas as $marca)
                              <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                          @empty
                              <option value="0">No hay marcas</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4" id="divmodelos1">
                        <label>MODELOS</label>
                        <select name="modelo" id="modelos1" style="width: 100%;">
                          <option value="0">TODOS</option>
                          @forelse($modelos as $modelo)
                              <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                          @empty
                              <option value="0">No hay modelos</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>TIPO DE INGRESO</label>
                        <select name="ingreso" id="ingresos1" style="width: 100%;">
                          <option value="X">AMBOS</option>
                          <option value="C">CONTRATO</option>
                          <option value="A">ADQUISICIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>PROVEEDORES</label>
                        <select name="proveedor" id="proveedores1" style="width: 100%;">
                          <option value="0">TODOS</option>
                          @forelse($proveedores as $proveedor)
                              <option value="{{$proveedor->id}}">{{$proveedor->razon}}</option>
                          @empty
                              <option value="0">No hay proveedores</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l1 offset-l1" style="margin-top: 25px;">
                        <a onclick="reporte(1)" class="btn">GENERAR</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col s10 offset-s1 center card fullcol">
                <div class="titulo row">
                    <h5>REPORTE DE CONTRATOS / COMPRAS</h5>
                </div>
                <form id="reporte2" method="POST"  action="reportes">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="2">
                    <div class="col s12 m6 l4">
                        <label>TIPO DE INGRESO</label>
                        <select name="ingreso" id="ingresos2" style="width: 100%;">
                          <option value="X">AMBOS</option>
                          <option value="C">CONTRATO</option>
                          <option value="A">ADQUISICIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>PROVEEDORES</label>
                        <select name="proveedor" id="proveedores2" style="width: 100%;">
                          <option value="0">TODOS</option>
                          @forelse($proveedores as $proveedor)
                              <option value="{{$proveedor->id}}">{{$proveedor->razon}}</option>
                          @empty
                              <option value="0">No hay proveedores</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l1 offset-l1" style="margin-top: 25px;">
                        <a onclick="reporte(2)" class="btn">GENERAR</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col s10 offset-s1 center card fullcol">
                <div class="titulo row">
                    <h5>REPORTE DE CASOS</h5>
                </div>
                <form id="reporte3" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="3">
                    <div class="col s12 m6 l4">
                        <label>TIPOS DE SUCURSAL</label>
                        <select name="tiposucursal" id="tipossucursal3" style="width: 100%;" onchange="reportelistarsucursales(3)">
                          <option value="0">TODOS</option>
                          @forelse($tipossucursal as $tiposucursal)
                              <option value="{{$tiposucursal->id}}">{{$tiposucursal->nombre}}</option>
                          @empty
                              <option value="0">No hay tipos de sucursal</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>TIPOS DE TERRITORIO</label>
                        <select name="tipoterritorio" id="tiposterritorio3" style="width: 100%;" onchange="reportelistarsucursales(3)">
                          <option value="0">TODOS</option>
                          @forelse($tiposterritorio as $tipoterritorio)
                              <option value="{{$tipoterritorio->id}}">{{$tipoterritorio->nombre}}</option>
                          @empty
                              <option value="0">No hay tipos de territorio</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4" id="divsucursales3">
                        <label>SUCURSAL</label>
                        <select name="sucursal" id="sucursales3" style="width: 100%;">
                          <option value="0">TODAS</option>
                          @forelse($sucursales as $sucursal)
                              <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                          @empty
                              <option value="0">No hay sucursales</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>TIPOS DE EQUIPO</label>
                        <select name="tipoequipo" id="tiposequipo3" style="width: 100%;" onchange="reportelistarmodelos(3)">
                          <option value="0">TODAS</option>
                          @forelse($tiposequipo as $tipoequipo)
                              <option value="{{$tipoequipo->id}}">{{$tipoequipo->nombre}}</option>
                          @empty
                              <option value="0">No hay tipos de equipo</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>MARCAS</label>
                        <select name="marca" id="marcas3" style="width: 100%;" onchange="reportelistarmodelos(3)">
                          <option value="0">TODAS</option>
                          @forelse($marcas as $marca)
                              <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                          @empty
                              <option value="0">No hay marcas</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4" id="divmodelos3">
                        <label>MODELOS</label>
                        <select name="modelo" id="modelos3" style="width: 100%;">
                          <option value="0">TODOS</option>
                          @forelse($modelos as $modelo)
                              <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                          @empty
                              <option value="0">No hay modelos</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label>PROVEEDORES</label>
                        <select name="proveedor" id="proveedores3" style="width: 100%;">
                          <option value="0">TODOS</option>
                          @forelse($proveedores as $proveedor)
                              <option value="{{$proveedor->id}}">{{$proveedor->razon}}</option>
                          @empty
                              <option value="0">No hay proveedores</option>
                          @endforelse
                        </select>
                    </div>
                    <div class="col s12 m6 l3 input-field">
                        <div class="col s3">
                            <label>DESDE</label>
                        </div>
                        <div class="col s9">
                            <input type="date" name="desde" value="{{$desde}}-01-01">
                        </div>
                    </div>
                    <div class="col s12 m6 l3 input-field">
                        <div class="col s3">
                            <label>HASTA</label>
                        </div>
                        <div class="col s9">
                            <input type="date" name="hasta" value="{{$hoy}}">
                        </div>
                    </div>
                    <div class="col s12 m6 l1" style="margin-top: 25px;">
                        <a onclick="reporte(3)" class="btn">GENERAR</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('include.footer')
    
    <script type="text/javascript">
        $('select').select2();
    </script>