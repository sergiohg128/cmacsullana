<!--MODAL MENSAJE-->
<div id="modal-descartar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h5 class="center">QUITAR PRODUCTO DEL PEDIDO</h5>
    </div>
  </div>
  <div class="row">
        <form id="formeliminar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id-eliminar">
                <input type="hidden" name="tipo" id="tipo">
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneliminar">
            <button onclick="eliminardetalle()" class="btn-large">Quitar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>