    
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/bin/materialize.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/stacktable.js"></script>
    <script src="js/select2.full.js"></script>
    <script src="js/scripts.js"></script>
    @if($mensaje!=null)
        <script>
            alerta("{{$mensaje}}",5000);
        </script>
    @endif
        <!--MODAL NUEVA GUIA-->
        <div id="modal-nuevaguia" class="modal">
            <div class="row">
              <div class="titulo blue darken-1">
                  <h4 class="center">ELEGIR CONTRATO</h4>
              </div>
            </div>
            <div class="row">
                <div class="col s12 center" id="divproveedornuevaguia">
                    <label for="proveedornuevaguia">PROVEEDORES</label>
                    <select id="proveedornuevaguia" name="proveedor" style="width: 100%;" onchange="elegirproveedornuevaguia(this)">

                    </select>
                </div>
                <div class="col s12 center" id="divcontratonuevaguia">
                    <label for="contratonuevaguia">CONTRATOS</label>
                    <select id="contratonuevaguia" name="contrato" style="width: 100%;" onchange="elegirproveedornuevaguia(this)">

                    </select>
                </div>
            </div>
            <div class="row center botones" style="margin-top: 25px;">
                <div class="col s6 center">
                    <button onclick="nuevaguia()" class="btn-large">IR</button>
                </div>
                <div class="col s6 center">
                    <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
                </div>
            </div>
        </div>
        
        
    
            <!--MODAL ELEGIR SUCURSAL-->
        <div id="modal-traslados" class="modal">
          <div class="row">
            <div class="titulo blue darken-1">
                <h4 class="center">ELEGIR SUCURSAL</h4>
            </div>
          </div>
          <div class="row">
                <div class="col s12 center" id="divmodalsucursaltraslado">
                    <label for="sucursalmodaltraslados">SUCURSAL</label>
                    <select id="sucursalmodaltraslados" name="sucursal" style="width: 100%;">

                    </select>
                </div>
          </div>
            <div class="row center botones" style="margin-top: 25px;">
                <div class="col s6 center">
                    <button onclick="abrirtrasladosucursal()" class="btn-large">IR</button>
                </div>
                <div class="col s6 center">
                    <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
                </div>
            </div>
        </div>
            
              <!--MODAL ELEGIR SUCURSAL-->
        <div id="modal-bajas" class="modal">
          <div class="row">
            <div class="titulo blue darken-1">
                <h4 class="center">ELEGIR SUCURSAL</h4>
            </div>
          </div>
          <div class="row">
                <div class="col s12 center" id="divmodalsucursalbaja">
                    <label for="sucursalmodalbajas">SUCURSAL</label>
                    <select id="sucursalmodalbajas" name="sucursal" style="width: 100%;">

                    </select>
                </div>
          </div>
            <div class="row center botones" style="margin-top: 25px;">
                <div class="col s6 center">
                    <button onclick="abrirbajasucursal()" class="btn-large">IR</button>
                </div>
                <div class="col s6 center">
                    <button class="modal-action modal-close btn-large red waves-effect">CERRAR</button>
                </div>
            </div>
        </div>
        <script>
            $('#proveedornuevaguia').select2();
            $('#contratonuevaguia').select2();
            $('#sucursalmodaltraslados').select2();
        </script>
    </body>
</html>