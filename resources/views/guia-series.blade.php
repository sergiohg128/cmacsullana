    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>PRODUCTO:{{$detalle->nombretipoequipo}} {{$detalle->nombremarca}} {{$detalle->nombremodelo}} </h4>
      </div>
        <div class="col s10 offset-s1">
            <div class="col s12 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>GUIA</h5>
                </div>
                <p class="center">{{$guia->numero}}</p>
            </div>
            <div class="col s12 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>SUCURSAL LLEGADA</h5>
                </div>
                <p class="center">{{$guia->sucursal()->nombre}}</p>
            </div>
            <div class="col s12 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>PROVEEDOR</h5>
                </div>
                <p class="center">{{$guia->contrato()->proveedor()->razon}}</p>
            </div>
            <div class="col s12 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>CONTRATO</h5>
                </div>
                @if($guia->contrato()->tipo=="C")
                    <p class="center">{{$guia->contrato()->numero}}</p>
                @else
                    <p class="center">SIN CONTRATO</p>
                @endif
            </div>
        </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped">
          <thead>
            <th>N</th>
            <th>Serie</th>
            <th>Sucursal</th>
            <th>Área</th>
          </thead>
          <tbody id="filas">
            @forelse($productos as $producto)
                <tr>
                    <td>{{$w = $w + 1}}</td>
                    <td>{{$producto->serie}}</td>
                    @if($producto->estado=="N")
                        <td>{{$producto->sucursal()->nombre}}</td>
                        @if($producto->id_area_sucursal!=null)
                            <td>{{$producto->areasucursal()->area()->nombre}}</td>
                        @else
                            <td>-</td>
                        @endif
                    @elseif($producto->estado=="A")
                        <td colspan="2">DADO DE BAJA</td>
                    @endif
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="2">No hay productos en stock</td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @include('include.footer')