    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
        <a href="contrato-nuevo" class="btn-floating btn-large waves-effect red"><i class="material-icons">add</i></a>
        <a onclick="$('#formlistarcontratos').submit()" class="btn-floating btn-large waves-effect left"><i class="material-icons">search</i></a>
      <div class="row titulo center">
        <h4>CONTRATOS</h4>
      </div>
      <div class="col s10 offset-s1">
            <form id="formlistarcontratos" action="contratos" method="GET">
                {{ csrf_field() }}
                <div class="col s12 l4 center input-field">
                    <select id="proveedor" name="id_proveedor">
                        <option value="0">TODOS</option>
                        @forelse($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}" @if($proveedor->id==$idproveedor) selected @endif>{{$proveedor->razon}}</option>
                        @empty
                            <option>NO HAY PROVEEDORES</option>
                        @endforelse
                    </select>
                    <label for="proveedor">Proveedor</label>
                </div>
                <div class="col s12 m6 l4 center input-field">
                    <div class="col s3">
                        <label>Desde</label>
                    </div>
                    <div class="col s9">
                        <input type="date" id="desde" name="desde" value="{{$desde}}">
                    </div>
                </div>
                <div class="col s12 m6 l4 center input-field">
                    <div class="col s3">
                        <label>Hasta</label>
                    </div>
                    <div class="col s9">
                        <input type="date" id="hasta" name="hasta" value="{{$hasta}}">
                    </div>
                </div>
            </form>
                
        </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp">
          <thead>
            <th>Número</th>
            <th>Proveedor</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estado</th>
            <th>Ver</th>
          </thead>
          <tbody>
            @forelse($contratos as $contrato)
                <tr>
                  <td>{{$contrato->numero}}</td>
                  <td>{{$contrato->proveedor()->razon}}</td>
                  @if($contrato->tipo=="C")
                    <td>CONTRATO</td>
                  @else
                    <td>ADQUISICIÓN</td>
                  @endif
                  <td>{{date('d/m/Y',strtotime($contrato->fecha))}}</td>
                  @if($contrato->tipo=="C")
                    <td>{{date('d/m/Y',strtotime($contrato->inicio))}}</td>
                    <td>{{date('d/m/Y',strtotime($contrato->fin))}}</td>
                    @if($contrato->estado=="N")
                      <td>REGISTRAR PRODUCTOS</td>
                      <td><a href="contrato-detalle?id={{$contrato->id}}" class="btn"><i class="material-icons">input</i></a></td>
                    @elseif($contrato->estado=="D")
                      <td>REGISTRAR SLA</td>
                      <td><a href="contrato-sla?id={{$contrato->id}}" class="btn"><i class="material-icons">input</i></a></td>
                    @elseif($contrato->estado=="S")
                      <td>REGISTRAR GUIAS</td>
                      <td><a href="contrato?id={{$contrato->id}}" class="btn"><i class="material-icons">input</i></a></td>
                    @elseif($contrato->estado=="C")
                      <td>SERIES COMPLETAS</td>
                      <td><a href="contrato?id={{$contrato->id}}" class="btn"><i class="material-icons">input</i></a></td>
                    @endif
                  @else
                    <td>-</td>
                    <td>-</td>
                    <td>FINALIZADO</td>
                    <td><a href="compra?id={{$contrato->id}}" class="btn"><i class="material-icons">input</i></a></td>
                  @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay contratos</td>
                </tr>
            @endforelse
          </tbody>
        </table>
        <div class="row center">
            {{$contratos->appends(['id_proveedor'=>$idproveedor,'desde'=>$desde,'hasta'=>$hasta])->links()}}
        </div>
      </div>
    </div>
    @include('include.footer')