    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>GUIA DE BAJA {{$baja->numero}}</h4>
      </div>
        <div class="row">
            <div class="col s10 offset-s1">
                  <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>SUCURSAL</h5>
                      </div>
                      <p class="center">{{$baja->sucursal()->nombre}}</p>
                  </div>
                <div class="col s12 m4 offset-m2 card fullcol">
                      <div class="row titulo center">
                          <h5>FECHA</h5>
                      </div>
                      <p class="center">{{date('d/m/Y',strtotime($baja->fecha))}}</p>
                  </div>
                <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>NÚMERO INTERNO</h5>
                      </div>
                      <p class="center">{{$baja->interno}}</p>
                  </div>
                  <div class="col s12 m4 offset-m2 card fullcol">
                      <div class="row titulo center">
                          <h5>GUIA DE REMISION</h5>                
                      </div>
                      <p class="center">{{$baja->remision}}</p>
                  </div>
                  @if($baja->descripcion!=null)
                    <div class="col s10 offset-s1 card fullcol">
                        <div class="row titulo center">
                            <h5>DESCRIPCIÓN</h5>                
                        </div>
                        <p class="center">{{$baja->descripcion}}</p>
                    </div>
                  @endif
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
                            <td><a href="baja-series?id={{$detalle->id}}&b={{$baja->id}}"><button class="btn">{{$detalle->cantidad}}</button></a></td>
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
                    <h5>FORMATO GENERADO</h5>
                </div>
                <div class="row center">
                    <form id="reporte8" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="8">
                        <input type="hidden" name="baja" value="{{$baja->id}}">
                        <div class="col s10 offset-s1 m6 offset-m3 l2 offset-l5">
                            <select name="reporte" id="reporte7" style="width: 100%;">
                              <option value="E">EXCEL</option>
                              <option value="P">PDF</option>
                            </select>
                        </div>
                        <div class="col s12">
                            <a onclick="reporte(8)" class="btn">GENERAR</a>
                        </div>
                    </form>
                </div>
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
                        <input type="hidden" name="id" value="{{$baja->id}}">
                        <input type="hidden" name="tipo" value="baja">
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