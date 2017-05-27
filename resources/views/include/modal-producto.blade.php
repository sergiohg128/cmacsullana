<!--MODAL MENSAJE-->
<div id="modal-producto" class="modal">
  <div class="row">
    <div class="titulo blue darken-1">
        <h4 class="center">PRODUCTO</h4>
    </div>
  </div>
  <div class="row">
        <form id="formproducto"  accept-charset="ISO-8859-1">
            {{ csrf_field() }}
            <input type="hidden" name="modo" id="modo-producto">
            <input type="hidden" name="tabla" value="producto">
            <input type="hidden" name="id" id="id-producto">
            <div class="col s12 input-field">
                <input type="text" name="nombre" required id="nombre-producto" required>
                <label for="nombre-producto" id="lblnombre">Nombre</label>
            </div>
            <div class="col s12 input-field">
                <input type="number" step="0.01" name="compra" id="compra-producto">
                <label for="compra-producto" id="lblcompra">Precio compra</label>
            </div>
            <div class="col s12 input-field">
                <input type="number" step="0.01" name="venta" id="venta-producto">
                <label for="venta-producto" id="lblventa">Precio venta unitario</label>
            </div>
            <div class="col s12 input-field">
                <input type="number" step="0.01" name="cantidad" id="cantidad-producto">
                <label for="cantidad-producto" id="lblcantidad">Cantidad de unidades</label>
            </div>
            <div class="col s12 input-field" id="divmarca">
                <select id="marca-producto" name="id_marca">
                    @forelse($marcas as $marca)
                    <option value="{{$marca->id}}" id="optmarca{{$marca->id}}">{{$marca->nombre}}</option>
                    @empty
                        <option>No hay marcas</option>
                    @endforelse
                </select>
                <label for="marca-producto">Marca</label>
            </div>
            <div class="col s12 input-field" id="divunidad">
                <select id="unidad-producto" name="id_unidad">
                    @forelse($unidades as $unidad)
                        <option value="{{$unidad->id}}" id="optunidad{{$unidad->id}}">{{$unidad->nombre}}</option>
                    @empty
                        <option>No hay unidades</option>
                    @endforelse
                </select>
                <label for="unidad-producto">Unidad</label>
            </div>
            <div class="col s12 input-field" id="divcategoria">
                <select id="categoria-producto" name="id_categoria">
                    @forelse($categorias as $categoria)
                        <option value="{{$categoria->id}}" id="optcategoria{{$categoria->id}}">{{$categoria->nombre}}</option>
                    @empty
                        <option>No hay categorias</option>
                    @endforelse
                </select>
                <label for="categoria-producto">Categoria</label>
            </div>
        </form>
  </div>
    <div class="row center botones">
        <div class="col s6 center" id="divbtnproducto">
            <button onclick="modalproductopost()" class="btn-large">Guardar</button>
        </div>
        <div class="col s6 center">
            <button class="modal-action modal-close btn-large red waves-effect">Cerrar</button>
        </div>
    </div>
</div>