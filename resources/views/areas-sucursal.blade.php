    @include('include.head')
    @include('include.menu')
    @include('include.menu-mobile')
    <!--Cuerpo-->
    <div class="row cuerpo">
      <div class="row titulo center">
        <h4>ÁREAS</h4>
        <h5>SUCURSAL: {{$sucursal->nombre}}</h5>
      </div>
        <div class="row">
            <div class="col s10 offset-s1 tabla">
             <table class="centered striped resp2">
               <thead>
                 <th>Nombre</th>
                 <th>Eliminar</th>
               </thead>
               <tbody id="filas">
                 @forelse($areassucursal as $areasucursal)
                     <tr id="fila{{$areasucursal->id}}">
                       <td>{{$areasucursal->nombre}}</td>
                       <td>
                           <form action="area-sucursal" method="POST">
                               {{ csrf_field() }}
                               <input type="hidden" name="accion" value="eliminar">
                               <input type="hidden" name="id" value="{{$areasucursal->id}}">
                               <button type="submit" class="btn red"><i class="material-icons">delete</i></button>
                           </form>
                       </td>
                     </tr>
                 @empty
                     <tr id="filaempty">
                         <td colspan="2">No hay áreas asignadas a la sucursal</td>
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
                  <th>Nombre</th>
                  <th>Agregar</th>
                </thead>
                <tbody id="filas">
                  @forelse($areas as $area)
                      <tr>
                        <td>{{$area->nombre}}</td>
                        <td>
                           <form action="area-sucursal" method="POST">
                               {{ csrf_field() }}
                               <input type="hidden" name="accion" value="agregar">
                               <input type="hidden" name="sucursal" value="{{$sucursal->id}}">
                               <input type="hidden" name="area" value="{{$area->id}}">
                               <button type="submit" class="btn"><i class="material-icons">add</i></button>
                           </form>
                       </td>
                      </tr>
                  @empty
                      <tr id="filaempty">
                          <td colspan="6">No hay áreas para agregar</td>
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