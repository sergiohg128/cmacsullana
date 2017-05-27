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
          <thead>
            <th class="numerofila">N</th>
            <th>Serie</th>
            @if($existen>1)
                <th class="numerofila">N</th>
                <th>Serie</th>
                    @if($existen>2)
                        <th class="numerofila">N</th>
                        <th>Serie</th>
                    @endif
            @endif
          </thead>
          <tbody id="filas">
                @for($i=1;$i<=$existen;$i++)
                    <tr>
                      <td class="numerofila">{{$i}}</td>
                      <td>
                          <input type="text"  value="{{$detalles[$i-1]->serie}}" readonly>
                      </td>
                      @if(($i+1)<=$existen)
                        <td class="numerofila">{{$i=$i+1}}</td>
                        <td>
                            <input type="text"  value="{{$detalles[$i-1]->serie}}" readonly>
                        </td>
                      @endif
                      @if(($i+1)<=$existen)
                        <td class="numerofila">{{$i=$i+1}}</td>
                        <td>
                            <input type="text"  value="{{$detalles[$i-1]->serie}}" readonly>
                        </td>
                      @endif
                    </tr>
                @endfor
          </tbody>
        </table>
      </div>
    </div>
    
    @include('include.footer')