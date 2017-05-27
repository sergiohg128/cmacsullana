    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CASO NUEVO</h4>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 m6 offset-m3 l4 offset-l4">
                <label for="sucursal">SUCURSAL</label>
                <select id="sucursales" name="sucursal" style="width: 100%;" onchange="seriessucursal()">
                    <option value="-1">Elija una sucursal</option>
                    <option value="0">Todas</option>
                    @forelse($sucursales as $sucursal)
                        <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                    @empty
                        <option value="0">No hay sucursales</option>
                    @endforelse
                </select>
            </div>
            <div class="col s10 offset-s1 m6 offset-m3 l4 offset-l4" id="divseries">
                <label>SERIES</label>
                <select id="serie-caso" name="serie" style="width: 100%;" onchange="seleccionarseriecaso()">
                    <option value="0">Elija una sucursal</option>
                </select>
            </div>
        </div>
        <div class="row"  id="detalle-serie-caso">
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>PRODUCTO</h5>
                </div>
                <p class="center" id="marca"></p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>SUCURSAL</h5>
                </div>
                <p class="center" id="sucursal"></p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>ÁREA</h5>
                </div>
                <p class="center" id="area"></p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>PROVEEDOR</h5>
                </div>
                <p class="center" id="proveedor"></p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m1 card fullcol">
                <div class="row titulo center">
                    <h5>CONTRATO</h5>
                </div>
                <p class="center" id="contrato"></p>
            </div>
            <div class="col s10 offset-s1 m4 offset-m2 card fullcol">
                <div class="row titulo center">
                    <h5>SLA</h5>                
                </div>
                <p class="center" id="sla"></p>
            </div>
            <div class="col s10 offset-s1 m8 offset-m2 l6 offset-l3 center" id="info-caso">
                <form method="POST" id="formcaso">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id-serie">
                    <input type="hidden" name="sla" id="sla-serie">
                    <div class="col s12 input-field">
                        <input type="text" name="usuario" id="usuario">
                        <label for="usuario">USUARIO</label>
                    </div>
                    <div class="col s12 input-field">
                        <input type="text" name="celular" id="celular">
                        <label for="celular">CELULAR</label>
                    </div>
                    <div class="col s12 input-field">
                        <input type="text" name="anexo" id="anexo">
                        <label for="anexo">ANEXO</label>
                    </div>
                    <div class="col s12 input-field">
                        <input type="text" name="correo" id="correo">
                        <label for="correo">CORREO</label>
                    </div>
                    <div class="col s12 input-field">
                        <textarea name="problema" id="problema" class="materialize-textarea"></textarea>
                        <label for="problema">PROBLEMA</label>
                    </div>
                    <div class="col s12" id="btngenerarcaso">
                        <a class="btn" onclick="generarcaso()">GENERAR CASO</a>
                    </div>
                </form>
            </div>
        </div>
            
    </div>
    @include('include.footer')
    
    <script>
        $('#detalle-serie-caso').hide();
        $('#info-caso').hide();
        $('#sucursales').select2();
        $('#serie-caso').select2();
    </script>
    
    
    
