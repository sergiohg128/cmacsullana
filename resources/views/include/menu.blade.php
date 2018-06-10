<!-- Header-->
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top border-bottom">
        <a class="navbar-brand" href="#">GRUPO CYSEG</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
          <ul class="smooth-scroll navbar-nav text-size-xm mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a data-scroll class="nav-link" href="#Nosotros">Nosotros</a>
            </li>
            <li class="nav-item">
              <a data-scroll class="nav-link" href="#Areas">Nuestros Servicios</a>
            </li>
            <li class="nav-item">
              <a data-scroll class="nav-link" href="#Staff">Staff</a>
            </li>
            <li class="nav-item">
              <a class="nav-link cursor" data-toggle="modal" data-target="#normas" >Normas de Citación</a>
            </li>
            <li class="nav-item">
              <a data-scroll class="nav-link" href="#Sedes">Sedes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#skype">Cita Skype</a>
            </li>
            <li class="nav-item">
              <a data-scroll class="nav-link" href="#Contacto">Contáctanos</a>
            </li>
          </ul>

          <form class="form-inline my-2 my-lg-0">
          <!-- Button modal -->
                <div>
                  <a href="{{$contenidos[15]->valor}}" target="_blank" class="mr-sm-2"><i class="icon-facebook text-size-lg over-f"></i></a>
                  <a href="{{$contenidos[16]->valor}}" target="_blank" class="mr-sm-2"><i class="icon-youtube3 text-size-lg over-f"></i></a>
                  <a href="{{$contenidos[17]->valor}}" target="_blank" class="mr-sm-2"><i class="icon-twitter text-size-lg mr-5 over-y"></i></a>
                  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">
                    Ingresar
                  </button>
                </div>
          <!-- Button modal -->
          </form>
        </div>
      </nav>
    </header>
    <!-- End Header -->