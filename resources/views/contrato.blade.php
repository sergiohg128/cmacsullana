    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <div class="row titulo center" style="margin-bottom: 5px;">
        <h5>CONTRATO {{$contrato->numero}}</h5>
        <h5>PROVEEDOR: {{$proveedor->razon}}</h5>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
              <div class="row titulo center">
                <h5>SLA</h5>
              </div>
              <table class="centered striped resp2">
                <thead>
                  <th>Tipo Equipo</th>
                  <th>Tipo Territorio</th>
                  <th>SLA</th>
                </thead>
                <tbody id="filas">
                    @php($tipoequipo = 0)
                      @foreach($slas as $sla)
                          <tr>
                            @if($tipoequipo!=$sla->id_tipo_equipo)
                              @php($tipoequipo = $sla->id_tipo_equipo)
                              <td rowspan="{{$tiposterritorio->total}}">{{$sla->nombrete}}</td>
                            @endif
                            <td>{{$sla->nombrett}}</td>
                            <td>{{$sla->horas}} horas</td>
                          </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
            <div class="row center">
                <a class="btn" href="contrato-sla?id={{$contrato->id}}">EDITAR SLA</a>
            </div>
        </div>
            
        <div class="row">
            <div class="col s10 offset-s1 tabla">
              <div class="row titulo center">
                <h5>PRODUCTOS</h5>
              </div>
              <table class="centered striped resp2">
                <thead>
                  <th>Tipo</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Solicitados</th>
                  <th>Registrados</th>
                </thead>
                <tbody id="filas">
                      @foreach($detalles as $detalle)
                          <tr id="fila{{$detalle->id}}">
                            <td>{{$detalle->nombretipoequipo}}</td>
                            <td>{{$detalle->nombremarca}}</td>
                            <td>{{$detalle->nombremodelo}}</td>
                            <td>{{$detalle->cantidad}}</td>
                            <td>{{$detalle->productosguia}}</td>
                          </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
              <div class="row titulo center">
                  <h5>GUIAS</h5>
              </div>
              <div class="row center">
                    <a href="guia-nueva?id={{$contrato->id}}"><button class="btn green">NUEVA GUIA</button></a>
                </div>
              <table class="centered striped resp2">
                <thead>
                  <th>Número</th>
                  <th>Fecha</th>
                  <th>Sucursal Llegada</th>
                  <th>Ver</th>
                </thead>
                <tbody id="filas">
                      @foreach($guias as $guia)
                          <tr id="fila{{$guia->id}}">
                            <td>{{$guia->numero}}</td>
                            <td>{{$guia->fecha}}</td>
                            <td>{{$guia->sucursal()->nombre}}</td>
                            <td><a href="guia?id={{$guia->id}}"><button class="btn"><i class="material-icons">input</i></button></a></td>
                          </tr>
                      @endforeach
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
                    <form id="reporte5" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="5">
                        <input type="hidden" name="contrato" value="{{$contrato->id}}">
                        <div class="col s10 offset-s1 m6 offset-m3 l2 offset-l5">
                            <select name="reporte" id="reporte5" style="width: 100%;">
                              <option value="E">EXCEL</option>
                              <option value="P">PDF</option>
                            </select>
                        </div>
                        <div class="col s12">
                            <a onclick="reporte(5)" class="btn">GENERAR</a>
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
                        <input type="hidden" name="id" value="{{$contrato->id}}">
                        <input type="hidden" name="tipo" value="contrato">
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