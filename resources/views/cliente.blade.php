    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>CONFIGURACIÓN</h4>
      </div>
        <div class="row">
            <div class="col s6 offset-s3 center">
                <form action="cliente" method="POST">
                    {{ csrf_field() }}
                    <div class="col s12 m8 offset-m2  input-field">
                        <input type="text" name="nombre" id="nombre" required value="{{$empresa->nombre}}" @if($empresa->nombre!=null) disabled @endif >
                        <label for="nombre">NOMBRE</label>
                    </div>
                    <div class="col s12 m8 offset-m2  input-field">
                        <input type="text" name="ruc" id="ruc" required value="{{$empresa->ruc}}" minlength="11" maxlength="11"  @if($empresa->ruc!=null) disabled @endif >
                        <label for="ruc">RUC</label>
                    </div>
                    <div class="col s12 m8 offset-m2  input-field">
                        <input type="text" name="direccion" id="direccion" value="{{$empresa->direccion}}">
                        <label for="direccion">DIRECCIÓN</label>
                    </div>
                    <div class="col s12 m8 offset-m2  input-field">
                        <input type="text" name="telefono" id="telefono" value="{{$empresa->telefono}}">
                        <label for="telefono">TELEFONO</label>
                    </div>
                    <div class="col s12 m8 offset-m2  input-field">
                        <input type="email" name="correo" id="correo" value="{{$empresa->correo}}">
                        <label for="correo">CORREO</label>
                    </div>
                    <div class="col s12 center input-field" id="divbtnregistrar">
                        <button type="submit" class="btn">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('include.footer')