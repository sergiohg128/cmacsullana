    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>PRODUCTO:{{$detalle->nombretipoequipo}} {{$detalle->nombremarca}} {{$detalle->nombre}} </h4>
      </div>
        <div class="col s10 offset-s1">
            <div class="col s12 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>SUCURSAL</h5>
                </div>
                <p class="center">{{$sucursal->nombre}}</p>
            </div>
            <div class="col s12 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>PROVEEDOR</h5>
                </div>
                <p class="center">{{$detalle->razon}}</p>
            </div>
            <div class="col s12 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>CONTRATO</h5>
                </div>
                @if($detalle->tipocontrato=="C")
                    <p class="center">{{$detalle->numero}}</p>
                @else
                    <p class="center">SIN CONTRATO</p>
                @endif
            </div>
            <div class="col s12 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>SLA</h5>                
                </div>
                @if($detalle->tipocontrato=="C")
                    <p class="center">{{$detalle->sla}} horas</p>
                @else
                    <p class="center">SIN SLA</p>
                @endif
            </div>
        </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped">
          <thead>
            <th>N</th>
            <th>Serie</th>
            <th>Área</th>
            <th class="estadoserie"></th>
          </thead>
          <tbody id="filas">
            @forelse($productos as $producto)
                <tr id="fila{{$producto->id}}">
                  <td>{{$w = $w + 1}}</td>
                  <td>{{$producto->serie}}</td>
                    <td>
                        <select id="select{{$producto->id}}" onchange="asignararea({{$producto->id}})">
                            <option value="0">SIN ÁREA ASIGNADA</option>
                            @forelse($areas as $area)
                                @if($producto->id_area_sucursal==$area->id)
                                <option value="{{$area->id}}" selected>{{$area->nombre}}</option>
                                @else
                                    <option value="{{$area->id}}">{{$area->nombre}}</option>
                                @endif
                            @empty
                                <option value="-1">NO HAY ÁREAS EN LA SUCURSAL</option>
                            @endforelse
                        </select>
                    </td>
                    <td class="estadoserie" id="estado{{$producto->id}}"></td>
                        
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