<!--MODAL MENSAJE-->
<div id="modal-pedido" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">GUARDAR PEDIDO</h4>
        <p class="center" id="totalmodal"></p>
    </div>
  </div>
  <div class="row">
        <form id="formpedido"  accept-charset="ISO-8859-1">
            {{ csrf_field() }}
            <div class="col s12 input-field" id="divproveedor">
                <select id="proveedor" name="id_proveedor">
                    @forelse($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                    @empty
                        <option>No hay proveedores</option>
                    @endforelse
                </select>
                <label for="proveedor">Proveedor</label>
            </div>
            <div class="col s12 input-field">
                <textarea class="materialize-textarea" id="publico" name="publico"></textarea>
                <label for="publico">Comentario público</label>
            </div>
            <div class="col s12 input-field">
                <textarea class="materialize-textarea" id="privado" name="privado"></textarea>
                <label for="privado">Comentario privado</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center">
            <button onclick="modalpedidopost()" class="btn-large" id="btnguardar">Guardar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>