<!--MENÚ MOBILE-->
<ul id="mobile-menu" data-collapsible="accordion" class="collapsible side-nav">
  @foreach($usuario->grupos as $grupo)
  <div class="divider"></div>
  <li>
      <a class="collapsible-header waves-effect blue darken-2 white-text">{{$grupo->nombre}}</a>
      <div class="collapsible-body">
          <ul>
              @foreach($usuario->menus as $menu)
                    @if($menu->link!=null)
                        @if($menu->idgrupo==$grupo->id)
                            @if($menu->tipo=="J")
                                <li><a onclick="{{$menu->link}}" class="waves-effect">{{$menu->nombre}}</a></li>
                            @else
                                <li><a href="{{$menu->link}}" class="waves-effect">{{$menu->nombre}}</a></li>
                            @endif
                        @endif
                    @endif
                @endforeach
          </ul>
      </div>
  </li>
  @endforeach
  <div class="divider"></div>
  <li>
      <a href="password" class="collapsible-header waves-effect brown white-text">CAMBIAR CONTRASEÑA</a>
  </li>
  <div class="divider"></div>
  <li>
      <a href="logout" class="collapsible-header waves-effect red white-text">SALIR</a>
  </li>
</ul>