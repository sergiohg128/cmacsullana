    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CASO DE SERVICIO {{$caso->numero}}</h4>
        @if($caso->estado=="N")
            <h5>ESTADO: PENDIENTE</h5>
        @elseif($caso->estado=="T")
            <h5>ESTADO: CON TÉCNICO ASIGNADO</h5>
        @elseif($caso->estado=="D")
            <h5>ESTADO: CON DIAGNOSTICO</h5>
        @elseif($caso->estado=="E")
            <h5>ESTADO: EN TRÁNSITO</h5>
        @elseif($caso->estado=="F")
            <h5>ESTADO: FINALIZADO</h5>
        @endif
      </div>
        <div class="row">
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>SERIE</h5>
                </div>
                <p class="center">{{$producto->serie}}</p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>FECHA</h5>
                </div>
                <p class="center">{{date('d/m/Y H:i',strtotime($caso->fecha))}}</p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <input type="hidden" id="nombreproducto" value="{{$producto->nombretipoequipo}} {{$producto->nombremarca}} {{$producto->nombremodelo}}">
                <div class="row titulo center">
                    <h5>PRODUCTO</h5>
                </div>
                <p class="center">{{$producto->nombretipoequipo}} {{$producto->nombremarca}} {{$producto->nombremodelo}}</p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>SUCURSAL</h5>
                </div>
                <p class="center">{{$producto->nombresucursal}}</p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>AREA</h5>
                </div>
                @if($producto->nombrearea==null)
                    <p class="center">SIN ÁREA ASIGNADA</p>
                @else
                    <p class="center">{{$producto->nombrearea}}</p>
                @endif
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>PROVEEDOR</h5>
                </div>
                <p class="center">{{$producto->nombreproveedor}}</p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>CONTRATO</h5>
                </div>
                @if($producto->tipocontrato=="C")
                    <p class="center">{{$producto->numero}}</p>
                @else
                    <p class="center">SIN CONTRATO</p>
                @endif
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>SLA</h5>                
                </div>
                @if($producto->tipocontrato=="C")
                    <p class="center">{{$caso->sla}} horas</p>
                @else
                    <p class="center">SIN SLA</p>
                @endif
            </div>
            <div class="col s10 offset-s1 card fullcol">
                <div class="row titulo center">
                    <h5>PROBLEMA</h5>                
                </div>
                <p class="center">{{$caso->problema}}</p>
            </div>
            <div class="col s10 offset-s1 card fullcol">
                <div class="row titulo center brown">
                    <h5>USUARIO</h5>                
                </div>
                <p class="center">{{$caso->usuario}}</p>
                @if($caso->celular!=null)
                    <p class="center">Celular: {{$caso->celular}}</p>
                @endif
                @if($caso->anexo!=null)
                    <p class="center">Anexo: {{$caso->anexo}}</p>
                @endif
                @if($caso->correo!=null)
                    <p class="center">Correo: {{$caso->correo}}</p>
                @endif
            </div>
            @if($caso->id_tecnico!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center teal">
                        <h5>TÉCNICO</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechat))}}</p>
                    <p class="center">{{$caso->tecnico()->apellidos}} {{$caso->tecnico()->nombre}}</p>
                </div>
            @endif
            @if($caso->analisis!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center green">
                        <h5>ANALISIS</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechad))}}</p>
                    <p class="center">{{$caso->analisis}}</p>
                </div>
            @endif
            @if($caso->conclusion!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center green">
                        <h5>CONCLUSIÓN</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechad))}}</p>
                    <p class="center">{{$caso->conclusion}}</p>
                </div>
            @endif
            @if($caso->id_tipo_caso!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center green">
                        <h5>TIPO CASO</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechad))}}</p>
                    <p class="center">{{$caso->tipocaso()->nombre}}</p>
                </div>
            @endif
            @if($caso->id_tipo_solucion!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center green">
                        <h5>TIPO SOLUCION</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechad))}}</p>
                    <p class="center">{{$caso->tiposolucion()->nombre}}</p>
                </div>
            @endif
            @if($caso->id_sucursal!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center green">
                        <h5>SOLICITADO REEMPLAZO A SUCURSAL</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechad))}}</p>
                    <p class="center">{{$caso->sucursal()->nombre}}</p>
                </div>
            @endif
            @if($caso->id_traslado!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center black">
                        <h5>TRASLADO</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechae))}}</p>
                    <p class="center">Número: {{$caso->traslado()->numero}}</p>
                    <p class="center">Sucursal: {{$caso->traslado()->sucursalenvia()->nombre}}</p>
                    <div class="col s12 center">
                        <a href="traslado?id={{$caso->id_traslado}}" target="_blank" class="btn">VER</a>
                    </div>
                        
                </div>
            @endif
            @if($reemplazo!=null)
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center orange">
                        <h5>PRODUCTO REEMPLAZO</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechae))}}</p>
                    <p class="center">{{$reemplazo->nombretipoequipo}} {{$reemplazo->nombremarca}} {{$reemplazo->nombremodelo}}</p>
                    <p class="center">Serie: {{$reemplazo->serie}}</p>
                </div>
            @endif
            @if($caso->estado=="F")
                <div class="col s10 offset-s1 card fullcol">
                    <div class="row titulo center red">
                        <h5>FINALIZACIÓN</h5>                
                    </div>
                    <p class="center">Fecha: {{date('d/m/Y H:i',strtotime($caso->fechaf))}}</p>
                    @if($caso->comentario!=null)
                        <p class="center">{{$caso->comentario}}</p>
                    @endif
                </div>
            @endif
        </div>
        @if($caso->estado=="N")
            <div class="row titulo center">
              <h4>ASIGNAR TÉCNICO</h4>
            </div>
            <div class="row">
                <div class="row">
                    <form id="asignartecnico" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$caso->id}}">
                        <div class="col s10 offset-s1 input-field">
                            <label>TÉCNICOS</label>
                            <select name="tecnico" id="tecnico" required>
                                <option value="0">ELIJA UN TÉCNICO</option>
                                @forelse($tecnicos as $tecnico)
                                    <option value="{{$tecnico->id}}">{{$tecnico->apellidos}} {{$tecnico->nombre}}</option>
                                @empty
                                    <option value="0">NO HAY TÉCNICOS</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col s12 center input-field" id="divbtnregistrar">
                            <a onclick="asignartecnico()" class="btn">ASIGNAR</a>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($caso->estado=="T")
            <div class="row titulo center">
              <h4>DETALLES</h4>
            </div>
            <div class="row">
                <div class="row">
                    <form id="detallecaso" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="contrato-id" value="{{$caso->id}}">
                        <input type="hidden" name="producto" id="id-producto">
                        <input type="hidden" id="sucursal-solicitar" name="sucursal" value="0">
                        <div class="col s10 offset-s1 input-field">
                            <input type="text" name="analisis" id="analisis">
                            <label for="analisis">ANÁLISIS</label> 
                        </div>
                        <div class="col s10 offset-s1 input-field">
                            <input type="text" name="conclusion" id="conclusion">
                            <label for="conclusion">CONCLUSIÓN</label> 
                        </div>
                        <div class="col s10 offset-s1 input-field">
                            <select name="tipocaso" id="tipocaso" required onchange="elegirtipocaso()">
                                <option value="0">ELIJA UN TIPO DE CASO</option>
                                @foreach($tiposcaso as $tipocaso)
                                    <option value="{{$tipocaso->id}}">{{$tipocaso->nombre}}</option>
                                @endforeach
                            </select>
                            <label for="tipocaso">TIPO DE CASO</label>
                        </div>
                        <div class="col s10 offset-s1 input-field" id="divsolucion">
                            <select name="tiposolucion" id="tiposolucion" required onchange="elegirtiposolucion()">
                                <option value="0">ELIJA UN TIPO DE SOLUCIÓN</option>
                                @foreach($tipossolucion as $tiposolucion)
                                    <option value="{{$tiposolucion->id}}">{{$tiposolucion->nombre}}</option>
                                @endforeach
                            </select>
                            <label for="tiposolucion">TIPO DE SOLUCIÓN</label>
                        </div>
                        <div class="col s10 offset-s1" id="divserie">
                            <div class="col s12 m6 l4">
                                <label>TIPO</label>
                                <select id="tiposucursal" style="width: 100%;" onchange="elegirtiposucursal()">
                                    <option value="0">ELIJA UN TIPO</option>
                                    @forelse($tipossucursal as $tiposucursal)
                                        <option value="{{$tiposucursal->id}}">{{$tiposucursal->nombre}}</option>
                                    @empty
                                        <option value="0">NO HAY TIPOS</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col s12 m6 l4" id="divsucursales">
                                <label>SUCURSAL</label>
                                <select id="sucursales" style="width: 100%;">
                                    <option value="0">ELIJA UN TIPO PRIMERO</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l3 input-field">
                                <select  id="tipomodelo" required>
                                    <option value="1">MISMO MODELO</option>
                                    <option value="2">MISMO TIPO DE EQUIPO</option>
                                </select>
                                <label for="tipomodelo">ELECCIÓN</label>
                            </div>
                            <div class="col s12 m4 l1 input-field" id="btnbuscar">
                                <a class="btn green" onclick="buscarseriescambio()"><i class="material-icons">search</i></a>
                            </div>
                            <div class="col s10 offset-s1 input-field" id="divsucursalsolicitar">
                                <input type="text" id="txtsucursalsolicitar" readonly>
                                <label for="txtsucursalsolicitar" id="lblsucursalsolicitar">SUCURSAL A SOLICITAR</label> 
                            </div>
                        </div>
                        <div class="col s10 offset-s1 card" id="info-producto" style="padding-top: 10px;">
                        </div>
                        <div class="col s12 center input-field" id="divbtnregistrar">
                            <a onclick="detallecaso()" class="btn">GUARDAR</a>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($caso->estado=="D")
            <div class="row titulo center">
                <h4>ELEGIR REEMPLAZO</h4>
            </div>
            <div class="row">
                <div class="col s10 offset-s1 l8 offset-l2 input-field">
                    <select  id="tipoeleccion" required onchange="tipoeleccionreemplazo()">
                        <option value="0">ELEGIR DE DÓNDE SE OBTENDRÁ EL REEMPLAZO</option>
                        <option value="1">DE OTRA SUCURSAL</option>
                        <option value="2">DE LA MISMA SUCURSAL</option>
                    </select>
                    <label for="tipomodelo">ELECCIÓN</label>
                </div>
                <div class="row" id="otrasucursal">
                    <div class="col s12 center">
                        <a href="caso-traslado?id={{$caso->id}}" class="btn">TRASLADAR</a>
                    </div>
                </div>
                <div class="row" id="mismasucursal">
                    <div class="col s10 offset-s1">
                        <input type="hidden" name="id" id="caso" value="{{$caso->id}}">
                        <input type="hidden" id="actual" value="{{$producto->id}}">
                        <input type="hidden" id="tiposequipo" value="{{$producto->id_tipo_equipo}}">
                        <input type="hidden" id="origen" value="{{$producto->id_sucursal}}">
                        <div class="col s12 m6 l4">
                            <label>MARCAS</label>
                            <select id="marcas" style="width: 100%;" onchange="listarmodelos()">
                              <option value="0">TODAS</option>
                              @forelse($marcas as $marca)
                                  <option value="{{$marca->id}}" @if($producto->id_marca==$marca->id) selected @endif>{{$marca->nombre}}</option>
                              @empty
                                  <option value="0">NO HAY MARCAS</option>
                              @endforelse
                            </select>
                        </div>
                        <div class="col s12 m6 l3" id="divmodelos">
                            <label>PRODUCTOS</label>
                            <select  id="modelos" style="width: 100%;">
                              <option value="0">TODOS</option>
                              @forelse($modelos as $modelo)
                                  <option value="{{$modelo->id}}" @if($producto->id_modelo==$modelo->id) selected @endif>{{$modelo->nombre}}</option>
                              @empty
                                  <option value="0">NO HAY MODELOS</option>
                              @endforelse
                            </select>
                        </div>
                        <div class="col s12 m6 l1 input-field" id="divbtnbuscar" style="margin-top: 20px;">
                            <a onclick="buscarseriestraslado()" class="btn green"><i class="material-icons">search</i></a>
                        </div>
                        <div class="col s12 m6 l4" id="divseries">
                            <label>SERIES</label>
                            <select  id="series" style="width: 100%;" onchange="elegirserietrasladocaso()">
                                <option value="0">ELIJA UNA SERIE</option>
                                  @forelse($productos as $producto)
                                      <option value="{{$producto->id}}">{{$producto->serie}}</option>
                                  @empty
                                      <option value="0">NO HAY SERIES</option>
                                  @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col s12 center input-field" id="divbtnregistrar">
                        <a onclick="elegirseriereemplazo()" class="btn-large">GUARDAR<i class="material-icons right">save</i></a>
                    </div>
                </div>
            </div>
        @elseif($caso->estado=="E")
            <div class="row titulo center">
              <h4>FINALIZAR CASO</h4>
            </div>
            <div class="row">
                <div class="col s10 offset-s1">
                    <form id="fincaso" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$caso->id}}">
                        <div class="col s12 input-field">
                            <textarea class="materialize-textarea" name="comentario" id="comentariofinal"></textarea>
                            <label for="comentariofinal">Comentario(Opcional)</label>
                        </div>
                        <div class="col s12 center input-field" id="divbtnregistrar">
                            <a onclick="fincaso()" class="btn">FINALIZAR CASO</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
    @include('include.footer')
    <script>
        $('#tecnico').select2();
        $('#divsolucion').hide();
        $('#info-producto').hide();
        $('#divserie').hide();
        $('#tiposucursal').select2();
        $('#sucursales').select2();
        $('#divsucursalsolicitar').hide();
        $('#mismasucursal').hide();
        $('#otrasucursal').hide();
        $('#marcas').select2();
        $('#modelos').select2();
        $('#series').select2();
    </script>
    
    
                <!--MODAL SERIES-->
<div id="modal-series" class="modal" style="width: 80% !important;">
  <div class="row">
    <div class="titulo blue darken-1">
        <h5 class="center">SERIES ENCONTRADAS</h5>
    </div>
      <input type="hidden" id="sucursal-temporal">
  </div>
  <div class="row">
      <table class="striped centered">
          <thead>
              <tr>
                  <th>PRODUCTO</th>
                  <th>SERIE</th>
                  <th>ÁREA</th>
              </tr>
          </thead>
          <tbody id="modal-filas">
          </tbody>
      </table>
  </div>
    <div class="row center botones" style="margin-top: 15px;">
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large waves-effect" onclick="solicitarseriecaso()">SOLICITAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>