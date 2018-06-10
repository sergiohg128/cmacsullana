<!-- Modal -->
    <div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="login">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title w-100">Inicio de Sesión - #CYSEG</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="text-center">
                <div class="icon-object border-primary-300 text-primary-300"><i class="icon-reading"></i></div>
                <h6 class="lead text-size-sm">Ingresa tus credenciales</h6>
              </div>

      
                  <div class="form-group">
                    <label>Usuario</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-user-tie"></i></div>
                      </div>
                      <input type="email" name="correo" class="form-control" id="txtUsuario" placeholder="Usuario">
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="icon-lock"></i></div>
                      </div>
                      <input type="password" name="password" class="form-control" id="txtPassword" placeholder="Password">
                    </div>
                  </div>

                  <!-- <div class="text-right">
                    <small><a href="#">¿Olvidaste tu constraseña?</a></small>
                  </div> -->
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button class="btn btn-primary" type="submit">Ingresar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- End Modal -->