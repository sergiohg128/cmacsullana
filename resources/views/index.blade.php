    @include('include.head')
    <!--Cuerpo-->
    <div class="row cuerpo login valign-wrapper center">
      <div class="col s12 m8 offset-m2 l4 offset-l4 valing center">
        <div class="row card">
          <div class="row titulo center">
            <h5>INGRESAR</h5>
          </div>
          <div class="row">
            <form action="login" method="POST" accept-charset="ISO-8859-1">
                {{ csrf_field() }}
              <div class="input-field col s12">
                <input id="user" type="email" name="correo">
                <label for="user">Correo</label>
              </div>
              <div class="input-field col s12">
                <input id="pass" type="password" name="password">
                <label for="pass">Contraseña</label>
              </div>
              <div class="col s12 center">
                  <button type="submit" class="btn">INGRESAR</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @include('include.footer')