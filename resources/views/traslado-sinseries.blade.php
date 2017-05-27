    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>TRASLADO {{$producto->numero}}</h4>
        <h5>{{$producto->nombretipoequipo}} {{$producto->nombremarca}} {{$producto->nombremodelo}}</h5>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped" id="series">
          <input type="hidden" id="s" value="{{$producto->id_origen}}">
          <thead>
            <th class="numerofila">N</th>
            <th>Serie</th>
            <th class="estadoserie"></th>
            @if($faltan>1)
                <th class="numerofila">N</th>
                <th>Serie</th>
                <th class="estadoserie"></th>
                    @if($faltan>2)
                        <th class="numerofila">N</th>
                        <th>Serie</th>
                        <th class="estadoserie"></th>
                    @endif
            @endif
          </thead>
          <tbody id="filas">
                @for($i=1;$i<=$faltan;$i++)
                    <tr>
                      <td class="numerofila">{{$i}}</td>
                      <td>
                            <input type="text" id="serie{{$detalles[$i-1]->id}}" class="inputserietraslado" data-href="{{$detalles[$i-1]->id}}">
                      </td>
                      <td class="estadoserie" id="estado{{$detalles[$i-1]->id}}"></td>
                      @if(($i+1)<=$faltan)
                        <td class="numerofila">{{$i=$i+1}}</td>
                        <td>
                            <input type="text" id="serie{{$detalles[$i-1]->id}}" class="inputserietraslado" data-href="{{$detalles[$i-1]->id}}">
                        </td>
                        <td class="estadoserie" id="estado{{$detalles[$i-1]->id}}"></td>
                      @endif
                      @if(($i+1)<=$faltan)
                        <td class="numerofila">{{$i=$i+1}}</td>
                        <td>
                            <input type="text" id="serie{{$detalles[$i-1]->id}}" class="inputserietraslado" data-href="{{$detalles[$i-1]->id}}">
                        </td>
                        <td class="estadoserie" id="estado{{$detalles[$i-1]->id}}"></td>
                      @endif
                    </tr>
                @endfor
          </tbody>
        </table>
      </div>
    </div>
    
    @include('include.footer')