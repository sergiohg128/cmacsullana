    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CAMBIAR CONTRASEÑA</h4>
      </div>
      <div class="row">
          <div class="col s10 offset-s1 m6 offset-m3 l4 offset-l4">
              <form action="usuario" method="POST" accept-charset="ISO-8859-1">
                    {{ csrf_field() }}
                  <input type="hidden" name="modo" value="pass">
                  <div class="input-field col s12">
                    <input id="pass" type="password" name="pass">
                    <label for="pass">Contraseña Actual</label>
                  </div>
                  <div class="input-field col s12">
                    <input id="pass2" type="password" name="pass2">
                    <label for="pass2">Nueva Contraseña</label>
                  </div>
                  <div class="input-field col s12">
                    <input id="pass3" type="password" name="pass3">
                    <label for="pass3">Repetir Nueva Contraseña</label>
                  </div>
                  <div class="col s12 center">
                      <button type="submit" class="btn">GUARDAR</button>
                  </div>
                </form>
          </div>
      </div>
    </div>
    @include('include.footer')