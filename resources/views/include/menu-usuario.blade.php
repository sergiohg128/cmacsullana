<!-- Nav-->
		<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary text-white" id="mainNav">
		    <a class="navbar-brand text-white" href="inicio">GRUPO CYSEG</a>
		    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		    </button>

		    <div class="collapse navbar-collapse" id="navbarResponsive">
		      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion"> 
		        <div id="perfil-data" class="text-center">       	       
		            <img src="img/vectorProfile.jpg" class="rounded mx-auto d-block"/>
		            <span class="name lead">{{$usuario->completo()}}</span>
		        </div>

		        @foreach($usuario->menus as $menu)
			        @if($menu->orden>0)
				        <li class="nav-item">
				          <a class="nav-link" href="{{$menu->link}}">
				            <!-- <i class="icon-folder-open"></i> -->
				            <span class="nav-link-text lead text-size-sm ml-2">{{$menu->nombre}}</span>
				          </a>
				        </li>
			        @endif
		        @endforeach
			        @if($usuario->id_tipo==2)
			        	<li class="nav-item">
				          <a class="nav-link" href="proyectos?id={{$usuario->id}}">
				            <!-- <i class="icon-folder-open"></i> -->
				            <span class="nav-link-text lead text-size-sm ml-2">Proyectos</span>
				          </a>
				        </li>
				    @endif
		      </ul>

		      <ul class="navbar-nav sidenav-toggler">
		        <li class="nav-item">
		          <a class="nav-link text-center" id="sidenavToggler">
		            <i class="icon-arrow-left22"></i>
		          </a>
		        </li>
		      </ul>

		      <ul class="navbar-nav ml-auto">
		        <li class="nav-item">
		          <a class="nav-link text-white" data-toggle="modal" data-target="#ModalLog"><i class="icon-cross"></i> Cerrar Sesión</a>
		        </li>
		      </ul>

		    </div>
		</nav>
  		<!-- End Nav-->