    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>SUCURSAL: {{$sucursal->nombre}}</h4>
        <h5>{{$modelo->nombretipoequipo}} {{$modelo->nombremarca}} {{$modelo->nombre}}</h5>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Proveedor</th>
            <th>Contrato</th>
            <th>Fecha</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>SLA</th>
            <th>Stock</th>
          </thead>
          <tbody id="filas">
            @forelse($productos as $producto)
                <tr id="fila{{$producto->id_detalle_contrato}}">
                  <td>{{$producto->razon}}</td>
                  <td>{{$producto->numero}}</td>
                  <td>{{date('d/m/Y',strtotime($producto->fecha))}}</td>
                  @if($producto->tipocontrato=="C")
                    <td>{{date('d/m/Y',strtotime($producto->inicio))}}</td>
                    <td>{{date('d/m/Y',strtotime($producto->fin))}}</td>
                    <td>{{$producto->sla()}} horas</td>
                  @else
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                  @endif
                  <td><a href="series?d={{$producto->id_detalle_contrato}}&s={{$sucursal->id}}"><button class="btn">{{$producto->total}}</button></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="7">No hay productos en stock</td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @include('include.footer')