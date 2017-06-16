    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <a onclick="$('#formbajas').submit()" class="btn-floating btn-large waves-effect left"><i class="material-icons">search</i></a>
      <div class="row titulo center">
        <h4>BAJAS</h4>
      </div>
      <div class="col s10 offset-s1">
            <form id="formbajas" action="bajas" method="GET">
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
            <th>Sucursal</th>
            <th>Ver</th>
          </thead>
          <tbody>
            @forelse($bajas as $baja)
                <tr>
                  <td>{{$baja->numero}}</td>
                  <td>{{date('d/m/Y',strtotime($baja->fecha))}}</td>
                  <td>{{$baja->sucursal()->nombre}}</td>
                  <td><a href="baja?id={{$baja->id}}" class="btn"><i class="material-icons">input</i></a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay bajas</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$bajas->appends(['sucursal'=>$idsucursal,'desde'=>$desde,'hasta'=>$hasta])->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')
    <script>
        $('#sucursal').select2();
    </script>