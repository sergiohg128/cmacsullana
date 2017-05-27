<!--MENÚ WEB-->
<header class="navbar-fixed">
  <nav class="nav-wrapper"><a data-activates="mobile-menu" href="#" class="button-collapse left"><i class="material-icons">menu</i></a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
        @foreach($usuario->grupos as $grupo)
        <li>
            <a data-activates="dropdown_{{$grupo->id}}" class="dropdown-button waves-effect">
                {{$grupo->nombre}}
                <i class="material-icons right">arrow_drop_down</i>
            </a>
            <ul id="dropdown_{{$grupo->id}}" class="dropdown-content">
                @foreach($usuario->menus as $menu)
                    @if($menu->link!=null)
                        @if($menu->idgrupo==$grupo->id)
                            @if($menu->tipo=="J")
                                <li><a onclick="{{$menu->link}}" class="waves-effect">{{$menu->nombre}}</a></li>
                            @else
                                <li><a href="{{$menu->link}}" class="waves-effect">{{$menu->nombre}}</a></li>
                                @if($menu->tipo=="D")
                                    <li class="divider"></li>
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach
            </ul>
        </li>
        @endforeach
        <li>
            <a data-activates="dropdown_cuenta" class="dropdown-button waves-effect">
                CUENTA
                <i class="material-icons right">arrow_drop_down</i>
            </a>
            <ul id="dropdown_cuenta" class="dropdown-content">
                <li><a href="password" class="waves-effect">CAMBIAR CONTRASEÑA</a></li>
                <li><a href="logout" class="waves-effect">SALIR</a></li>
            </ul>
        </li>
    </ul>
  </nav>
</header>