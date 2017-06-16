    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>SISTEMA DE INVENTARIO DE EQUIPOS DE COMPUTO</h4>
      </div>
        <div class="row">
            @foreach($usuario->grupos as $grupo)
                <div class="col s12 m6 l4 iniciomenu">
                    <div class="col s10 offset-s1 card fullcol cardsinpadding">
                        <div class="row titulo center">
                            <h5>{{$grupo->nombre}}</h5>
                        </div>
                        <div class="col s10 offset-s1">
                            @foreach($usuario->menus as $menu)
                                @if($menu->link!=null)
                                    @if($menu->idgrupo==$grupo->id)
                                        @if($menu->tipo=="J")
                                            <div class="row">
                                                <a onclick="{{$menu->link}}" class="waves-effect">{{$menu->nombre}}</a>
                                            </div>
                                        @else
                                            <div class="row">
                                                <a href="{{$menu->link}}" class="waves-effect">{{$menu->nombre}}</a>
                                            </div>
                                            @if($menu->tipo=="D")
                                            <hr>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <style>
        @media only screen and (min-width: 993px) {
            .iniciomenu:nth-child(3n+1){
                clear: both;
            }
          }

          @media only screen and (max-width: 992px) {
            .iniciomenu:nth-child(2n+1){
                clear: both;
            }
          }
            
    </style>
    @include('include.footer')