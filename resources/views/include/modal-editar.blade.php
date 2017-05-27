<!--MODAL EDITAR-->
<div id="modal-editar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">EDITAR</h4>
    </div>
  </div>
  <div class="row">
        <form id="formeditar"  accept-charset="ISO-8859-1">
            <div class="col s12 input-field">
                {{ csrf_field() }}
                <input type="hidden" name="modo" value="editar">
                <input type="hidden" name="id" id="id-editar">
                <input type="hidden" name="tabla" id="tabla-editar">
                <input type="text" name="nombre" required id="nombre-editar">
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtneditar">
            <button onclick="editarpost()" class="btn-large">Guardar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>