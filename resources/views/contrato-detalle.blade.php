    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CONTRATO {{$contrato->numero}}</h4>
        <h4>PROVEEDOR: {{$contrato->proveedor()->razon}}</h4>
      </div>
      <div class="col s10 offset-s1">
          <div class="row">
              <div class="col s12 m12 l9 input-field">
                  <select id="productos" style="width: 100%;">
                    @forelse($modelos as $modelo)
                        <option value="{{$modelo->id}}" id="producto{{$modelo->id}}">{{$modelo->nombretipo}} {{$modelo->nombremarca}} {{$modelo->nombre}}</option>
                    @empty
                        <option value="0">NO HAY MODELOS</option>
                    @endforelse
                  </select>
              </div>
              <div class="col s12 m6 l2 input-field">
                  <input type="number" min="0" id="cantidad">
                  <label for="cantidad">Cantidad</label>
              </div>
              <div class="col s12 m6 l1 input-field" id="divbtnagregar">
                  <a onclick="agregardetallecontrato()" class="btn"><i class="material-icons">add</i></a>
              </div>
          </div>
      </div>
      <div class="col s12 tabla">
          <div class="row">
            <table class="centered striped">
              <thead>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Quitar</th>
              </thead>
              <tbody id="filas">
                  <tr id="filaempty">
                      <td colspan="4">No ha añadido productos al contrato nuevo</td>
                  </tr>
              </tbody>
            </table>  
          </div>
      </div>
        <div class="row">
            <div class="col s6 offset-s3 center" style="margin-top:30px !important;">
                <form id="formcontrato" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$contrato->id}}">
                    <div id="otrosinput"></div>
                    <div class="col s12 center input-field" id="divbtnregistrar">
                        <a onclick="registrarcontratodetalle()" class="btn-large">GUARDAR<i class="material-icons right">save</i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('include.footer')
    <script>
        var detalles = [];
        $('#productos').select2();
    </script>