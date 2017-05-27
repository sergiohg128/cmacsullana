    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>TRASLADO NUEVO</h4>
        <h5>DESTINO: {{$caso->nombresucursal}}</h5>
      </div>
      <div class="row">
            <div class="col s6 offset-s3 center">
                <form id="trasladoform" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="caso" value="{{$caso->id}}">
                    <input type="hidden" name="destino" id="destino" value="{{$caso->sucursal_destino}}">
                    <input type="hidden" name="serie" id="serie-trasladar" value="0">
                    <div class="col s12 l6 input-field">
                        <input type="text" name="numero" id="numero">
                        <label for="numero">GUIA DE REMISIÓN</label>
                    </div>
                    <div class="col s12 l6 input-field">
                        <div class="col s2">
                            <label>FECHA</label>
                        </div>
                        <div class="col s10">
                            <input type="date" id="fecha" name="fecha" value="{{$hoy}}">
                        </div>
                    </div>
                    <div class="col s12 input-field">
                        <select id="origen" name="sucursal">
                            @forelse($sucursales as $sucursal)
                                <option value="{{$sucursal->id}}" @if($caso->id_sucursal==$sucursal->id) selected @endif>{{$sucursal->nombre}}</option>
                            @empty
                                <option value="0">NO HAY SUCURSALES</option>
                            @endforelse
                          </select>
                        <label for="sucursales">SUCURSAL</label>
                      </div>
                    <div class="col s12 input-field">
                        <select id="motivos" name="motivo">
                            @foreach($motivos as $motivo)
                                <option value="{{$motivo->id}}">{{$motivo->nombre}}</option>
                            @endforeach
                          </select>
                        <label for="motivos">MOTIVO</label>
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
            <h5>SELECCIONAR SERIE</h5>
          </div>
          <div class="row">
              <input type="hidden" name="tiposequipo" id="tiposequipo" value="{{$caso->id_tipo_equipo}}">
              <div class="col s12 m6 l4">
                  <label>MARCAS</label>
                  <select id="marcas" style="width: 100%;" onchange="listarmodelos()">
                    <option value="0">TODAS</option>
                    @forelse($marcas as $marca)
                        <option value="{{$marca->id}}" @if($caso->id_marca==$marca->id) selected @endif>{{$marca->nombre}}</option>
                    @empty
                        <option value="0">NO HAY MARCAS</option>
                    @endforelse
                  </select>
              </div>
              <div class="col s12 m6 l3" id="divmodelos">
                  <label>PRODUCTOS</label>
                  <select  id="modelos" style="width: 100%;">
                    <option value="0">TODOS</option>
                    @forelse($modelos as $modelo)
                        <option value="{{$modelo->id}}" @if($caso->id_modelo==$modelo->id) selected @endif>{{$modelo->nombre}}</option>
                    @empty
                        <option value="0">NO HAY MODELOS</option>
                    @endforelse
                  </select>
              </div>
              <div class="col s12 m6 l1 input-field" id="divbtnbuscar" style="margin-top: 20px;">
                  <a onclick="buscarseriestraslado()" class="btn green"><i class="material-icons">search</i></a>
              </div>
              <div class="col s12 m6 l4" id="divseries">
                  <label>SERIES</label>
                  <select  id="series" style="width: 100%;" onchange="elegirserietrasladocaso()">
                      <option value="0">ELIJA UNA SERIE</option>
                        @forelse($productos as $producto)
                            <option value="{{$producto->id}}">{{$producto->serie}}</option>
                        @empty
                            <option value="0">NO HAY SERIES</option>
                        @endforelse
                  </select>
              </div>
          </div>
      </div>
      <div class="col s12 center input-field" id="divbtnregistrar">
            <a onclick="registrartrasladocaso()" class="btn-large">GUARDAR<i class="material-icons right">save</i></a>
        </div>
    </div>
    @include('include.footer')
    <script>
        $('#marcas').select2();
        $('#modelos').select2();
        $('#series').select2();
    </script>