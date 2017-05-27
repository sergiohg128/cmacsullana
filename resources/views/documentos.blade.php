    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>DOCUMENTOS</h4>
      </div>
      <div class="col s10 offset-s1 tabla">
        <table class="centered striped resp2">
          <thead>
            <th>N</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Siguiente</th>
            <th>Editar</th>
          </thead>
          <tbody id="filas">
            @forelse($documentos as $documento)
                <tr id="fila{{$documento->id}}">
                  <td>{{$w = $w + 1}}</td>
                  <td id="filanombre{{$documento->id}}">{{$documento->nombre}}</td>
                  <td id="filacodigo{{$documento->id}}">{{$documento->codigo}}</td>
                  <td id="filanumero{{$documento->id}}">{{$documento->numero+1}}</td>
                  <td id="filaeditar{{$documento->id}}"><a onclick="modaleditardocumento({{$documento->id}},'{{$documento->nombre}}','{{$documento->codigo}}',{{$documento->numero+1}})" class="btn green"><i class="material-icons">edit</i></a></td>
                </tr>
            @empty
                <tr id="filaempty">
                    <td colspan="5">No hay documentos</td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @include('include.footer')
    
      
    <!--MODAL EDITAR-->
<div id="modal-editar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">EDITAR</h4>
    </div>
  </div>
  <div class="row">
        <form id="formeditar" action="documento" method="POST"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="editar">
                <input type="hidden" name="id" id="id-editar">
                <input type="text" name="nombre" id="nombre-editar" readonly>
                <label for="nombre-editar" id="lblaeditar">Nombre</label>
            </div>
            <div class="col s12 input-field">
                <input type="text" name="codigo" required id="codigo-editar">
                <label for="codigo-editar" id="lblbeditar">Codigo</label>
            </div>
            <div class="col s12 input-field">
                <input type="number" name="numero" required id="numero-editar">
                <label for="numero-editar" id="lblceditar">Siguiente</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="editardocumento()" class="btn-large">GRABAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
        </div>
    </div>
</div>