    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>TRASLADO {{$traslado->numero}}</h4>
      </div>
        <div class="row">
            <div class="col s10 offset-s1">
                  <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>SUCURSAL ORIGEN</h5>
                      </div>
                      <p class="center">{{$traslado->sucursalenvia()->nombre}}</p>
                  </div>
                  <div class="col s12 m4 offset-m2 card fullcol">
                      <div class="row titulo center">
                          <h5>SUCURSAL DESTINO</h5>
                      </div>
                      <p class="center">{{$traslado->sucursalrecibe()->nombre}}</p>
                  </div>
                  <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>GUIA DE REMISION</h5>                
                      </div>
                      <p class="center">{{$traslado->remision}}</p>
                  </div>
                  <div class="col s12 m4 offset-m2 card fullcol">
                      <div class="row titulo center">
                          <h5>FECHA</h5>
                      </div>
                      <p class="center">{{date('d/m/Y',strtotime($traslado->fecha))}}</p>
                  </div>
                    <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>MOTIVO</h5>                
                      </div>
                      <p class="center">{{$traslado->motivotraslado()->nombre}}</p>
                  </div>
                    <div class="col s12 m4 offset-m2 card fullcol">
                        <div class="row titulo center">
                            <h5>DESCRIPCIÓN</h5>                
                        </div>
                        <p class="center">{{$traslado->descripcion}}</p>
                    </div>
              </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
              <table class="centered striped resp2">
                <thead>
                  <th>N</th>
                  <th>Producto</th>
                  <th>Series</th>
                </thead>
                <tbody id="filas">
                      @forelse($detalles as $detalle)
                          <tr id="fila{{$detalle->id}}">
                            <td>{{$w = $w+1}}</td>
                            <td>{{$detalle->nombretipoequipo}} {{$detalle->nombremarca}} {{$detalle->nombremodelo}}</td>
                            <td><a href="traslado-series?id={{$detalle->id}}&t={{$traslado->id}}"><button class="btn">{{$detalle->cantidad}}</button></a></td>
                          </tr>
                      @empty
                          <tr id="filaempty">
                              <td colspan="5">No hay productos añadidos</td>
                          </tr>
                      @endforelse
                </tbody>
              </table>
            </div>
        </div>
      <div class="row">
            <div class="col s10 offset-s1">
                <div class="titulo row center">
                    <h5>ARCHIVO</h5>
                </div>
                @if($archivo!=null)
                    <div class="row center">
                        <a href="descargar-archivo?id={{$archivo->id}}"><button class="btn brown">DESCARGAR ARCHIVO ({{$archivo->extension}})</button></a>
                    </div>
                @endif
                <div class="row">
                    <form action="subir-archivo" method="POST"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$traslado->id}}">
                        <input type="hidden" name="tipo" value="traslado">
                        <div class="col s12 m6 l8 offset-l2 offset-m3 input-field file-field">
                            <div class="btn green"><span>ARCHIVO</span>
                              <input id="archivo" name="archivo" type="file" required>
                            </div>
                            <div class="file-path-wrapper">
                              <input type="text" class="file-path validate" placeholder="Suba un archivo en cualquier formato">
                            </div>
                        </div>
                        <div class="col s12 center">
                            <button type="submit" class="btn">GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')