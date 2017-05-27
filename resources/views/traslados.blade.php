    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <a onclick="$('#formtraslados').submit()" class="btn-floating btn-large waves-effect left"><i class="material-icons">search</i></a>
      <a onclick="$('#modal-traslados').modal('open');" class="btn-floating btn-large waves-effect red"><i class="material-icons">local_shipping</i></a>
      <div class="row titulo center">
        <h4>TRASLADOS</h4>
      </div>
      <div class="col s10 offset-s1">
            <form id="formtraslados" action="traslados" method="GET">
                {{ csrf_field() }}
                <div class="col s12 l4 center">
                    <label for="sucursal">SUCURSAL</label>
                    <select id="sucursal" name="sucursal" style="width: 100%;">
                        <option value="0">Todos</option>
                        @forelse($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}" @if($idsucursal==$sucursal->id) selected @endif >{{$sucursal->nombre}}</option>
                        @empty
                            <option value="0">No hay sucursales</option>
                        @endforelse
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
            <th>Número</th>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Ver</th>
          </thead>
          <tbody>
            @forelse($traslados as $traslado)
                <tr>
                  <td>{{$traslado->numero}}</td>
                  <td>{{date('d/m/Y',strtotime($traslado->fecha))}}</td>
                  <td>{{$traslado->sucursalenvia()->nombre}}</td>
                  <td>{{$traslado->sucursalrecibe()->nombre}}</td>
                  <td><a href="traslado?id={{$traslado->id}}" class="btn"><i class="material-icons">input</i></a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay traslados</td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @include('include.footer')
    <script>
        $('#sucursal').select2();
    </script>