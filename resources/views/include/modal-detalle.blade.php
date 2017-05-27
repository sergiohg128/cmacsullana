<!--MODAL MENSAJE-->
<div id="modal-detalle" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">AGREGAR PEDIDO</h4>
    </div>
  </div>
  <div class="row">
        <form id="formdetalle"  accept-charset="ISO-8859-1">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id-producto-detalle">
            <input type="hidden" name="modo" value="agregar">
            <div class="col s12 input-field">
                <textarea type="text" name="nombre" id="nombre-detalle" class="materialize-textarea" readonly=""></textarea>
                <label for="nombre-detalle" id="lblnombredetalle">Nombre</label>
            </div>
            <div class="col s12 input-field">
                <input type="number" step="1" name="cantidad" id="cantidad-detalle" required>
                <label for="cantidad-detalle" id="lblcantidaddetalle">Cantidad</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnproducto">
            <button onclick="modaldetallepost()" class="btn-large" id="btndetalleagregar">Agregar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>