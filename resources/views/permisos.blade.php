    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>PERMISOS</h4>
        <h5>TIPO {{$tipo->nombre}}</h5>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
             <table class="centered striped resp2">
               <thead>
                 <th>Menú</th>
                 <th>Grupo</th>
                 <th>Eliminar</th>
               </thead>
               <tbody id="filas">
                 @forelse($permisos as $permiso)
                     <tr id="fila{{$permiso->id}}">
                       <td>{{$permiso->nombremenu}}</td>
                       <td>{{$permiso->nombregrupo}}</td>
                       <td>
                           <form action="permiso" method="POST">
                               {{ csrf_field() }}
                               <input type="hidden" name="accion" value="eliminar">
                               <input type="hidden" name="tipo" value="{{$tipo->id}}">
                               <input type="hidden" name="id" value="{{$permiso->id}}">
                               <button type="submit" class="btn red"><i class="material-icons">delete</i></button>
                           </form>
                       </td>
                     </tr>
                 @empty
                     <tr id="filaempty">
                         <td colspan="6">No hay permisos</td>
                     </tr>
                 @endforelse
               </tbody>
             </table>
           </div> 
        </div>
      
      <div class="row titulo center">
        <h4>AÑADIR</h4>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
              <table class="centered striped resp2">
                <thead>
                  <th>Menú</th>
                  <th>Grupo</th>
                  <th>Agregar</th>
                </thead>
                <tbody id="filas">
                  @forelse($otros as $menu)
                      <tr>
                        <td>{{$menu->nombre}}</td>
                        <td>{{$menu->nombregrupo}}</td>
                        <td>
                           <form action="permiso" method="POST">
                               {{ csrf_field() }}
                               <input type="hidden" name="accion" value="agregar">
                               <input type="hidden" name="tipo" value="{{$tipo->id}}">
                               <input type="hidden" name="id" value="{{$menu->id}}">
                               <button type="submit" class="btn"><i class="material-icons">add</i></button>
                           </form>
                       </td>
                      </tr>
                  @empty
                      <tr id="filaempty">
                          <td colspan="6">No hay permisos</td>
                      </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
        </div>
            
    </div>
    @include('include.footer')
    @include('include.modal-agregar')
    @include('include.modal-editar')
    @include('include.modal-eliminar')