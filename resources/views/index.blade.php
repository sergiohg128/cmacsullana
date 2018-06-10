@include('include.head')
    @include('include.menu')
    @include('include.modal-login')

    @include('include.slider')
    
    <!-- Nosotros -->
    <section id="Nosotros" class="w-100">
      <div>
        <div class="row secondary-background p-10">
          <div class="col-md-6">
                <h1 class="text-size-xxlg text-white text-center font-weight-bold">NUESTRA</h1>
                <h1 class="lead text-size-xxlg text-white text-center">VISION</h1>
                <p class="text-center text-size-sm text-white m-8">{{$contenidos[13]->valor}}</p> 
          </div>
          <div class="form-inline col-md-6 text-center justify-content-center">
                 <div class="icon-object2 text-center text-white align-niddle"><i class="icon-trophy3"></i></div>
          </div>
        </div>

        <div class="row p-10">
          <div class="form-inline col-md-6 text-center justify-content-center">
                 <div class="icon-object2 text-center text-p align-niddle"><i class="icon-clipboard2"></i></div>
          </div>
          <div class="col-md-6">
                <h1 class="text-size-xxlg text-p text-center font-weight-bold">NUESTRA</h1>
                <h1 class="lead text-size-xxlg text-p text-center">MISIÓN</h1>
                <div class="container">
                  <p class="text-center text-size-sm text-p m-5">{{$contenidos[14]->valor}}</p> 
                </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Nosotros -->


    <!-- Nouestras Áreas -->
    <div id="Areas" class="row secondary-background">
      <div class="container">
         <div class="col-md-12 text text-white">
            <h4 class="lead text-size-lg">Nuestros Servicios</h4>
         </div>
      </div>
    </div>
    <section  class="areas">
      <div class="container">
        <div class="row">
          <div class="col-md-4 text-center">
            <div class="icon-object text-p"><i class="icon-checkmark"></i></div>
            <h1 class="text-size-lg">ASESORIA DE PREGRADO</h1>
            <?php
              $texto = $contenidos[22]->valor;
              $lineas = explode("*", $texto);
              foreach($lineas as $linea){
                echo '<p class="text-size-sm font-weight-light">'.$linea.'</p>';
              }
            ?>
          </div>
          <div class="col-md-4 text-center">
            <div class="icon-object text-p"><i class="icon-checkmark"></i></div>
            <h1 class="text-size-lg">ASESORIA DE POSTGRADO</h1>
            <?php
              $texto = $contenidos[23]->valor;
              $lineas = explode("*", $texto);
              foreach($lineas as $linea){
                echo '<p class="text-size-sm font-weight-light">'.$linea.'</p>';
              }
            ?>
          </div>
          <div class="col-md-4 text-center">
            <div class="icon-object text-p"><i class="icon-checkmark"></i></div>
            <h1 class="text-size-lg">CONSULTORA DE NEGOCIO</h1>
            <?php
              $texto = $contenidos[24]->valor;
              $lineas = explode("*", $texto);
              foreach($lineas as $linea){
                echo '<p class="text-size-sm font-weight-light">'.$linea.'</p>';
              }
            ?>
          </div>
        </div>
      </div>
    </section>
    <!-- End Nuestras <div class="col-md-6 mt-5">Áreas -->


      <!-- Staff  -->
    <div id="Staff" class="row secondary-background">
      <div class="container">
         <div class="col-md-12 text text-white">
            <h4 class="lead text-size-lg">Nuestro Staff</h4>
         </div>
      </div>
    </div>
    <section  class="areas staffs">
      <div class="container">
        <div class="row">
          @foreach($staffs as $staff)
          <div class="col-md-4 text-center">
            <img src="app/staff/{{$staff->id}}.{{$staff->extension}}"/>
            <h1 class="text-size-lg">{{$staff->nombre}}</h1>
            <p class="text-size-sm font-weight-light">{{$staff->cargo}}</p>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- End Nuestras <div class="col-md-6 mt-5">Áreas -->


    <!-- Modal Normas -->
    <div class="modal fade bd-example-modal-sm" id="normas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title w-100">Normas de Citación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="text-center">
              <div class="icon-object border-primary-300 text-primary-300"><i class="icon-book"></i></div>
              <h6 class="lead text-size-sm mt-4">Para nuestro mejor desempeño en el trabajo, trabajamos con las siguientes normas de citación.</h6>
            </div>
            <div class="container">
              <div class="row mt-5">
                    <div class="col-md-6 col-xs-12">
                       <a href="app/contenidos/contenido_18.pdf" target="_blank"><p class="bg-past1 text-center text-white p-5 nor-hov">APA</p></a>
                    </div>
                    <div class="col-md-6 col-xs-12">
                       <a href="app/contenidos/contenido_19.pdf" target="_blank"><p class="text-center bg-past2 text-white p-5 nor-hov">HARVARD</p></a>
                    </div>
              </div>

              <div class="row mtn">
                    <div class="col-md-6 col-xs-12">
                       <a href="app/contenidos/contenido_20.pdf" target="_blank"><p class="text-center text-white p-5 bg-past3 nor-hov">ISO 9000</p></a>
                    </div>
                    <div class="col-md-6 col-xs-12">
                       <a href="app/contenidos/contenido_21.pdf" target="_blank"><p class="text-center text-white p-5 bg-past4 nor-hov">VANCOUVER</p></a>
                    </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal Normas -->


    <!-- Sedes -->
    <section id="Sedes" class="sedes" style="background: url(img/slide/graduacion2.jpg) fixed; height:auto;"> 
      <div class="parallax-over" style="height:auto;">     
            <div class="container">
                <div class="text-center">
                    <h3 class="text-center text-white font-weight-light padding-sm text-size-lg">NUESTRAS SEDES</h3>
                </div>  
                <div class="row text-center mt-5">               
                  @foreach($sedes as $sede)
                    <div class="col-md-6 col-xs-12 text-white font-weight-light mt-4">
                      <h2 class="lead text-size-lg text-white"><i class="icon-location3 text-size-xlg text-primary"></i>{{$sede->nombre}}</h2>
                      <p class="mt-4">{{$sede->direccion}}</p>
                      <p>Telf: {{$sede->telefono}}}</p>
                      <p>Correo: {{$sede->correo}}</p>
                      <button class="btn btn-outline-primary btn-lg mt-3 mb-8">Ubícanos</button> 
                    </div>          
                  @endforeach
              </div>
            </div>
    </section> 
    <!-- Nuestras Sedes -->



    <!-- Modal -->
    <div class="modal fade bd-example-modal-sm" id="modalSkype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="text-center w-100">REGISTRAR ASESORIA EN SKYPE</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="contacto"  accept-charset="ISO-8859-1">
              {{ csrf_field() }}
                <input type="hidden" name="tipo" value="S">
                <div class="row">
                  <div class="form-group col">
                    <label>Inicio de Fecha</label>
                    <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="icon-calendar"></i></div>
                              </div>
                              <input type="text" class="form-control" id="inicio" placeholder="Fecha" name="fecha" readonly">
                    </div>
                  </div>

                  <div class="form-group col">
                    <label>Inicio de Hora</label>
                    <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="icon-history"></i></div>
                              </div>
                              <input type="text" class="form-control" id="hora" placeholder="Hora" name="hora" readonly>
                    </div>
                  </div>
                </div>


                <div class="form-group">
                  <label>Nombre Completo</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-user-tie"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtNombres" placeholder="Nombres Completos" name="nombre" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Celular</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-phone2"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtTelefono" placeholder="Numero de celular" name="telefono" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-envelop"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtEmail" placeholder="Email" name="correo" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Tu Skype</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-skype"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtSkype" placeholder="Skype" name="skype" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Universidad</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-user-tie"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtUniversidad" placeholder="Universidad" name="universidad" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Carrera Profesional</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-user-tie"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtSkype" placeholder="Carrera Profesional" name="carrera" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-lg">Reservar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

    <!--FullCalendar-->

    <section>
      <div class="container" id="skype">
        <div class="row flex-column flex-md-row justify-content-center">
          <div class="text-center my-5">
            <h4 id="titulo">HORARIO {{$contenidos[25]->valor}}</h4>
          </div>
        </div>
      </div>

      <div class="container mb-8">
        <div class="row">
          <div id="calendar">
            
          </div>
        </div>  
      </div>
    </section>

    <!--End FullCalendar-->


    <!-- Contacto -->
    <div id="Contacto" class="container-fluid secondary-background">
            <form action="contacto" method="POST" accept-charset="ISO-8859-1" class="form-inline flex-column flex-md-row justify-content-center">
            <section class="container py-5">
              <div class="sec-title text-center">
              <h3 class="text-uppercase text-center mb-4 pt-5 text-white lead text-size-lg">CONTACTO</h3>
              </div>
              <div class="sec-title text-center">
              <p class="lead text-center mb-4 text-white">Para mayor información completa el siguiente formulario y pronto nos comunicaremos contigo.</p>
              </div>             
              <div class="sec-title text-center">
                
                  {{ csrf_field() }}
                  <input type="hidden" name="tipo" value="C">

                  <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="form-group mx-3 my-3 justify-content-center">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-user-tie"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtNombre2" placeholder="Nombre Completo" name="nombre" required>
                          </div>
                      </div>
                    </div>


                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="form-group mx-3 my-3 justify-content-center">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-envelop"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtEmail2" placeholder="Email" name="correo" required>
                          </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="form-group mx-3 my-3 justify-content-center">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-envelop"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtTelefono2" placeholder="Número de celular" name="telefono" required>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4 col-sm-12">
                      <div class="form-group  justify-content-center">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-office"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtUniversidad2" placeholder="Universidad" name="universidad" required>
                          </div>
                      </div>
                    </div>


                    <div class="col-lg-4 col-sm-12">
                      <div class="form-group  justify-content-center">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text"><i class="icon-briefcase"></i></div>
                            </div>
                            <input type="text" class="form-control" id="txtProfesional2" placeholder="Carrera Profesional" name="carrera" required>
                          </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-sm-12 center">
                      <button class="btn btn-lg btn-outline-light" type="submit">Enviar</button>
                    </div>
                  </div>
               </div>
            </section>
            </form>
    </div>
    <!-- End Contacto -->

    @include('include.footer')
    
    
    <script>
      var scroll =  new  SmoothScroll ('a[href*="#Nosotros"],a[href*="#Areas"],a[href*="#Sedes"],a[href*="#Contacto"],a[href*="#skype"],a[href*="#Staff"]',{
        speed: 900,
      });
    </script>

    <script>

      $('#calendar').fullCalendar({
        minTime: "08:00:00",
        defaultView: 'agendaWeek',
        locale: 'es',
        allDaySlot: false,
        maxTime: "19:00:00",
        themeSystem: 'standard',
        hiddenDays: [0],
        height:640,
        dayClick: function(date) {
          str = date.format();
          var res = str.split("T");
          $("#inicio").val(res[0]);
          $("#hora").val(res[1]);
          $("#modalSkype").modal();
        }
      });
    </script>