    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a href="caso-nuevo" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
      <div class="row titulo center">
        <h4>CASOS DE SERVICIO</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp">
          <thead>
            <th>N</th>
            <th>Fecha</th>
            <th>Serie</th>
            <th>Producto</th>
            <th>Estado</th>
            <th>Ver</th>
          </thead>
          <tbody>
            @forelse($casos as $caso)
                <tr>
                  <td>{{$caso->numero}}</td>
                  <td>{{date('d/m/Y',strtotime($caso->fecha))}}</td>
                  <td>{{$caso->serie}}</td>
                  <td>{{$caso->nombretipoequipo}} {{$caso->nombremarca}} {{$caso->nombremodelo}}</td>
                  @if($caso->estado=="N")
                    <td>PENDIENTE</td>
                  @elseif($caso->estado=="T")
                    <td>CON TËCNICO ASIGNADO</td>
                  @elseif($caso->estado=="D")
                    <td>CON DIAGNOSTICO</td>
                  @elseif($caso->estado=="E")
                    <td>EN TRÁNSITO</td>
                  @elseif($caso->estado=="F")
                    <td>FINALIZADO</td>
                  @endif
                  <td><a href="caso?id={{$caso->id}}" class="btn"><i class="material-icons">input</i></a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay casos de servicio</td>
                </tr>
            @endforelse
          </tbody>
        </table>
          <div class="row center">
            {{$casos->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')