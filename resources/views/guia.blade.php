    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>GUIA {{$guia->numero}}</h4>
      </div>
      <div class="row">
            <div class="col s10 offset-s1">
                  <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>CONTRATO</h5>
                      </div>
                      <p class="center">{{$guia->contrato()->numero}}</p>
                  </div>
                  <div class="col s12 m4 offset-m2 card fullcol">
                      <div class="row titulo center">
                          <h5>PROVEEDOR</h5>
                      </div>
                      <p class="center">{{$guia->contrato()->proveedor()->razon}}</p>
                  </div>
                  <div class="col s12 m4 offset-m1 card fullcol">
                      <div class="row titulo center">
                          <h5>FECHA</h5>
                      </div>
                      <p class="center">{{date('d/m/Y',strtotime($guia->fecha))}}</p>
                  </div>
                  <div class="col s12 m4 offset-m2 card fullcol">
                      <div class="row titulo center">
                          <h5>SUCURSAL</h5>                
                      </div>
                      <p class="center">{{$guia->sucursal()->nombre}}</p>
                  </div>
                @if($guia->comentario!=null)
                    <div class="col s10 offset-s1 card fullcol">
                      <div class="row titulo center">
                          <h5>COMENTARIO</h5>                
                      </div>
                      <p class="center">{{$guia->comentario}}</p>
                  </div>
                @endif
              </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1">
                <div class="row center titulo">
                    <h5>PRODUCTOS</h5>
                </div>
                <div class="row">
                  <table class="centered striped resp2">
                    <thead>
                      <th>Tipo</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Cantidad</th>
                      <th>Series</th>
                    </thead>
                    <tbody id="filas">
                          @foreach($detalles as $detalle)
                              <tr>
                                <td>{{$detalle->nombretipoequipo}}</td>
                                <td>{{$detalle->nombremarca}}</td>
                                <td>{{$detalle->nombremodelo}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td><a href="guia-series?g={{$guia->id}}&d={{$detalle->id_detalle_contrato}}" class="btn"><i class="material-icons">input</i></a></td>
                              </tr>
                          @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1">
                <div class="titulo row center">
                    <h5>FORMATO GENERADO</h5>
                </div>
                <div class="row center">
                    <form id="reporte6" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="6">
                        <input type="hidden" name="guia" value="{{$guia->id}}">
                        <div class="col s10 offset-s1 m6 offset-m3 l2 offset-l5">
                            <select name="reporte" id="reporte6" style="width: 100%;">
                              <option value="E">EXCEL</option>
                              <option value="P">PDF</option>
                            </select>
                        </div>
                        <div class="col s12">
                            <a onclick="reporte(6)" class="btn">GENERAR</a>
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
                        <input type="hidden" name="id" value="{{$guia->id}}">
                        <input type="hidden" name="tipo" value="guia">
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