    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CONTRATO NUEVO</h4>
      </div>
        <div class="row">
            <div class="col s6 offset-s3 center">
                <form id="formcontrato" method="POST">
                    {{ csrf_field() }}
                    <div class="col s12 input-field">
                        <input type="text" name="numero" id="numero">
                        <label for="numero">NÚMERO</label>
                    </div>
                    <div class="col s12 input-field">
                        <textarea name="descripcion" id="descripcion" class="materialize-textarea"></textarea>
                        <label for="descripcion">DESCRIPCIÓN</label>
                    </div>
                    <div class="col s12 input-field">
                        <select id="proveedores" name="proveedor">
                            <option value="0">ELIJA UN PROVEEDOR</option>
                            @forelse($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}">{{$proveedor->razon}}</option>
                            @empty
                                <option value="-1">No hay proveedores</option>
                            @endforelse
                          </select>
                        <label for="proveedor">PROVEEDOR</label>
                    </div>
                    <div class="col s12 input-field">
                        <div class="col s3">
                            <label>FECHA DE CONTRATO</label>
                        </div>
                        <div class="col s9">
                            <input type="date" id="fecha" name="fecha">
                        </div>
                    </div>
                    <div class="col s12 input-field">
                        <div class="col s3">
                            <label>INICIO CONTRATO</label>
                        </div>
                        <div class="col s9">
                            <input type="date" id="inicio" name="inicio">
                        </div>
                    </div>
                    <div class="col s12 input-field">
                        <div class="col s3">
                            <label>FIN CONTRATO</label>
                        </div>
                        <div class="col s9">
                            <input type="date" id="fin" name="fin">
                        </div>
                    </div>
                    <div class="col s12 center input-field" id="divbtnregistrar">
                        <a onclick="registrarcontrato()" class="btn-large">GUARDAR<i class="material-icons right">save</i></a>
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