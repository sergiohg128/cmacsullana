<!--MODAL ELIMINAR-->
<div id="modal-eliminar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">ELIMINAR</h4>
    </div>
  </div>
  <div class="row">
        <form id="formeliminar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="eliminar">
                <input type="hidden" name="id" id="id-eliminar">
                <input type="hidden" name="tabla" id="tabla-eliminar">
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneliminar">
            <button onclick="eliminarpost()" class="btn-large">ELIMINAR</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>