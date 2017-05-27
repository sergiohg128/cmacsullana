<!--MODAL MENSAJE-->
<div id="modal-detalle-editar" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">DETALLE</h4>
    </div>
  </div>
  <div class="row">
        <form id="formdetalleeditar"  accept-charset="ISO-8859-1">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id-producto">
            <input type="hidden" name="tipo" id="tipoeditar">
            <input type="hidden" name="iddetalle" id="iddetalle">
            <div class="row titulo grey">
                <p class="center">DATOS PRODUCTO</p>
            </div>
            <div class="row">
                <div class="col s12 input-field">
                    <input type="text" name="nombre" required id="nombre-producto" required readonly="">
                    <label for="nombre-producto" id="lblnombre">Nombre</label>
                </div>
                <p style="padding-left: 20px;">
                    <input type="checkbox" onchange="editarproductodetalle()" id="chk-editar" name="editar">
                    <label for="chk-editar">Editar Datos Producto</label>
                </p>
                <div class="col s12" id="editarcargando">
                    <div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
                </div>
                <div class="col s12" id="editar-producto">
                    <div class="col s12 input-field">
                        <input type="number" step="0.01" name="compra" id="compra-producto" >
                        <label for="compra-producto" id="lblcompra">Precio compra</label>
                    </div>
                    <div class="col s12 input-field">
                        <input type="number" step="0.01" name="venta" id="venta-producto" >
                        <label for="venta-producto" id="lblventa">Precio venta unitario</label>
                    </div>
                    <div class="col s12 input-field">
                        <input type="number" step="0.01" name="cantidad" id="cantidad-producto" >
                        <label for="cantidad-producto" id="lblcantidad">Cantidad de unidades</label>
                    </div>
                </div>
            </div>
            <div class="row titulo grey">
                <p class="center">DATOS  PEDIDO</p>
            </div>
            <div class="col s12 input-field">
                <input type="number" step="1" name="cantidad-detalle" id="cantidad-detalle">
                <label for="cantidad-detalle" id="lblcantidaddetalle">Cantidad de pedido</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnproducto">
            <button onclick="editardetallepost()" class="btn-large" id="btneditardetalle">Editar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>