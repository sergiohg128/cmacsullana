    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CONTRATO {{$contrato->numero}}</h4>
        <h4>PROVEEDOR: {{$contrato->proveedor()->razon}}</h4>
      </div>
        <div class="row">
            <form action="contrato-sla" method="POST">
                <div class="col s12 m10 offset-m1 l8 offset-l2">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$contrato->id}}">
                    @foreach($tiposequipo as $tipoequipo)
                        <div class="row titulo center">
                            <h5>{{$tipoequipo->nombre}}</h5>
                        </div>
                        @foreach($slas as $sla)
                            @if($sla->id_tipo_equipo==$tipoequipo->id)
                                <div class="row">
                                    <div class="col s8 l10 input-field">
                                        <input type="text" value="{{$sla->nombrett}}" readonly="">
                                    </div>
                                    <div class="col s4 l2 input-field">
                                        <input type="hidden" value="{{$sla->id}}" name="ids[]">
                                        <input type="number" id="sla{{$sla->id}}" name="horas[]" value="{{$sla->horas}}"  min="0" step="1" required placeholder="SLA(horas)">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <div class="col s12 center input-field" id="divbtnregistrar">
                    <button class="btn-large">GUARDAR<i class="material-icons right">save</i></button>
                </div>
            </form>
        </div>
    </div>
    @include('include.footer')