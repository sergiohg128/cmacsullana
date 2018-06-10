@include('include.head') 
    @include('include.menu-usuario') 
    @include('include.modal-logout') 
     
    <!--Cuerpo--> 
      <div class="content-wrapper"> 
          <div class="container-fluid"> 
              <div class="card mb-3"> 
                  <div class="card-header text-size-ssm"><i class="icon-user-tie mr-2 text-size-ssm"></i>Usuarios</div> 
                  <div class="card-body"> 
 
                      <!--Search--> 
                    <div> 
                      <form id="formFiltros" action="ajax/{{$url}}?modo={{$modo}}" class="form-inline mb-3" onsubmit="buscar();">
                        <input type="hidden" id="modo" value="{{$modo}}">
                        <p class="form-control mr-sm-2 text-size-xm">Desde</p> 
                        <input class="form-control mr-sm-2 text-size-xm" id="fecini" name="fecini" type="date" placeholder="Desde" aria-label="Desde"> 
                        <p class="form-control mr-sm-2 text-size-xm">Hasta</p> 
                        <input class="form-control mr-sm-2 text-size-xm" id="fecfin" name="fecfin" type="date" placeholder="Hasta" aria-label="Hasta"> 
                        <button type="button" class="btn btn-secondary btn-sm" onclick="buscar();">Buscar</button> 
                         <button type="button" class="btn btn-success btn-sm" onclick="exportarpdf();">Exportar PDF</button>
                </form> 
                    </div> 
            <!--End Search--> 
 
            <div class="table-responsive-lg"> 
                      <table class="table text-size-xm"> 
                <thead class="thead-light"> 
                  <tr> 
                    @if($modo=="cuotapendiente")
                    <th scope="col">N°</th> 
                    <th scope="col">Cliente</th>
                    <th scope="col">Detalle de Cuota</th> 
                    <th scope="col">Fecha Vencimiento</th> 
                    <th scope="col">Monto de Cuota</th> 
                    <th scope="col">Pagado</th> 
                    <th scope="col">Pendiente</th> 
                    @elseif($modo=="pagorealizado")
                    <th scope="col">N°</th> 
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha</th> 
                    <th scope="col">Monto</th>
                    <th scope="col">N° recibo</th>
                    @endif
                  </tr> 
                </thead> 
                <tbody class="lead text-size-xm" id="tbContenido"> 
                </tbody> 
              </table> 
              </div>         
                  </div> 
              </div> 
          </div> 
      </div> 
      <!--End Cuerpo--> 
 
    @include('include.footer') 
<script> 
     
    function buscar(){ 
        console.log("BUSCANDO"); 
        cargarTabla_JSON('formFiltros','tbContenido','divPagination'); 
        return false; 
    } 
     
    function exportarpdf(){ 
        var modo = $('#modo').val();
        var fecini = $('#fecini').val();
        var fecfin = $('#fecfin').val();

        window.open('exportar?modo='+modo+'&fecini='+fecini+'&fecfin='+fecfin);
    } 
     
    buscar(); 
     
</script>