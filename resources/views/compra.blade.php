    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>GUIA {{$guia->numero}}</h4>
        <h5>PROVEEDOR: {{$guia->contrato()->proveedor()->razon}}</h5>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
              <table class="centered striped resp2">
                <thead>
                  <th>Tipo</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Cantidad</th>
                </thead>
                <tbody id="filas">
                      @foreach($detalles as $detalle)
                          <tr>
                            <td>{{$detalle->nombretipoequipo}}</td>
                            <td>{{$detalle->nombremarca}}</td>
                            <td>{{$detalle->nombremodelo}}</td>
                            <td>{{$detalle->cantidad}}</td>
                          </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    @include('include.footer')