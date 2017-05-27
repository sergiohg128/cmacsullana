    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <a href="traslado-nuevo?id={{$sucursal->id}}" class="btn-floating btn-large waves-effect red"><i class="material-icons">local_shipping</i></a>
      <div class="row titulo center">
        <h4>SUCURSAL {{$sucursal->nombre}}</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Stock</th>
            <th>Detalles</th>
          </thead>
          <tbody id="filas">
            @forelse($productos as $producto)
                <tr id="fila{{$producto->id}}">
                  <td>{{$producto->nombretipoequipo}}</td>
                  <td>{{$producto->nombremarca}}</td>
                  <td>{{$producto->nombremodelo}}</td>
                  <td>{{$producto->total}}</td>
                  <td><a href="stock?m={{$producto->id_modelo}}&s={{$sucursal->id}}"><button class="btn"><i class="material-icons">input</i></button></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="6">No hay productos en stock</td>
                </tr>
            @endforelse
          </tbody>
        </table>
          <div class="row center">
            {{$productos->appends(['id'=>$sucursal->id])->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')