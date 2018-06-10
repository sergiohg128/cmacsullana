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
                    <th scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody class="lead text-size-xm">
                  <tr>
                    
                    <td>
                      <a href="cuentas">Cuentas Bancarias</a>
                    </td>
                  </tr>
                  <tr>
                    
                    <td>
                      <a href="universidades">Universidades</a>
                    </td>
                  </tr>
                  <tr>
                    
                    <td>
                      <a href="carreras">Carreras</a>
                    </td>
                  </tr>
                  <tr>
                    
                    <td>
                      <a href="tipos">Tipos de Usuario</a>
                    </td>
                  </tr>
                  <tr>
                    
                    <td>
                      <a href="sedes">Sedes</a>
                    </td>
                  </tr>
                  <tr>
                    
                    <td>
                      <a href="staff">Staff</a>
                    </td>
                  </tr>
                  <tr>
                    
                    <td>
                      <a href="contenido">Contenido</a>
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