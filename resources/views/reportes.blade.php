@include('include.head') 
    @include('include.menu-usuario') 
    @include('include.modal-logout') 
     
    <!--Cuerpo--> 
      <div class="content-wrapper"> 
          <div class="container-fluid"> 
              <div class="card mb-3"> 
                  <div class="card-header text-size-ssm"><i class="icon-user-tie mr-2 text-size-ssm"></i>Usuarios</div> 
                  <div class="card-body"> 
 
 
            <div class="table-responsive-lg"> 
                      <table class="table text-size-xm"> 
                <thead class="thead-light"> 
                  <tr> 
                    <th scope="col">N°</th> 
                    <th scope="col">Nombre</th> 
                  </tr> 
                </thead> 
                <tbody class="lead text-size-xm"> 
                  <tr> 
                    <td>1</td> 
                    <td> 
                      <a href="reporte?modo=cuotapendiente">Reporte de pagos pendientes</a> 
                    </td> 
                  </tr> 
                  <tr> 
                    <td>2</td> 
                    <td> 
                      <a href="reporte?modo=pagorealizado">Reporte de pagos realizados</a> 
                    </td> 
                  </tr>  
                </tbody> 
              </table> 
              </div>         
                  </div> 
              </div> 
          </div> 
      </div> 
      <!--End Cuerpo--> 
 
    @include('include.footer')