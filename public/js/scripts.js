$( document ).ready(function(){
    
    window.addEventListener("keypress", function(event){
        if (event.keyCode == 13){
            event.preventDefault();
        }
    }, false);
        
  $('.fixed-action-btn').openFAB();
  $('.fixed-action-btn').closeFAB();
  $('.collapsible').collapsible();
	$(".dropdown-button").dropdown({
    hover:true,
    belowOrigin: true
  });
  $('.slider').slider({
    full_width: true,
    indicators: false
  });
	$('select').material_select();
  	$('#textarea1').trigger('autoresize');
  	$('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15 // Creates a dropdown of 15 years to control year
	  });
  $('.button-collapse').sideNav({
  	menuWidth: 240
  });
  $('.modal').modal({
  		starting_top: '10%',
      	ending_top: '5%'
  	});
  $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
})


var actualizarpagina = true;

function alerta(mensaje,tiempo){
    if(tiempo==null){
        tiempo = 5000;
    }
    Materialize.toast(mensaje,tiempo);
}

//----------------------LISTADOS AJAX--------------------------//


function listarprovincias(modo){
    var id = $('#departamento-'+modo).val();
    if(id>0){
        $.ajax({
            type: "GET",
            url: "provincias",
            data: {"id":id},
            success: function(a) {
                a = JSON.parse(a);
                var provincias = a.obj;
                var html = '<option value="0">Elija una provincia</option>';
                $.each(provincias,function (key,provincia){
                  html += "<option value='"+provincia.id+"'  id='provincia"+provincia.id+"-"+modo+"'>"+provincia.nombre+"</option>";  
                });
                $('#provincia-'+modo).html(html);
                $('#distrito-'+modo).html('<option value="0">Elija un distrito</option>');
                $('#provincia-'+modo).material_select('destroy');
                $('#distrito-'+modo).material_select('destroy');
                $('#provincia-'+modo).material_select();
                $('#distrito-'+modo).material_select();
            }
        });
    }
}


function listardistritos(modo){
    var id = $('#provincia-'+modo).val();
    if(id>0){
        $.ajax({
            type: "GET",
            url: "distritos",
            data: {"id":id},
            success: function(a) {
                a = JSON.parse(a);
                var distritos = a.obj;
                var html = '<option value="0">Elija un distrito</option>';
                $.each(distritos,function (key,distrito){
                  html += "<option value='"+distrito.id+"' id='distrito"+distrito.id+"-"+modo+"'>"+distrito.nombre+"</option>";  
                });
                $('#distrito-'+modo).html(html);
                $('#distrito-'+modo).material_select('destroy');
                $('#distrito-'+modo).material_select();
            }
        });
    }
}


function listarmodelos(){
    var marca = $('#marcas').val();
    var tipo = $('#tiposequipo').val();
    $.ajax({
        type: "GET",
        url: "modelos",
        data: {"modo":"ajax","id_marca":marca,"id_tipo_equipo":tipo},
        success: function(a) {
            a = JSON.parse(a);
            var modelos = a.obj;
            var html = '<label>PRODUCTOS</label><select  id="modelos" style="width: 100%;"><option value="0">TODOS</option>';
            $.each(modelos,function (key,modelo){
              html += "<option value='"+modelo.id+"'>"+modelo.nombre+"</option>";  
            });
            html += "</select>"
            $('#divmodelos').html(html);
            $('#modelos').select2();
        },beforeSend:function(){
            $("#divmodelos").html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

//------------------LISTADOS AJAX--------------------------------//


//-----------------------OTROS--------------------------------//



function asignararea(id){
    var area = $('#select'+id).val();
    if(area>=0){
        $.ajax({
            type: "GET",
            url: "asignar-area",
            data: {"id":id,"a":area},
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(area>0){
                        alerta("Área asignada");   
                    }else{
                        alerta("Asignado a ninguna área");
                    }
                   $('#estado'+id).html("<i class='material-icons green-text'>done</i>");
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $('#estado'+id).html("<i class='material-icons red-text'>clear</i>");
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#estado'+id).html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }
}


function verproveedor(id){
    if(id>0){
        $.ajax({
            type: "GET",
            url: "verproveedor",
            data: {"id":id},
            success: function(a) {
                a = JSON.parse(a);
                var proveedor = a.obj;
                $('#razon-editar').val(proveedor.razon);
                $('#ruc-editar').val(proveedor.ruc);
                $('#contacto-editar').val(proveedor.contacto);
                $('#direccion-editar').val(proveedor.direccion);
                $('#fijo-editar').val(proveedor.fijo);
                $('#celular-editar').val(proveedor.celular);
                $('#correo-editar').val(proveedor.correo);
                $('#pagina-editar').val(proveedor.pagina);
                if(proveedor.tipo==1){
                    $('#tipo-editar').val(proveedor.denombre+"-"+proveedor.prnombre+"-"+proveedor.dinombre);
                }else{
                    $('#tipo-editar').val(proveedor.panombre);
                }
                
                $('#lbl-razon-editar').addClass("active");
                $('#lbl-ruc-editar').addClass('active');
                $('#lbl-contacto-editar').addClass('active');
                $('#lbl-direccion-editar').addClass('active');
                $('#lbl-fijo-editar').addClass('active');
                $('#lbl-celular-editar').addClass('active');
                $('#lbl-correo-editar').addClass('active');
                $('#lbl-pagina-editar').addClass('active');
                $('#lbl-tipo-editar').addClass('active');
                
                $('#modal-ver').modal('open');
            }
        });
    }
}


function abrirtrasladosucursal(){
    var sucursal = $('#sucursalmodaltraslados').val();
    if(sucursal>0){
        window.location = "traslado-nuevo?id="+sucursal;
    }else{
        alerta("Elija una sucursal");
    }
}



function modalnuevaguia(){
    $('#modal-nuevaguia').modal("open");
    $.ajax({
        type: "GET",
        url: "proveedores?modo=ajax",
        success: function(a) {
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.obj;
                var html = '<label for="proveedornuevaguia">PROVEEDORES</label>'+
                            '<select id="proveedornuevaguia" name="proveedor" style="width: 100%;" onchange="elegirproveedornuevaguia()">'+
                            '<option value="0">ELIJA UN PROVEEDOR</option>';
                $.each(lista,function (key,proveedor){
                  html += "<option value='"+proveedor.id+"'>"+proveedor.razon+"</option>";  
                });
                html += '</select>';
                $('#divproveedornuevaguia').html(html);
                $('#proveedornuevaguia').select2();
            }else{
                if(a.url==null){
                    alerta(a.error,10000);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            $('#divproveedornuevaguia').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

function elegirproveedornuevaguia(){
    var id = $('#proveedornuevaguia').val();
    if(id>0){
        $.ajax({
            type: "GET",
            url: "contratos?modo=ajax&id_proveedor="+id,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    var lista = a.obj;
                    var html = '<label for="contratonuevaguia">CONTRATOS</label>'+
                                '<select id="contratonuevaguia" name="contrato" style="width: 100%;">'+
                                '<option value="0">ELIJA UN CONTRATO</option>';
                    $.each(lista,function (key,contrato){
                      html += "<option value='"+contrato.id+"'>"+contrato.numero+"</option>";  
                    });
                    html += '</select>';
                    $('#divcontratonuevaguia').html(html);
                    $('#contratonuevaguia').select2();
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#divcontratonuevaguia').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }else{
        alerta("Elija un proveedor");
    }
}

function nuevaguia(){
    var id = $('#contratonuevaguia').val();
    if(id>0){
        window.location = "guia-nueva?id="+id;
    }else{
        alerta("Elija un contrato");
    }
}

//----------------------OTROS------------------------------//



//-------------------MANTENIMIENTOS-------------------------//

function modaleliminar(tabla,id){
    $('#tabla-eliminar').val(tabla);
    $('#id-eliminar').val(id);
    $('#modal-eliminar').modal('open');
}

function eliminarpost(){
    var id = $('#id-eliminar').val();
    if(id>0){
        var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        var btn = '<button onclick="eliminarpost()" class="btn-large">ELIMINAR</button>';
        $("#divbtneliminar").html(cargando);
        var formData = $("#formeliminar").serialize();
        $.ajax({
            type: "POST",
            url: "eliminarpost",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(actualizarpagina){
                        window.location.reload();
                    }else{
                        alerta("ELIMINADO CORRECTAMENTE");
                        $('#fila'+id).remove();
                        $("#modal-eliminar").modal('close');
                        $("#divbtneliminar").html(btn);
                    }
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $("#divbtneliminar").html(btn);
                    }else{
                        window.location = a.url;
                    }
                }
            }
        });
    }
        
}

function modaleditarmarca(id,nombre,abreviatura){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#abreviatura-editar').val(abreviatura);
    $('#lbl-nombre-editar').addClass('active');
    $('#lbl-abreviatura-editar').addClass('active');
}

function marcapost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var abreviatura = $('#abreviatura-'+modo).val();
        if(abreviatura.trim().length>0){
            var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
            if(modo=="agregar"){
                var btn = '<button onclick="marcapost(\'agregar\')" class="btn-large">GRABAR</button>';
            }else if(modo=="editar"){
                var btn = '<button onclick="marcapost(\'editar\')" class="btn-large">GRABAR</button>';
            }
            $("#divbtn"+modo).html(cargando);
            var formData = $("#form"+modo).serialize();
            $.ajax({
                type: "POST",
                url: "marca",
                data: formData,
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                        if(actualizarpagina){
                            window.location.reload();
                        }else{
                            var marca = a.obj;
                            if(modo=="agregar"){
                                alerta("GUARDADO CORRECTAMENTE");
                                var fila = '';
                                fila = '<tr id="fila'+marca.id+'">'+
                                        '<td id="filanombre'+marca.id+'">'+marca.nombre+'</td>'+
                                        '<td id="filaabreviatura'+marca.id+'">'+marca.abreviatura+'</td>'+
                                        '<td id="filaeditar'+marca.id+'"><a onclick="modaleditarmarca('+marca.id+',\''+marca.nombre+'\',\''+marca.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                        '<td><a onclick="modaleliminar(\'marca\','+marca.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                      '</tr>';

                                $('#filas').prepend(fila);
                                $('#filaempty').hide();
                                $("#nombre-agregar").val(null);
                                $("#abreviatura-agregar").val(null);
                            }else if(modo=="editar"){
                                alerta("EDITADO CORRECTAMENTE");
                                $('#filanombre'+marca.id).html(marca.nombre);
                                $('#filaabreviatura'+marca.id).html(marca.abreviatura);
                                $('#filaeditar'+marca.id).html('<a onclick="modaleditarmarca('+marca.id+',\''+marca.nombre+'\',\''+marca.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                            }
                            $("#modal-"+modo).modal('close');
                            $("#divbtn"+modo).html(btn);
                        }
                    }else{
                        if(a.url==null){
                            alerta(a.error,10000);
                            $("#divbtn"+modo).html(btn);
                        }else{
                            window.location = a.url;
                        }
                    }
                }
            });
        }else{
            alerta("Ingrese una abreviatura");
        }
    }else{
        alerta("Ingrese un nombre");
    }
}

function modaleditartipoequipo(id,nombre,abreviatura){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#abreviatura-editar').val(abreviatura);
    $('#lbl-nombre-editar').addClass('active');
    $('#lbl-abreviatura-editar').addClass('active');
}

function tipoequipopost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var abreviatura = $('#abreviatura-'+modo).val();
        if(abreviatura.trim().length>0){
            var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
            if(modo=="agregar"){
                var btn = '<button onclick="tipoequipopost(\'agregar\')" class="btn-large">GRABAR</button>';
            }else if(modo=="editar"){
                var btn = '<button onclick="tipoequipopost(\'editar\')" class="btn-large">GRABAR</button>';
            }
            $("#divbtn"+modo).html(cargando);
            var formData = $("#form"+modo).serialize();
            $.ajax({
                type: "POST",
                url: "tipoequipo",
                data: formData,
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                        if(actualizarpagina){
                            window.location.reload();
                        }else{
                            var tipoequipo = a.obj;
                            if(modo=="agregar"){
                                alerta("GUARDADO CORRECTAMENTE");
                                var fila = '';
                                fila = '<tr id="fila'+tipoequipo.id+'">'+
                                        '<td id="filanombre'+tipoequipo.id+'">'+tipoequipo.nombre+'</td>'+
                                        '<td id="filaabreviatura'+tipoequipo.id+'">'+tipoequipo.abreviatura+'</td>'+
                                        '<td><a href="productos?id_tipo_equipo='+tipoequipo.id+'" class="btn"><i class="material-icons">input</i></a></td>'+
                                        '<td id="filaeditar'+tipoequipo.id+'"><a onclick="modaleditartipoequipo('+tipoequipo.id+',\''+tipoequipo.nombre+'\',\''+tipoequipo.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                        '<td><a onclick="modaleliminar(\'tipoequipo\','+tipoequipo.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                      '</tr>';

                                $('#filas').prepend(fila);
                                $('#filaempty').hide();
                                $("#nombre-agregar").val(null);
                                $("#abreviatura-agregar").val(null);
                            }else if(modo=="editar"){
                                alerta("EDITADO CORRECTAMENTE");
                                $('#filanombre'+tipoequipo.id).html(tipoequipo.nombre);
                                $('#filaabreviatura'+tipoequipo.id).html(tipoequipo.abreviatura);
                                $('#filaeditar'+tipoequipo.id).html('<a onclick="modaleditartipoequipo('+tipoequipo.id+',\''+tipoequipo.nombre+'\',\''+tipoequipo.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                            }
                            $("#modal-"+modo).modal('close');
                            $("#divbtn"+modo).html(btn);
                        }
                    }else{
                        if(a.url==null){
                            alerta(a.error,10000);
                            $("#divbtn"+modo).html(btn);
                        }else{
                            window.location = a.url;
                        }
                    }
                }
            });
        }else{
            alerta("Ingrese una abreviatura");
        }
    }else{
        alerta("Ingrese un nombre");
    }
}



function modaleditartipousuario(id,nombre){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#lbl-nombre-editar').addClass('active');
}

function tipousuariopost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        if(modo=="agregar"){
            var btn = '<button onclick="tipousuariopost(\'agregar\')" class="btn-large">GRABAR</button>';
        }else if(modo=="editar"){
            var btn = '<button onclick="tipousuariopost(\'editar\')" class="btn-large">GRABAR</button>';
        }
        $("#divbtn"+modo).html(cargando);
        var formData = $("#form"+modo).serialize();
        $.ajax({
            type: "POST",
            url: "tipousuario",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(actualizarpagina){
                        window.location.reload();
                    }else{
                        var tipousuario = a.obj;
                        if(modo=="agregar"){
                            alerta("GUARDADO CORRECTAMENTE");
                            var fila = '';
                            fila = '<tr id="fila'+tipousuario.id+'">'+
                                    '<td id="filanombre'+tipousuario.id+'">'+tipousuario.nombre+'</td>'+
                                    '<td><a href="permisos?id='+tipousuario.id+'" class="btn"><i class="material-icons">input</i></a></td>'+
                                    '<td><a href="usuarios?id='+tipousuario.id+'" class="btn brown"><i class="material-icons">input</i></a></td>'+
                                    '<td id="filaeditar'+tipousuario.id+'"><a onclick="modaleditartipousuario('+tipousuario.id+',\''+tipousuario.nombre+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                    '<td><a onclick="modaleliminar(\'tipousuario\','+tipousuario.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                  '</tr>';

                            $('#filas').prepend(fila);
                            $('#filaempty').hide();
                            $("#nombre-agregar").val(null);
                            $("#abreviatura-agregar").val(null);
                        }else if(modo=="editar"){
                            alerta("EDITADO CORRECTAMENTE");
                            $('#filanombre'+tipousuario.id).html(tipousuario.nombre);
                            $('#filaeditar'+tipousuario.id).html('<a onclick="modaleditartipousuario('+tipousuario.id+',\''+tipousuario.nombre+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                        }
                        $("#modal-"+modo).modal('close');
                        $("#divbtn"+modo).html(btn);
                    }

                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $("#divbtn"+modo).html(btn);
                    }else{
                        window.location = a.url;
                    }
                }
            }
        });
    }else{
        alerta("Ingrese un nombre");
    }
}


function modaleditarusuario(id,nombre,modo){
    $('#id-'+modo).val(id);
    $('#subtitulo-'+modo).html(nombre);
    $('#modal-'+modo).modal('open');
}

function validarEmail(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
   return true;
  } else {
   return false;
  }
}

function usuariopost(modo,tipo){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    if(modo=="agregar"){
        if(tipo==2){
            var btn = '<button onclick="usuariopost(\''+modo+'\',2)" class="btn-large">GRABAR</button>';
        }else{
            var btn = '<button onclick="usuariopost(\''+modo+'\')" class="btn-large">GRABAR</button>';
        }
    }else if(modo=="editar"){
        var btn = '<button onclick="usuariopost(\''+modo+'\')" class="btn-large">GRABAR</button>';
    }else if(modo=="eliminar"){
        var btn = '<button onclick="usuariopost(\''+modo+'\')" class="btn-large">ELIMINAR</button>';
    }else if(modo=="restablecer"){
        var btn = '<button onclick="usuariopost(\''+modo+'\')" class="btn-large">RESTABLECER</button>';
    }else if(modo=="desactivar"){
        var btn = '<button onclick="usuariopost(\''+modo+'\')" class="btn-large">DESACTIVAR</button>';
    }
    var ok = true;
    if(modo=="agregar"){
        var nombre = $('#nombre-agregar').val();
        if(nombre.trim().length>0){
            var apellidos = $('#apellidos-agregar').val();
            if(apellidos.trim().length>0){
                var correo = $('#correo-agregar').val();
                if(correo.trim().length>0){
                    ok = validarEmail(correo);
                    if(!ok){
                        alerta("Ingrese un correo");                    
                    }else{
                        if(tipo==2){
                            var proveedor = $('#proveedor').val();
                            if(proveedor>0){
                                
                            }else{
                                alerta("Elija un proveedor");
                                ok = false;
                            }
                        }
                    }
                }else{
                    ok = false;
                    alerta("Ingrese un correo");
                }
            }else{
                ok = false;
                alerta("Ingrese los apellidos");
            }
        }else{
            ok = false;
            alerta("Ingrese un nombre");
        }
    }
    if(modo=="editar"){
        var tipo = $('#tipo-editar').val();
        if(tipo>0){
        }else{
            alerta("Elija un tipo de usuario");
            ok = false;
        }
    }
    if(ok){
        $("#divbtn"+modo).html(cargando);
        var formData = $("#form"+modo).serialize();
        $.ajax({
            type: "POST",
            url: "usuario",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(actualizarpagina){
                        window.location.reload();
                    }else{
                        var usuario = a.obj;
                        if(modo=="agregar"){
                            alerta("GUARDADO CORRECTAMENTE");
                            var fila = '';
                            fila = '<tr id="fila'+usuario.id+'">'+
                                    '<td>'+usuario.apellidos+' '+usuario.nombre+'</td>'+
                                    '<td>'+usuario.correo+'</td>'+
                                    '<td><a onclick="modaleditarusuario('+usuario.id+',\''+usuario.apellidos+' '+usuario.nombre+'\',\'editar\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                    '<td><a onclick="modaleditarusuario('+usuario.id+',\''+usuario.apellidos+' '+usuario.nombre+'\',\'restablecer\')" class="btn"><i class="material-icons">replay</i></a></td>'+
                                    '<td><a onclick="modaleditarusuario('+usuario.id+',\''+usuario.apellidos+' '+usuario.nombre+'\',\'eliminar\')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                  '</tr>';
                            $('#filas').prepend(fila);
                            $('#filaempty').hide();
                            $("#nombre-agregar").val(null);
                            $("#nombre-apellidos").val(null);
                            $("#nombre-correo").val(null);
                        }else if(modo=="editar"){
                            alerta("EDITADO CORRECTAMENTE");
                            $('#fila'+usuario.id).remove();
                        }else if(modo=="restablecer"){
                            alerta("CONTRASEÑA RESTABLECIDA");
                        }else if(modo=="eliminar"){
                            alerta("USUARIO ELIMINADO");
                            $('#fila'+usuario.id).remove();
                        }
                        $("#modal-"+modo).modal('close');
                        $("#divbtn"+modo).html(btn);
                    }

                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $("#divbtn"+modo).html(btn);
                    }else{
                        window.location = a.url;
                    }
                }
            }
        });
    }       
}


function modaleditarzona(id,nombre,descripcion){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#descripcion-editar').val(descripcion);
    $('#lbl-nombre-editar').addClass('active');
    $('#lbl-descripcion-editar').addClass('active');
}

function zonapost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var abreviatura = $('#descripcion-'+modo).val()
        if(abreviatura.trim().length>3){
            alerta("Ingrese una abreviatura menor a 3 letras");
        }else{
            var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
            if(modo=="agregar"){
                var btn = '<button onclick="zonapost(\'agregar\')" class="btn-large">GRABAR</button>';
            }else if(modo=="editar"){
                var btn = '<button onclick="zonapost(\'editar\')" class="btn-large">GRABAR</button>';
            }
            $("#divbtn"+modo).html(cargando);
            var formData = $("#form"+modo).serialize();
            $.ajax({
                type: "POST",
                url: "zona",
                data: formData,
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                        if(actualizarpagina){
                            window.location.reload();
                        }else{
                            var zona = a.obj;
                            if(modo=="agregar"){
                                alerta("GUARDADO CORRECTAMENTE");
                                var fila = '';
                                fila = '<tr id="fila'+zona.id+'">'+
                                        '<td id="filanombre'+zona.id+'">'+zona.nombre+'</td>'+
                                        '<td id="filadescripcion'+zona.id+'">'+zona.abreviatura+'</td>'+
                                        '<td id="filaeditar'+zona.id+'"><a onclick="modaleditarzona('+zona.id+',\''+zona.nombre+'\',\''+zona.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                        '<td><a onclick="modaleliminar(\'zona\','+zona.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                      '</tr>';

                                $('#filas').prepend(fila);
                                $('#filaempty').hide();
                                $("#nombre-agregar").val(null);
                                $("#descripcion-agregar").val(null);
                            }else if(modo=="editar"){
                                alerta("EDITADO CORRECTAMENTE");
                                $('#filanombre'+zona.id).html(zona.nombre);
                                $('#filadescripcion'+zona.id).html(zona.abreviatura);
                                $('#filaeditar'+zona.id).html('<a onclick="modaleditarzona('+zona.id+',\''+zona.nombre+'\',\''+zona.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                            }
                            $("#modal-"+modo).modal('close');
                            $("#divbtn"+modo).html(btn);
                        }
                    }else{
                        if(a.url==null){
                            alerta(a.error,10000);
                            $("#divbtn"+modo).html(btn);
                        }else{
                            window.location = a.url;
                        }
                    }
                }
            });
        }
    }else{
        alerta("Ingrese un nombre");
    }
}


function sucursalpost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var direccion = $('#direccion-'+modo).val();
        if(direccion.trim().length>0){
            var tipoterritorio = $('#tipoterritorio-'+modo).val();
            if(tipoterritorio>0){
                var tiposucursal = $('#tiposucursal-'+modo).val();
                if(tiposucursal>0){
                    var zona = $('#zona-'+modo).val();
                    if(zona>0){
                        var distrito = $('#distrito-'+modo).val();
                        if(distrito>0){
                            var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
                            var btn = '<button onclick="sucursalpost(\''+modo+'\')" class="btn-large">GRABAR</button>';
                            $("#divbtn"+modo).html(cargando);
                            var formData = $("#form"+modo).serialize();
                            $.ajax({
                                type: "POST",
                                url: "sucursal",
                                data: formData,
                                success: function(a) {
                                    a = JSON.parse(a);
                                    if(a.ok){
                                        if(actualizarpagina){
                                            window.location.reload();
                                        }else{
                                            var iddepartamento = $('#departamento-'+modo).val();
                                            var idprovincia = $('#provincia-'+modo).val();
                                            var iddistrito = $('#distrito-'+modo).val();
                                            var ndepartamento = $('#departamento'+iddepartamento+'-'+modo).html();
                                            var nprovincia = $('#provincia'+idprovincia+'-'+modo).html();
                                            var ndistrito = $('#distrito'+iddistrito+'-'+modo).html();
                                            var nzona = $('#zona-'+modo).html();
                                            var ntipoterritorio = $('#tipoterritorio-'+modo).html();
                                            var ntiposucursal = $('#tiposucursal-'+modo).html();
                                            var sucursal = a.obj;
                                            if(modo=="agregar"){
                                                alerta("GUARDADO CORRECTAMENTE");
                                                var fila = '';
                                                fila = '<tr id="fila'+sucursal.id+'">'+
                                                        '<td id="filanombre'+sucursal.id+'">'+sucursal.nombre+'</td>'+
                                                        '<td id="filadireccion'+sucursal.id+'">'+sucursal.direccion+'</td>'+
                                                        '<td id="filazona'+sucursal.id+'">'+nzona+'</td>'+
                                                        '<td id="filatipoterritorio'+sucursal.id+'">'+ntipoterritorio+'</td>'+
                                                        '<td id="filatiposucursal'+sucursal.id+'">'+ntiposucursal+'</td>'+
                                                        '<td id="filaubicacion'+sucursal.id+'">'+ndepartamento+'-'+nprovincia+'-'+ndistrito+'</td>'+
                                                        '<td><a href="areas-sucursal?id='+sucursal.id+'"><button class="btn brown"><i class="material-icons">input</i></button></a></td>'+
                                                        '<td><a href="sucursal?id='+sucursal.id+'"><button class="btn"><i class="material-icons">input</i></button></a></td>'+
                                                      '</tr>';
                                                $('#filas').prepend(fila);
                                                $('#filaempty').hide();
                                                $("#nombre-agregar").val(null);
                                                $("#direccion-agregar").val(null);
                                                $("#telefono1-agregar").val(null);
                                                $("#telefono2-agregar").val(null);
                                            }
                                            $("#modal-"+modo).modal('close');
                                            $("#divbtn"+modo).html(btn);
                                        }
                                    }
                                    else{
                                        if(a.url==null){
                                            alerta(a.error,10000);
                                            $("#divbtn"+modo).html(btn);
                                        }else{
                                            window.location = a.url;
                                        }
                                    }
                                }
                            });
                        }else{
                            alerta("Elija un distrito");
                        }
                    }else{
                        alerta("Elija una zona");
                    }
                }else{
                    alerta("Elija un tipo de sucursal");
                }
            }else{
                alerta("Elija un tipo de territorio");
            }    
        }else{
            alerta("Escriba una direccion");
        }
    }else{
        alerta("Escriba un nombre");
    }
}


function modaleditarmodelo(id,nombre,tipo,marca){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#tiposequipo-editar').val(tipo).trigger('change');
    $('#marca-editar').val(marca).trigger('change');
    $('#lbl-nombre-editar').addClass('active');
}

function modelopost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var ok = true;
        var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        if(modo=="agregar"){
            var btn = '<button onclick="modelopost(\'agregar\')" class="btn-large">GRABAR</button>';
            var tipo = $('#tiposequipo-agregar').val();
            if(tipo==0){
                alerta("Elija un tipo de equipo");
                ok = false;
            }
        }else if(modo=="editar"){
            var btn = '<button onclick="modelopost(\'editar\')" class="btn-large">GRABAR</button>';
        }
        if(ok){
            $("#divbtn"+modo).html(cargando);
            var formData = $("#form"+modo).serialize();
            $.ajax({
                type: "POST",
                url: "modelo",
                data: formData,
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                        if(actualizarpagina){
                            window.location.reload();
                        }else{
                            var modelo = a.obj;
                            if(modo=="agregar"){
                                alerta("GUARDADO CORRECTAMENTE");
                                var fila = '';
                                fila = '<tr id="fila'+modelo.id+'">'+
                                        '<td id="filanombre'+modelo.id+'">'+modelo.nombre+'</td>'+
                                        '<td id="filatipo'+modelo.id+'">'+modelo.nombremarca+'</td>'+
                                        '<td id="filatipo'+modelo.id+'">'+modelo.nombretipo+'</td>'+
                                        '<td id="filaeditar'+modelo.id+'"><a onclick="modaleditarmodelo('+modelo.id+',\''+modelo.nombre+'\','+modelo.id_tipo_equipo+')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                        '<td><a onclick="modaleliminar(\'modelo\','+modelo.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                      '</tr>';
                                $('#filas').prepend(fila);
                                $('#filaempty').hide();
                                $("#nombre-agregar").val(null);
                            }else if(modo=="editar"){
                                alerta("EDITADO CORRECTAMENTE");
                                $('#filanombre'+modelo.id).html(modelo.nombre);
                                $('#filaeditar'+modelo.id).html('<a onclick="modaleditarmodelo('+modelo.id+',\''+modelo.nombre+'\','+modelo.id_tipo_equipo+','+modelo.id_marca+')" class="btn green"><i class="material-icons">edit</i></a>');
                            }
                            $("#modal-"+modo).modal('close');
                            $("#divbtn"+modo).html(btn);
                        }

                    }else{
                        if(a.url==null){
                            alerta(a.error,10000);
                            $("#divbtn"+modo).html(btn);
                        }else{
                            window.location = a.url;
                        }
                    }
                }
            });
        }
    }else{
        alerta("Ingrese un nombre");
    }
}

function tipoproveedor(){
    var tipo = $('#tipo-agregar').val();
    if(tipo==1){
        $('#divnacional1').show();
        $('#divnacional2').show();
        $('#divnacional3').show();
        $('#divpais').hide();
    }else{
        $('#divnacional1').hide();
        $('#divnacional2').hide();
        $('#divnacional3').hide();
        $('#divpais').show();
    }
}

function proveedorpost(modo){
    ok = false;
    var razon = $('#razon-agregar').val();
    if(razon.trim().length>0){
        var ruc = $('#ruc-agregar').val();
        if(ruc.trim().length>0){
            var correo = $('#correo-agregar').val();
            if(validarEmail(correo)){
                var tipo = $('#tipo-agregar').val();
                if(tipo==1){
                    var distrito = $('#distrito-agregar').val();
                    if(distrito>0){
                        ok = true;
                    }else{
                        alerta("Elija un distrito");
                    }
                }else{
                    var pais = $('#pais-agregar').val();
                    if(pais>0){
                        ok = true;
                    }else{
                        alerta("Elija un pais")
                    }
                }
            }else{
                alerta("Ingrese un correo");
            }
                
        }else{
            alerta("Ingrese el ruc");
        }
    }else{
        alerta("Ingrese la razón social");
    }
    
    if(ok){
        var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        var btn = '<button onclick="proveedorpost(\''+modo+'\')" class="btn-large">GRABAR</button>';
        $("#divbtn"+modo).html(cargando);
        var formData = $("#form"+modo).serialize();
        $.ajax({
            type: "POST",
            url: "proveedor",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(actualizarpagina){
                        window.location.reload();
                    }else{
                        var proveedor = a.obj;
                        if(modo=="agregar"){
                            alerta("GUARDADO CORRECTAMENTE");
                            var fila = '';
                            fila = '<tr id="fila'+proveedor.id+'">'+
                                    '<td id="filarazon'+proveedor.id+'">'+proveedor.razon+'</td>'+
                                    '<td><a href="contratos?id_proveedor='+proveedor.id+'" class="btn"><i class="material-icons">input</i></a></td>'+
                                    '<td><a href="tecnicos?id='+proveedor.id+'" class="btn green"><i class="material-icons">input</i></a></td>'+
                                    '<td><a onclick="verproveedor('+proveedor.id+')" class="btn brown"><i class="material-icons">input</i></a></td>'+
                                  '</tr>';
                            $('#filas').prepend(fila);
                            $('#filaempty').hide();
                            $('#razon-agregar').val(null);
                            $('#ruc-agregar').val(null);
                            $('#contacto-agregar').val(null);
                            $('#direccion-agregar').val(null);
                            $('#fijo-agregar').val(null);
                            $('#celular-agregar').val(null);
                            $('#correo-agregar').val(null);
                            $('#pagina-agregar').val(null);
                            $('#codigopostal-agregar').val(null);
                        }
                        $("#modal-"+modo).modal('close');
                        $("#divbtn"+modo).html(btn);
                    }
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $("#divbtn"+modo).html(btn);
                    }else{
                        window.location = a.url;
                    }
                }
            }
        });
    }
}


function modaleditararea(id,nombre,abreviatura){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#lbl-nombre-editar').addClass('active');
    $('#abreviatura-editar').val(abreviatura);
    $('#lbl-abreviatura-editar').addClass('active');
}

function areapost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var abreviatura = $('#abreviatura-'+modo).val();
        if(abreviatura.trim().length>0){
            var ok = true;
            var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
            if(modo=="agregar"){
                var btn = '<button onclick="areapost(\'agregar\')" class="btn-large">GRABAR</button>';
            }else if(modo=="editar"){
                var btn = '<button onclick="areapost(\'editar\')" class="btn-large">GRABAR</button>';
            }
            if(ok){
                $("#divbtn"+modo).html(cargando);
                var formData = $("#form"+modo).serialize();
                $.ajax({
                    type: "POST",
                    url: "area",
                    data: formData,
                    success: function(a) {
                        a = JSON.parse(a);
                        if(a.ok){
                            if(actualizarpagina){
                                window.location.reload();
                            }else{
                                var area = a.obj;
                                if(modo=="agregar"){
                                    alerta("GUARDADO CORRECTAMENTE");
                                    var fila = '';
                                    fila = '<tr id="fila'+area.id+'">'+
                                            '<td id="filanombre'+area.id+'">'+area.nombre+'</td>'+
                                            '<td id="filaabreviatura'+area.id+'">'+area.abreviatura+'</td>'+
                                            '<td id="filaeditar'+area.id+'"><a onclick="modaleditararea('+area.id+',\''+area.nombre+'\',\''+area.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                            '<td><a onclick="modaleliminar(\'area\','+area.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                          '</tr>';
                                    $('#filas').prepend(fila);
                                    $('#filaempty').hide();
                                    $("#nombre-agregar").val(null);
                                }else if(modo=="editar"){
                                    alerta("EDITADO CORRECTAMENTE");
                                    $('#filanombre'+area.id).html(area.nombre);
                                    $('#filaeditar'+area.id).html('<a onclick="modaleditararea('+area.id+',\''+area.nombre+'\',\''+area.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                                }
                                $("#modal-"+modo).modal('close');
                                $("#divbtn"+modo).html(btn);
                            }

                        }else{
                            if(a.url==null){
                                alerta(a.error,10000);
                                $("#divbtn"+modo).html(btn);
                            }else{
                                window.location = a.url;
                            }
                        }
                    }
                });
            }
        }else{
            alerta("Ingrese una abreviatura");
        }
    }else{
        alerta("Ingrese un nombre");
    }
}


function modaleditartipoterritorio(id,nombre,abreviatura){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#lbl-nombre-editar').addClass('active');
}

function tipoterritoriopost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        if(modo=="agregar"){
            var btn = '<button onclick="tipoterritoriopost(\'agregar\')" class="btn-large">GRABAR</button>';
        }else if(modo=="editar"){
            var btn = '<button onclick="tipoterritoriopost(\'editar\')" class="btn-large">GRABAR</button>';
        }
        $("#divbtn"+modo).html(cargando);
        var formData = $("#form"+modo).serialize();
        $.ajax({
            type: "POST",
            url: "tipoterritorio",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(actualizarpagina){
                        window.location.reload();
                    }else{
                        var tipoterritorio = a.obj;
                        if(modo=="agregar"){
                            alerta("GUARDADO CORRECTAMENTE");
                            var fila = '';
                            fila = '<tr id="fila'+tipoterritorio.id+'">'+
                                    '<td id="filanombre'+tipoterritorio.id+'">'+tipoterritorio.nombre+'</td>'+
                                    '<td id="filaeditar'+tipoterritorio.id+'"><a onclick="modaleditartipoterritorio('+tipoterritorio.id+',\''+tipoterritorio.nombre+'\',\''+tipoterritorio.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                    '<td><a onclick="modaleliminar(\'tipoterritorio\','+tipoterritorio.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                  '</tr>';
                            $('#filas').prepend(fila);
                            $('#filaempty').hide();
                            $("#nombre-agregar").val(null);
                        }else if(modo=="editar"){
                            alerta("EDITADO CORRECTAMENTE");
                            $('#filanombre'+tipoterritorio.id).html(tipoterritorio.nombre);
                            $('#filaeditar'+tipoterritorio.id).html('<a onclick="modaleditartipoterritorio('+tipoterritorio.id+',\''+tipoterritorio.nombre+'\',\''+tipoterritorio.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                        }
                        $("#modal-"+modo).modal('close');
                        $("#divbtn"+modo).html(btn);
                    }
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $("#divbtn"+modo).html(btn);
                    }else{
                        window.location = a.url;
                    }
                }
            }
        });
    }else{
        alerta("Ingrese un nombre");
    }
}


function modaleditartiposucursal(id,nombre,abreviatura){
    $('#modal-editar').modal('open');
    $('#id-editar').val(id);
    $('#nombre-editar').val(nombre);
    $('#lbl-nombre-editar').addClass('active');
}

function tiposucursalpost(modo){
    var nombre = $('#nombre-'+modo).val();
    if(nombre.trim().length>0){
        var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        if(modo=="agregar"){
            var btn = '<button onclick="tiposucursalpost(\'agregar\')" class="btn-large">GRABAR</button>';
        }else if(modo=="editar"){
            var btn = '<button onclick="tiposucursalpost(\'editar\')" class="btn-large">GRABAR</button>';
        }
        $("#divbtn"+modo).html(cargando);
        var formData = $("#form"+modo).serialize();
        $.ajax({
            type: "POST",
            url: "tiposucursal",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    if(actualizarpagina){
                        window.location.reload();
                    }else{
                        var tiposucursal = a.obj;
                        if(modo=="agregar"){
                            alerta("GUARDADO CORRECTAMENTE");
                            var fila = '';
                            fila = '<tr id="fila'+tiposucursal.id+'">'+
                                    '<td id="filanombre'+tiposucursal.id+'">'+tiposucursal.nombre+'</td>'+
                                    '<td id="filaeditar'+tiposucursal.id+'"><a onclick="modaleditartiposucursal('+tiposucursal.id+',\''+tiposucursal.nombre+'\',\''+tiposucursal.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a></td>'+
                                    '<td><a onclick="modaleliminar(\'tiposucursal\','+tiposucursal.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                  '</tr>';
                            $('#filas').prepend(fila);
                            $('#filaempty').hide();
                            $("#nombre-agregar").val(null);
                        }else if(modo=="editar"){
                            alerta("EDITADO CORRECTAMENTE");
                            $('#filanombre'+tiposucursal.id).html(tiposucursal.nombre);
                            $('#filaeditar'+tiposucursal.id).html('<a onclick="modaleditartiposucursal('+tiposucursal.id+',\''+tiposucursal.nombre+'\',\''+tiposucursal.abreviatura+'\')" class="btn green"><i class="material-icons">edit</i></a>');
                        }
                        $("#modal-"+modo).modal('close');
                        $("#divbtn"+modo).html(btn);
                    }
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                        $("#divbtn"+modo).html(btn);
                    }else{
                        window.location = a.url;
                    }
                }
            }
        });
    }else{
        alerta("Ingrese un nombre");
    }
}

function tecnicopost(){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var btn = '<button onclick="tecnicopost()" class="btn-large">GRABAR</button>';
    var nombre = $('#nombre-agregar').val();
    if(nombre.trim().length>0){
        var apellidos = $('#apellidos-agregar').val();
        if(apellidos.trim().length>0){
            $("#divbtnagregar").html(cargando);
            var formData = $("#formagregar").serialize();
            $.ajax({
                type: "POST",
                url: "tecnico",
                data: formData,
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                        if(actualizarpagina){
                            window.location.reload();
                        }else{
                            var tecnico = a.obj;
                            alerta("GUARDADO CORRECTAMENTE");
                            var fila = '';
                            fila = '<tr id="fila'+tecnico.id+'">'+
                                    '<td>'+tecnico.apellidos+' '+tecnico.nombre+'</td>'+
                                    '<td><a onclick="modaleliminar(\'tecnico\','+tecnico.id+')" class="btn red"><i class="material-icons">delete</i></a></td>'+
                                  '</tr>';
                            $('#filas').prepend(fila);
                            $('#filaempty').hide();
                            $("#nombre-agregar").val(null);
                            $("#apellidos-agregar").val(null);
                            $("#modal-agregar").modal('close');
                            $("#divbtnagregar").html(btn);
                        }
                    }else{
                        if(a.url==null){
                            alerta(a.error,10000);
                            $("#divbtnagregar").html(btn);
                        }else{
                            window.location = a.url;
                        }
                    }
                }
            });  

        }else{
            alerta("Ingrese los apellidos");
        }
    }else{
        alerta("Ingrese un nombre");
    }  
}

//-----------------------MANTENIMIENTOS----------------------//


//------------------------CONTRATO-----------------------//

function agregardetallecontrato(){
    var idproducto = $('#productos').val();
    if(idproducto>0){
        var cantidad = $('#cantidad').val();
        if(cantidad>0){
            var decimal = cantidad.toString();
            if(decimal.indexOf('.')<0){
                var nombreproducto = $('#producto'+idproducto).html();
                var obj = [idproducto,nombreproducto,cantidad];
                agregarfilacontrato(obj);
            }else{
                alerta("Ingrese una cantidad sin decimales");
            }
        }else{
            alerta("Ingrese una cantidad mayor a 0");
        }
    }else{
        alerta("Elija un producto");
    } 
}

function agregarfilacontrato(obj){
    eliminarfilacontrato(obj[0]);
    detalles[obj[0]] = (obj);
    var html = "<tr id='fila-"+obj[0]+"'>\n\
                <td>"+obj[1]+"</td>\n\
                <td>"+obj[2]+"</td>\n\
                <td><a class='btn red' onclick='eliminarfilacontrato("+obj[0]+")'><i class='material-icons'>delete</i></a></td>\n\
                ";
    $('#filas').append(html);
    $('#cantidad').val(null);
    $('#filaempty').remove();
}

function eliminarfilacontrato(idproducto){
    delete detalles[idproducto];
    $("#fila-"+idproducto).remove();
}


function registrarcontrato(){
    var numero = $('#numero').val();
    if(numero.trim().length>0){
        var idproveedor = $('#proveedores').val();
        if(idproveedor>0){
            var fecha = $('#inicio').val();
            if(fecha.length==10){
                var inicio = $('#inicio').val();
                if(inicio.length==10){
                    var fin = $('#fin').val();
                    if(fin.length==10){
                        if(fin>=inicio){
                            var formData = $("#formcontrato").serialize();
                            $.ajax({
                                type: "GET",
                                url: "contratopost",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(a) {
                                    a = JSON.parse(a);
                                    if(a.ok){
                                        window.location = "contrato-detalle?id="+a.contrato;
                                    }else{
                                        if(a.url==null){
                                            alerta(a.error,10000);
                                            $('#divbtnregistrar').html("<a onclick='registrarcontrato()' class='btn-large'>GUARDAR<i class='material-icons right'>save</i></a>");
                                        }else{
                                            window.location = a.url;
                                        }
                                    }
                                },beforeSend:function(){
                                    $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                                }
                            });
                        }else{
                            alerta("La fecha de fin del contrato es menor a la de inicio.")
                        }
                            
                    }else{
                        alerta("Ingrese la fecha de fin del contrato");
                    }
                }else{
                    alerta("Ingrese la fecha de inicio del contrato");
                }
            }else{
                alerta("Ingrese la fecha del contrato");
            }
        }else{
            alerta("Elija un proveedor");
        }
    }else{
        alerta("Ingrese el número de contrato");
    }
}


function registrarcontratodetalle(){
    $('#otrosinput').html(null);
    var cantidad = 0;
    var html = "";
    for(var key in detalles){
        var detalle = detalles[key];
        html += "<input type='hidden' name='idmodelos[]' value='"+detalle[0]+"'>"+
                "<input type='hidden' name='cantidades[]' value='"+detalle[2]+"'>"+
                "<input type='hidden' name='SLAs[]' value='"+detalle[3]+"'>"+
                "<input type='hidden' name='tiempos[]' value='"+detalle[4]+"'>";
        cantidad++;
    }        
    if(cantidad>0){
        $('#otrosinput').html(html);
        var formData = $("#formcontrato").serialize();
        $.ajax({
            type: "POST",
            url: "contrato-detalle",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    window.location = "contrato-sla?id="+a.contrato;
                }else{
                    if(a.contrato==null){
                        if(a.url==null){
                            alerta(a.error,10000);
                            $('#divbtnregistrar').html("<a onclick='registrarcontratodetalle()' class='btn-large'>GUARDAR<i class='material-icons right'>save</i></a>");
                        }else{
                            window.location = a.url;
                        }
                    }else{
                        window.location = "contrato?id="+a.contrato;
                    }
                }
            },beforeSend:function(){
                $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }else{
        alerta("Agregue al menos un producto al contrato");
    }
}

$(".inputserie").on("keyup",function(e){
   if(e.keyCode==13){
       var serie = $(this).val();
       var id = $(this).attr("data-href");
       if(serie.trim().length>0){
           $.ajax({
                type: "GET",
                url: "agregar-serie",
                data: {"id":id,"serie":serie},
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                       $('#estado'+id).html("<i class='material-icons green-text'>done</i>");
                       $("#serie"+id).prop("disabled",true);
                    }else{
                        if(a.url==null){
                            if(a.serie==null){
                                alerta(a.error,10000);
                                $('#estado'+id).html("<i class='material-icons red-text'>clear</i>");
                            }else{
                                alerta(a.error,10000);
                                $('#estado'+id).html("<i class='material-icons green-text'>done</i>");
                                $("#serie"+id).prop("disabled",true);
                                $("#serie"+id).val(a.serie);
                            }
                        }else{
                            window.location = a.url;
                        }
                    }
                },beforeSend:function(){
                    $('#estado'+id).html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                }
            });
       }else{
           alerta("Ingrese la serie");
       }
   } 
});

//------------------------CONTRATO-----------------------//

//------------------------COMPRA----------------------//


function agregardetallecompra(tipo){
    $('#modeloexcel').val(null);
    $('#cantidadexcel').val(null);
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<a onclick='agregardetallecompra("+tipo+")' class='btn red'><i class='material-icons'>add</i></a>";
    var idmodelo = $('#modelos').val();
    if(idmodelo>0){
        var cantidad = $('#cantidad').val();
        if(cantidad>0){
            var decimal = cantidad.toString();
            if(decimal.indexOf('.')<0){
                if(tipo==1){
                    $('#modeloexcel').val(idmodelo);
                    $('#cantidadexcel').val(cantidad);
                    var archivo = document.getElementById("excel");
                    var excel = archivo.files[0];
                    if(excel==undefined){
                        alerta("Ingrese un archivo");
                    }else{
                        if(excel.name.indexOf(".xlsx")!=-1){
                            var formData = new FormData($("#compraexcelform")[0]);
                            $.ajax({
                                type: "POST",
                                url: "compra-detalle",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(a) {
                                    $('#divbtnagregar'+tipo).html(boton);
                                    a = JSON.parse(a);
                                    if(a.ok){
                                       var lista = a.lista;
                                       detalles = lista;
                                       recargarfilascompra(lista);
                                    }else{
                                        if(a.errores!=null){
                                            mostrarerrorescompra(a.errores);
                                        }
                                        if(a.url!=null){
                                            window.location = a.url;
                                        }
                                    }
                                },beforeSend:function(){
                                    $('#divbtnagregar'+tipo).html(cargando);
                                }
                            });
                        }else{
                            alerta("Suba un archivo excel en formato .xlsx");
                        }
                    }
                }else if(tipo==2){
                    var serie = $('#seriemanual').val();
                    var token = document.getElementsByName("_token")[0].value;
                    var idmodelo = $('#modelos').val();
                    var cantidad = $('#cantidad').val();
                    if(serie.trim().length>0){
                        $.ajax({
                            type: "POST",
                            url: "compra-detalle",
                            data: {"serie":serie,"_token":token,"tipo":tipo,"modelo":idmodelo,"cantidad":cantidad},
                            success: function(a) {
                                $('#divbtnagregar'+tipo).html(boton);
                                a = JSON.parse(a);
                                if(a.ok){
                                    var lista = a.lista;
                                    detalles = lista;
                                    recargarfilascompra(lista);
                                }else{
                                    if(a.errores!=null){
                                        mostrarerrorescompra(a.errores);
                                    }
                                    if(a.url!=null){
                                            window.location = a.url;
                                    }
                                }
                            },beforeSend:function(){
                                $('#divbtnagregar'+tipo).html(cargando);
                            }
                        });
                    }else{
                        alerta("Ingrese una serie");
                    }
                }
            }else{
                alerta("Ingrese una cantidad entera");
            }
        }else{
            alerta("Ingrese la cantidad del producto a registrar");
        }
    }else{
        alerta("Elija un producto");
    }
}

function recargarfilascompra(lista){
    alerta("Se actualizó la tabla de series");
    var html = "";
    $.each(lista,function (key,modelo){
        html += "<tr>"+
                    "<td>"+modelo[1]+"</td>"+
                    "<td>"+modelo[3]+"</td>"+
                    "<td>"+modelo[2]+"</td>"+
                    "<td><button class='btn' onclick='vermodelocompra("+key+")'><i class='material-icons'>input</i></button></td>"+
                    "<td><div id='divbtneliminar4-"+key+"'><button class='btn red' onclick='eliminardetallecompra("+key+",null,4)'><i class='material-icons'>delete</i></button></div></td>"+
                "</tr>";
    });
    $('#filas').html(html);
}

function vermodelocompra(key){
    var modelo = detalles[key];
    var series = modelo[0];
    $('#nombre-producto').html(modelo[1]);
    $('#cantidad-series').html("CANTIDAD: "+modelo[2]);
    var html = "";
    $.each(series,function (serie,cantidad){
        html += "<tr>";
        if(cantidad>1){
            html += "<td>"+serie+" (REPETIDO "+cantidad+" veces)</td>";
        }else{
            html += "<td>"+serie+"</td>";
        }
        html += '<td><div id="divbtneliminar5-'+serie+'"><button class="btn red" onclick="eliminardetallecompra('+key+',\''+serie+'\',5)"><i class="material-icons">delete</i></button></div></td>'+
                '</tr>';
    });
    $('#modal-filas').html(html);
    $('#modal-series').modal("open");
}

function eliminardetallecompra(modelo,producto,tipo){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<button class='btn red' onclick='eliminardetallecompra("+modelo+","+producto+","+tipo+")'><i class='material-icons'>delete</i></button>";
    var token = document.getElementsByName("_token")[0].value;
    $.ajax({
        type: "POST",
        url: "compra-detalle",
        data: {"modelo":modelo,"producto":producto,"_token":token,"tipo":tipo},
        success: function(a) {
            if(tipo==4){
                $('#divbtneliminar'+tipo+'-'+modelo).html(boton);
            }else if(tipo==5){
                $('#divbtneliminar'+tipo+'-'+producto).html(boton);
            }
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.lista;
                detalles = lista;
                recargarfilascompra(lista);
                $('#modal-series').modal("close");
            }else{
                if(a.errores!=null){
                    mostrarerrorescompra(a.errores);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            if(tipo==4){
                $('#divbtneliminar'+tipo+'-'+modelo).html(cargando);
            }else if(tipo==5){
                $('#divbtneliminar'+tipo+'-'+producto).html(cargando);
            }
        }
    });
}

function mostrarerrorescompra(errores){
    var html = "";
    $.each(errores,function (key,error){
        html += "<tr>\n\
        <td>"+key+"</td>\n\
        \n\<td>"+error+"</td>\n\
        </tr>";
    });
    $('#modal-filas-errores').html(html);
    $('#modal-errores').modal("open");
}

function registrarcompra(){
    var numero = $('#numero').val();
    if(numero.trim().length>0){
        var idproveedor = $('#proveedores').val();
        if(idproveedor>0){
            var idsucursal = $('#sucursales').val();
            if(idsucursal>0){
                var fecha = $('#fecha').val();
                if(fecha.length==10){
                    var cantidad = 0;
                    var ok = true;
                    for(var key in detalles){
                        if(ok){
                            if(detalles[key][2]==detalles[key][3]){
                                cantidad++;
                            }else{
                                alerta("La cantidad del producto "+detalles[key][1]+" ("+detalles[key][3]+") no coinciden con la cantidad de series ("+detalles[key][2]+")",10000);
                                ok =false;
                                break;
                            }
                        }
                    }
                    if(ok){
                        if(cantidad>0){
                            var formData = $("#formcompra").serialize();
                            $.ajax({
                                type: "GET",
                                url: "comprapost",
                                data: formData,
                                success: function(a) {
                                    a = JSON.parse(a);
                                    if(a.ok){
                                        window.location = "compra?id="+a.compra;
                                    }else{
                                        if(a.contrato==null){
                                            if(a.url==null){
                                                alerta(a.error,15000);
                                                $('#divbtnregistrar').html("<a onclick='registrarcompra()' class='btn-large'>REGISTRAR<i class='material-icons right'>save</i></a>");
                                            }else{
                                                window.location = a.url;
                                            }
                                        }else{
                                            window.location = "contrato-detalle?id="+a.contrato;
                                        }
                                    }
                                },beforeSend:function(){
                                    $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                                }
                            });
                        }else{
                            alerta("Agregue al menos un producto");
                        }
                    }
                }else{
                    alerta("Ingrese una fecha");
                }
            }else{
                alerta("Elija una sucursal");
            }
        }else{
            alerta("Elija un proveedor");
        }
    }else{
        alerta("Ingrese el número de guia");
    }
}

//---------------------COMPRA-------------------//


//----------------------TRASLADOS------------------------//



function modalsucursaltraslado(){
    $('#modal-traslados').modal('open');
    $.ajax({
        type: "GET",
        url: "sucursales?modo=ajax",
        success: function(a) {
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.obj;
                var html = '<label for="sucursalmodaltraslados">SUCURSALES</label>'+
                            '<select id="sucursalmodaltraslados" name="sucursal" style="width: 100%;">'+
                            '<option value="0">ELIJA UNA SUCURSAL</option>';
                $.each(lista,function (key,sucursal){
                  html += "<option value='"+sucursal.id+"'>"+sucursal.nombre+"</option>";  
                });
                html += '</select>';
                $('#divmodalsucursaltraslado').html(html);
                $('#sucursalmodaltraslados').select2();
            }else{
                if(a.url==null){
                    alerta(a.error,10000);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            $('#divmodalsucursaltraslado').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

function buscarseriestraslado(){
    var tipo = $('#tiposequipo').val();
    var marca = $('#marcas').val();
    var modelo = $('#modelos').val();
    var origen = $('#origen').val();
    var boton = '<a onclick="buscarseriestraslado()" class="btn green"><i class="material-icons">search</i></a>';
    $.ajax({
        type: "GET",
        url: "series",
        data: {"modo":"ajax","id_tipo_equipo":tipo,"id_marca":marca,"id_modelo":modelo,"id_origen":origen},
        success: function(a) {
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.obj;
                var html = '<label>SERIES</label>'+
                            '<select id="series" style="width: 100%;">'+
                            '<option value="0">ELIJA UNA SERIE</option>';
                $.each(lista,function (key,producto){
                  html += "<option value='"+producto.id+"'>"+producto.serie+"</option>";  
                });
                html += '</select>';
                $('#divseries').html(html);
                $('#series').select2();
                $('#divbtnbuscar').html(boton);
            }else{
                if(a.url==null){
                    alerta(a.error,10000);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            $('#divbtnbuscar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            $('#divseries').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

function agregardetalletraslado(tipo){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<a onclick='agregardetalletraslado("+tipo+")' class='btn red'><i class='material-icons'>add</i></a>";
    if(tipo==1){
        var archivo = document.getElementById("excel");
        var excel = archivo.files[0];
        if(excel==undefined){
            alerta("Ingrese un archivo");
        }else{
            if(excel.name.indexOf(".xlsx")!=-1){
                var formData = new FormData($("#trasladoexcelform")[0]);
                $.ajax({
                    type: "POST",
                    url: "traslado-detalle",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(a) {
                        $('#divbtnagregar'+tipo).html(boton);
                        a = JSON.parse(a);
                        if(a.ok){
                           var lista = a.lista;
                           detalles = lista;
                           recargarfilastraslado(lista);
                        }else{
                            if(a.errores!=null){
                                mostrarerrorestraslado(a.errores);
                            }else{
                                window.location = a.url;
                            }
                        }
                    },beforeSend:function(){
                        $('#divbtnagregar'+tipo).html(cargando);
                    }
                });
            }else{
                alerta("Suba un archivo excel en formato .xlsx");
            }
        }
    }else if(tipo==2){
        var serie = $('#seriemanual').val();
        var origen = $('#origen').val();
        var token = document.getElementsByName("_token")[0].value;
        if(serie.trim().length>0){
            $.ajax({
                type: "POST",
                url: "traslado-detalle",
                data: {"serie":serie,"origen":origen,"_token":token,"tipo":tipo},
                success: function(a) {
                    $('#divbtnagregar'+tipo).html(boton);
                    a = JSON.parse(a);
                    if(a.ok){
                        var lista = a.lista;
                        detalles = lista;
                        recargarfilastraslado(lista);
                    }else{
                        if(a.errores!=null){
                            mostrarerrorestraslado(a.errores);
                        }else{
                            window.location = a.url;
                        }
                    }
                },beforeSend:function(){
                    $('#divbtnagregar'+tipo).html(cargando);
                }
            });
        }else{
            alerta("Ingrese una serie");
        }
    }else if(tipo==3){
        var idproducto = $('#series').val();
        var origen = $('#origen').val();
        var token = document.getElementsByName("_token")[0].value;
        if(idproducto>0){
            $.ajax({
                type: "POST",
                url: "traslado-detalle",
                data: {"id_producto":idproducto,"origen":origen,"_token":token,"tipo":tipo},
                success: function(a) {
                    $('#divbtnagregar'+tipo).html(boton);
                    a = JSON.parse(a);
                    if(a.ok){
                        var lista = a.lista;
                        detalles = lista;
                        recargarfilastraslado(lista);
                    }else{
                        if(a.errores!=null){
                            mostrarerrorestraslado(a.errores);
                        }else{
                            window.location = a.url;
                        }
                    }
                },beforeSend:function(){
                    $('#divbtnagregar'+tipo).html(cargando);
                }
            });
        }else{
            alerta("Elija una serie");
        }
    }
}

function recargarfilastraslado(lista){
    alerta("Se agregó las series al detalle");
    var html = "";
    $.each(lista,function (key,modelo){
        html += "<tr>"+
                    "<td>"+modelo[1]+"</td>"+
                    "<td>"+modelo[2]+"</td>"+
                    "<td><button class='btn' onclick='vermodelotraslado("+key+")'><i class='material-icons'>input</i></button></td>"+
                    "<td><div id='divbtneliminar4-"+key+"'><button class='btn red' onclick='eliminardetalletraslado("+key+",null,4)'><i class='material-icons'>delete</i></button></div></td>"+
                "</tr>";
    });
    $('#filas').html(html);
}

function vermodelotraslado(key){
    var modelo = detalles[key];
    var series = modelo[0];
    $('#nombre-producto').html(modelo[1]);
    $('#cantidad-series').html("CANTIDAD: "+modelo[2]);
    var html = "";
    $.each(series,function (id,serie){
        html += "<tr>\n\
        <td>"+serie+"</td>\n\
        \n\<td><div id='divbtneliminar5-"+id+"'><button class='btn red' onclick='eliminardetalletraslado("+key+","+id+",5)'><i class='material-icons'>delete</i></button></div></td>\n\
        </tr>";
    });
    $('#modal-filas').html(html);
    $('#modal-series').modal("open");
}

function eliminardetalletraslado(modelo,producto,tipo){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<button class='btn red' onclick='eliminardetalletraslado("+modelo+","+producto+","+tipo+")'><i class='material-icons'>delete</i></button>";
    var token = document.getElementsByName("_token")[0].value;
    $.ajax({
        type: "POST",
        url: "traslado-detalle",
        data: {"modelo":modelo,"producto":producto,"_token":token,"tipo":tipo},
        success: function(a) {
            if(tipo==4){
                $('#divbtneliminar'+tipo+'-'+modelo).html(boton);
            }else if(tipo==5){
                $('#divbtneliminar'+tipo+'-'+producto).html(boton);
            }
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.lista;
                detalles = lista;
                recargarfilastraslado(lista);
                $('#modal-series').modal("close");
            }else{
                if(a.errores!=null){
                    mostrarerrorestraslado(a.errores);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            if(tipo==4){
                $('#divbtneliminar'+tipo+'-'+modelo).html(cargando);
            }else if(tipo==5){
                $('#divbtneliminar'+tipo+'-'+producto).html(cargando);
            }
        }
    });
}

function mostrarerrorestraslado(errores){
    var html = "";
    $.each(errores,function (key,error){
        html += "<tr>\n\
        <td>"+key+"</td>\n\
        \n\<td>"+error+"</td>\n\
        </tr>";
    });
    $('#modal-filas-errores').html(html);
    $('#modal-errores').modal("open");
}

function registrartraslado(){
    var numero = $('#numero').val();
    if(numero.trim().length>0){
        var fecha = $('#fecha').val()
        if(fecha.length==10){
            var idsucursal = $('#sucursales').val();
            if(idsucursal>0){
                var motivo = $('#motivos').val();
                if(motivo>0){
                    var cantidad = 0;
                    var html = "";
                    for(var key in detalles){
                        cantidad++;
                    }        
                    if(cantidad>0){
                        var formData = $("#trasladoform").serialize();
                        $.ajax({
                            type: "POST",
                            url: "traslado",
                            data: formData,
                            success: function(a) {
                                a = JSON.parse(a);
                                if(a.ok){
                                    window.location = "traslado?id="+a.traslado;
                                }else{
                                    if(a.url==null){
                                        alerta(a.error,10000);
                                        $('#divbtnregistrar').html("<a onclick='registrartraslado()' class='btn-large'>GUARDAR<i class='material-icons right'>save</i></a>");
                                    }else{
                                        window.location = a.url;
                                    }
                                }
                            },beforeSend:function(){
                                $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                            }
                        });
                    }else{
                        alerta("Agregue al menos un producto al traslado");
                    }
                }else{
                    alerta("Elija un motivo");
                }
            }else{
                alerta("Elija una sucursal");
            }
        }else{
            alerta("Ingrese una fecha");
        }
    }else{
        alerta("Ingrese un número de traslado");
    }
}

$(".inputserietraslado").on("keyup",function(e){
   if(e.keyCode==13){
       var serie = $(this).val();
       var id = $(this).attr("data-href");
       if(serie.trim().length>0){
           $.ajax({
                type: "GET",
                url: "transladar-serie",
                data: {"id":id,"serie":serie},
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                       $('#estado'+id).html("<i class='material-icons green-text'>done</i>");
                       $("#serie"+id).prop("disabled",true);
                    }else{
                        if(a.url==null){
                            if(a.serie==null){
                                alerta(a.error,10000);
                                $('#estado'+id).html("<i class='material-icons red-text'>clear</i>");
                            }else{
                                alerta(a.error,10000);
                                $('#estado'+id).html("<i class='material-icons green-text'>done</i>");
                                $("#serie"+id).prop("disabled",true);
                                $("#serie"+id).val(a.serie);
                            }
                        }else{
                            window.location = a.url;
                        }
                    }
                },beforeSend:function(){
                    $('#estado'+id).html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                }
            });
       }else{
           alerta("Ingrese la serie");
       }
   } 
});


//------------------------TRASLADOS-------------------------//


//---------------------GUIAS-----------------------------//


function elegirproductodetalleguia(){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<a onclick='seriesexcel()' class='btn red'><i class='material-icons'>add</i></a>";
    $('#divbtnagregar').html(cargando);
    var idmodelo = $('#modelos').val();
    $('#restantes').val(null);
    $('#cantidad').val(null);
    if(idmodelo>0){
        var total = $('#modelo'+idmodelo).attr("data-href");
        if(total<0){
            $('#restantes').val(0);
        }else{
            $('#restantes').val(total);
        }
        $('#lbl-restantes').addClass("active");
    }
    $('#divbtnagregar').html(boton);
}

function agregardetalleguia(tipo){
    $('#modeloexcel').val(null);
    $('#cantidadexcel').val(null);
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<a onclick='agregardetalleguia("+tipo+")' class='btn red'><i class='material-icons'>add</i></a>";
    var idmodelo = $('#modelos').val();
    if(idmodelo>0){
        var cantidad = $('#cantidad').val();
        if(cantidad>0){
            var decimal = cantidad.toString();
            if(decimal.indexOf('.')<0){
                if(tipo==1){
                    $('#modeloexcel').val(idmodelo);
                    $('#cantidadexcel').val(cantidad);
                    var archivo = document.getElementById("excel");
                    var excel = archivo.files[0];
                    if(excel==undefined){
                        alerta("Ingrese un archivo");
                    }else{
                        if(excel.name.indexOf(".xlsx")!=-1){
                            var formData = new FormData($("#guiaexcelform")[0]);
                            $.ajax({
                                type: "POST",
                                url: "guia-detalle",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(a) {
                                    $('#divbtnagregar'+tipo).html(boton);
                                    a = JSON.parse(a);
                                    if(a.ok){
                                       var lista = a.lista;
                                       detalles = lista;
                                       recargarfilasguia(lista);
                                    }else{
                                        if(a.errores!=null){
                                            mostrarerroresguia(a.errores);
                                        }
                                        if(a.url!=null){
                                            window.location = a.url;
                                        }
                                    }
                                },beforeSend:function(){
                                    $('#divbtnagregar'+tipo).html(cargando);
                                }
                            });
                        }else{
                            alerta("Suba un archivo excel en formato .xlsx");
                        }
                    }
                }else if(tipo==2){
                    var serie = $('#seriemanual').val();
                    var origen = $('#origen').val();
                    var token = document.getElementsByName("_token")[0].value;
                    var idmodelo = $('#modelos').val();
                    var cantidad = $('#cantidad').val();
                    var contrato = $('#id-contrato').val();
                    if(serie.trim().length>0){
                        $.ajax({
                            type: "POST",
                            url: "guia-detalle",
                            data: {"serie":serie,"origen":origen,"_token":token,"tipo":tipo,"modelo":idmodelo,"cantidad":cantidad,"contrato":contrato},
                            success: function(a) {
                                $('#divbtnagregar'+tipo).html(boton);
                                a = JSON.parse(a);
                                if(a.ok){
                                    var lista = a.lista;
                                    detalles = lista;
                                    recargarfilasguia(lista);
                                }else{
                                    if(a.errores!=null){
                                        mostrarerroresguia(a.errores);
                                    }
                                    if(a.url!=null){
                                            window.location = a.url;
                                    }
                                }
                            },beforeSend:function(){
                                $('#divbtnagregar'+tipo).html(cargando);
                            }
                        });
                    }else{
                        alerta("Ingrese una serie");
                    }
                }
            }else{
                alerta("Ingrese una cantidad entera");
            }
        }else{
            alerta("Ingrese la cantidad del producto a registrar");
        }
    }else{
        alerta("Elija un producto");
    }
}

function recargarfilasguia(lista){
    alerta("Se actualizó la tabla de series");
    var html = "";
    $.each(lista,function (key,modelo){
        html += "<tr>"+
                    "<td>"+modelo[1]+"</td>"+
                    "<td>"+modelo[3]+"</td>"+
                    "<td>"+modelo[2]+"</td>"+
                    "<td><button class='btn' onclick='vermodeloguia("+key+")'><i class='material-icons'>input</i></button></td>"+
                    "<td><div id='divbtneliminar4-"+key+"'><button class='btn red' onclick='eliminardetalleguia("+key+",null,4)'><i class='material-icons'>delete</i></button></div></td>"+
                "</tr>";
    });
    $('#filas').html(html);
}

function vermodeloguia(key){
    var modelo = detalles[key];
    var series = modelo[0];
    $('#nombre-producto').html(modelo[1]);
    $('#cantidad-series').html("CANTIDAD: "+modelo[2]);
    var html = "";
    $.each(series,function (serie,cantidad){
        html += "<tr>";
        if(cantidad>1){
            html += "<td>"+serie+" (REPETIDO "+cantidad+" veces)</td>";
        }else{
            html += "<td>"+serie+"</td>";
        }
        html += '<td><div id="divbtneliminar5-'+serie+'"><button class="btn red" onclick="eliminardetallecompra('+key+',\''+serie+'\',5)"><i class="material-icons">delete</i></button></div></td>'+
                '</tr>';
    });
    $('#modal-filas').html(html);
    $('#modal-series').modal("open");
}

function eliminardetalleguia(modelo,producto,tipo){
    var cargando = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var boton = "<button class='btn red' onclick='eliminardetalleguia("+modelo+","+producto+","+tipo+")'><i class='material-icons'>delete</i></button>";
    var token = document.getElementsByName("_token")[0].value;
    $.ajax({
        type: "POST",
        url: "guia-detalle",
        data: {"modelo":modelo,"producto":producto,"_token":token,"tipo":tipo},
        success: function(a) {
            if(tipo==4){
                $('#divbtneliminar'+tipo+'-'+modelo).html(boton);
            }else if(tipo==5){
                $('#divbtneliminar'+tipo+'-'+producto).html(boton);
            }
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.lista;
                detalles = lista;
                recargarfilasguia(lista);
                $('#modal-series').modal("close");
            }else{
                if(a.errores!=null){
                    mostrarerroresguia(a.errores);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            if(tipo==4){
                $('#divbtneliminar'+tipo+'-'+modelo).html(cargando);
            }else if(tipo==5){
                $('#divbtneliminar'+tipo+'-'+producto).html(cargando);
            }
        }
    });
}

function mostrarerroresguia(errores){
    var html = "";
    $.each(errores,function (key,error){
        html += "<tr>\n\
        <td>"+key+"</td>\n\
        \n\<td>"+error+"</td>\n\
        </tr>";
    });
    $('#modal-filas-errores').html(html);
    $('#modal-errores').modal("open");
}

function registrarguia(){
    var numero = $('#numero').val();
    if(numero.trim().length>0){
        var idsucursal = $('#sucursales').val();
        if(idsucursal>0){
            var fecha = $('#fecha').val();
            if(fecha.length==10){
                var cantidad = 0;
                var ok = true;
                for(var key in detalles){
                    if(ok){
                        if(detalles[key][2]==detalles[key][3]){
                            cantidad++;
                        }else{
                            alerta("La cantidad del producto "+detalles[key][1]+" ("+detalles[key][3]+") no coinciden con la cantidad de series ("+detalles[key][2]+")",10000);
                            ok =false;
                            break;
                        }
                    }
                }
                if(ok){
                    if(cantidad>0){
                        var formData = $("#formguia").serialize();
                        $.ajax({
                            type: "GET",
                            url: "guiapost",
                            data: formData,
                            success: function(a) {
                                a = JSON.parse(a);
                                if(a.ok){
                                    window.location = "guia?id="+a.guia;
                                }else{
                                    if(a.contrato==null){
                                        if(a.url==null){
                                            alerta(a.error,15000);
                                            $('#divbtnregistrar').html("<a onclick='registrarguia()' class='btn-large'>REGISTRAR<i class='material-icons right'>save</i></a>");
                                        }else{
                                            window.location = a.url;
                                        }
                                    }else{
                                        window.location = "contrato-detalle?id="+a.contrato;
                                    }
                                }
                            },beforeSend:function(){
                                $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                            }
                        });
                    }else{
                        alerta("Agregue al menos un producto");
                    }
                }
            }else{
                alerta("Ingrese una fecha");
            }
        }else{
            alerta("Elija una sucursal");
        }
    }else{
        alerta("Ingrese el número de guia");
    }
}

//---------------------GUIAS-----------------------------//



//-------------------------CASOS------------------//
function seriessucursal(){
    var sucursal = $('#sucursales').val();
    if(sucursal>=0){
        $.ajax({
            type: "GET",
            url: "series",
            data: {"modo":"ajax","id_origen":sucursal},
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    var lista = a.obj;
                    var html = '<label>SERIES</label>'+
                                '<select id="serie-caso" name="serie" style="width: 100%;" onchange="seleccionarseriecaso()">'+
                                '<option value="0">ELIJA UNA SERIE</option>';
                    $.each(lista,function (key,producto){
                      html += "<option value='"+producto.serie+"'>"+producto.serie+"</option>";  
                    });
                    html += '</select>';
                    $('#divseries').html(html);
                    $('#serie-caso').select2();
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#divseries').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }
}


function seleccionarseriecaso(){
    var serie = $('#serie-caso').val();
    if(serie.trim().length>0){
        $.ajax({
             type: "GET",
             url: "caso-serie",
             data: {"serie":serie},
             success: function(a) {
                 a = JSON.parse(a);
                 if(a.ok){
                    $('#estado-serie-caso').html("<i class='material-icons green-text'>done</i>");
                    var serie = a.obj;
                    $('#id-serie').val(serie.id);
                    $('#sla-serie').val(serie.sla);
                    $('#marca').html(serie.nombretipoequipo+" "+serie.nombremarca+" "+serie.nombremodelo);
                    $('#sucursal').html(serie.nombresucursal);
                    if(serie.nombrearea==null){
                     $('#area').html("SIN ÁREA ASIGNADA");   
                    }else{
                     $('#area').html(serie.nombrearea);
                    }
                    $('#proveedor').html(serie.nombreproveedor);
                    if(serie.tipocontrato=="C"){
                        $('#contrato').html(serie.numero);
                        $('#sla').html(serie.sla+" horas");
                    }else{
                        $('#contrato').html("SIN CONTRATO");
                        $('#sla').html("SIN SLA");
                    }
                    $('#detalle-serie-caso').show();
                    if(serie.tipocontrato=="C"){
                        $('#info-caso').show();
                    }else{
                        $('#info-caso').hide();
                    }
                 }else{
                     $('#estado-serie-caso').html("<i class='material-icons red-text'>clear</i>");
                     if(a.url==null){
                         alerta(a.error);
                     }else{
                         window.location = a.url;
                     }
                 }
             },beforeSend:function(){
                 $('#id-serie').val(null);
                 $('#detalle-serie-caso').hide();
                 $('#estado-serie-caso').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
             }
         });
    }
}

function generarcaso(){
    var id = $('#id-serie').val();
    if(id>0){
        var usuario = $('#usuario').val();
        if(usuario.trim().length>0){
            var celular = $('#celular').val();
            var anexo = $('#anexo').val();
            var correo = $('#correo').val();
            if(celular.trim().length>0 || anexo.trim().length>0 || (correo.trim().length>0 && validarEmail(correo))){
                var problema = $('#problema').val();
                if(problema.trim().length>0){
                    $('#btngenerarcaso').prop("disabled",true);
                    var formData = $("#formcaso").serialize();
                    $.ajax({
                        type: "POST",
                        url: "caso",
                        data: formData,
                        success: function(a) {
                            a = JSON.parse(a);
                            if(a.ok){
                               window.location = "caso?id="+a.caso;
                            }else{
                                if(a.url==null){
                                    alerta(a.error);
                                    $('#btngenerarcaso').html('<a class="btn" onclick="generarcaso()">GENERAR CASO</a>');
                                }else{
                                    window.location = a.url;
                                }
                            }
                        },beforeSend:function(){
                            $('#btngenerarcaso').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                        }
                    });
                }else{
                    alerta("Ingrese el problema");
                }
            }else{
                alerta("Ingrese un celular, anexo o correo");
            }
        }else{
            alerta("Ingrese el usuario");
        }
    }else{
        alerta("Elija la serie");
    }
}


function asignartecnico(){
    var tecnico = $('#tecnico').val();
    var boton = '<a onclick="asignartecnico()" class="btn">ASIGNAR</a>';
    if(tecnico>0){
        var formData = $("#asignartecnico").serialize();
        $.ajax({
            type: "POST",
            url: "caso-asignartecnico",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    window.location = "caso?id="+a.caso;
                }else{
                    if(a.url==null){
                        alerta(a.error,15000);
                        $('#divbtnregistrar').html(boton);
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }else{
        alerta("Elija un técnico");
    }
}

function elegirtipocaso(){
    $('#id-producto').val(null);
    var tipo = $('#tipocaso').val();
    $('#info-producto').hide();
    if(tipo==4){
        $('#divsolucion').show();
    }else{
        $('#divsolucion').hide();
        $('#tiposolucion').val(0);
        $('#tiposolucion').material_select('destroy');
        $('#tiposolucion').material_select();
        $('#divserie').hide();
    }
}

function elegirtiposolucion(){
    $('#id-producto').val(null);
    var tipo = $('#tiposolucion').val();
    $('#info-producto').hide();
    if(tipo==2){
        $('#divserie').show();
    }else{
        $('#divserie').hide();
    }
}

function buscarseriecaso(){
    $('#id-producto').val(null);
    var serie = $('#serie').val();
    if(serie.trim().length>0){
        $.ajax({
                type: "GET",
                url: "caso-serie",
                data: {"serie":serie},
                success: function(a) {
                    a = JSON.parse(a);
                    $('#btnbuscar').html('<a class="btn green" onclick="buscarseriecaso()"><i class="material-icons">search</i></a>');
                    if(a.ok){
                       var serie = a.obj;
                       $('#id-producto').val(serie.id);
                       var info = "<p>Producto a reemplazar: "+$('#nombreproducto').val()+"</p>";
                        info += "<p>Serie encontrada: "+serie.nombretipoequipo+" "+serie.nombremarca+" "+serie.nombremodelo+"</p>"+
                                    "<p>Sucursal: "+serie.nombresucursal+"</p>"+
                                    "<p>Proveedor: "+serie.nombreproveedor+"</p>";
                       if(serie.tipocontrato=="C"){
                           info += "<p>Contrato: "+serie.numero+"</p>";
                       }else{
                           info += "<p>Contrato: Sin contrato (Compra)";
                       }
                       $('#info-producto').html(info);
                       $('#info-producto').show();
                    }else{
                        $('#info-producto').hide();
                        if(a.url==null){
                            alerta(a.error);
                        }else{
                            window.location = a.url;
                        }
                    }
                },beforeSend:function(){
                    $('#btnbuscar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                }
            });
    }else{
        alerta("Ingrese una serie");
    }
}

function elegirtiposucursal(){
    var tipo = $('#tiposucursal').val();
    if(tipo>0){
        $.ajax({
            type: "GET",
            url: "sucursales",
            data: {"modo":"ajax","tipo":tipo},
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    var lista = a.obj;
                    var html = '<label>SUCURSALES</label>'+
                                '<select id="sucursales" style="width: 100%;">'+
                                '<option value="0">ELIJA UNA SUCURSAL</option>';
                    $.each(lista,function (key,sucursal){
                      html += "<option value='"+sucursal.id+"' id='optsucursal"+sucursal.id+"'>"+sucursal.nombre+"</option>";  
                    });
                    html += '</select>';
                    $('#divsucursales').html(html);
                    $('#sucursales').select2();
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#divsucursales').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }
}

function buscarseriescambio(){
    var sucursal = $('#sucursales').val();
    if(sucursal>0){
        var tipomodelo = $('#tipomodelo').val();
        var contrato = $('#contrato-id').val();
        $.ajax({
            type: "GET",
            url: "series",
            data: {"modo":"ajax","id_origen":sucursal,"contrato":contrato,"tipomodelo":tipomodelo,"ocasion":"caso"},
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    var lista = a.obj;
                    var html = "<tr><td colspan='3' class='center'>SIN ÁREA ASIGNADA</td></tr>";
                    var asignados = "";
                    var noasignados = "";
                    $.each(lista,function (key,producto){
                      if(producto.nombrearea!=null){
                          asignados +=  "<tr><td>"+producto.nombremarca+" "+producto.nombremodelo+"</td><td>"+producto.serie+"</td>";
                          asignados += "<td>"+producto.nombrearea+"</td></tr>"
                      }else{
                          noasignados +=  "<tr><td>"+producto.nombremarca+" "+producto.nombremodelo+"</td><td>"+producto.serie+"</td>";
                          noasignados += "<td>-</td></tr>"
                      }
                    });
                    html = "<tr><td colspan='3' class='center blue white-text'>SIN ÁREA ASIGNADA</td></tr>"+
                            noasignados+
                            "<tr><td colspan='3' class='center blue white-text'>CON ÁREA ASIGNADA</td></tr>"+
                            asignados;
                    $('#modal-filas').html(html);
                    $('#modal-series').modal('open');
                    $('#sucursal-temporal').val(sucursal);
                }else{
                    if(a.url==null){
                        alerta(a.error,10000);
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#modal-filas').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }else{
        alerta("Elija una sucursal");
    }
}

function solicitarseriecaso(){
    var sucursal = $('#sucursal-temporal').val();
    $('#sucursal-solicitar').val(sucursal);
    var nombresucursal = $('#optsucursal'+sucursal).html();
    $('#txtsucursalsolicitar').val(nombresucursal);
    $('#lblsucursalsolicitar').addClass('active');
    $('#divsucursalsolicitar').show();
    
}

function detallecaso(){
    var tipo = $('#tipocaso').val();
    var ok = false;
    var boton = '<a onclick="detallecaso()" class="btn">GUARDAR</a>';
    var analisis = $('#analisis').val();
    if(analisis.trim().length>0){
        var conclusion = $('#conclusion').val();
        if(conclusion.trim().length>0){
            if(tipo>0){
                if(tipo==4){
                    var tipo2 = $('#tiposolucion').val();
                    if(tipo2>0){
                        if(tipo2==2){
                            var sucursal = $('#sucursal-solicitar').val();
                            if(sucursal>0){
                                ok = true;
                            }else{
                                alerta("Elija una sucursal a solicitar reemplazo");
                            }
                        }else{
                            ok = true;
                        }
                    }else{
                        alerta("Elija una solución");
                    }
                }else{
                    ok = true;
                }
            }else{
                alerta("Elija un tipo de caso");
            }
        }else{
            alerta("Ingrese la conclusión");
        }
    }else{
        alerta("Ingrese el análisis");
    }
    
    if(ok){
        var formData = $("#detallecaso").serialize();
        $.ajax({
            type: "POST",
            url: "caso-detalle",
            data: formData,
            success: function(a) {
                a = JSON.parse(a);
                if(a.ok){
                    window.location = "caso?id="+a.caso;
                }else{
                    if(a.url==null){
                        alerta(a.error,15000);
                        $('#divbtnregistrar').html(boton);
                    }else{
                        window.location = a.url;
                    }
                }
            },beforeSend:function(){
                $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            }
        });
    }
}

function buscarseriestraslado(){
    var tipo = $('#tiposequipo').val();
    var marca = $('#marcas').val();
    var modelo = $('#modelos').val();
    var origen = $('#origen').val();
    var actual = $('#actual').val();
    console.log(origen);
    var boton = '<a onclick="buscarseriestraslado()" class="btn green"><i class="material-icons">search</i></a>';
    $.ajax({
        type: "GET",
        url: "series",
        data: {"modo":"ajax","id_tipo_equipo":tipo,"id_marca":marca,"id_modelo":modelo,"id_origen":origen},
        success: function(a) {
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.obj;
                var html = '<label>SERIES</label>'+
                            '<select id="series" style="width: 100%;" onchange="elegirserietrasladocaso()">'+
                            '<option value="0">ELIJA UNA SERIE</option>';
                $.each(lista,function (key,producto){
                  if(actual!=null){
                    if(producto.id!=actual){
                      html += "<option value='"+producto.id+"'>"+producto.serie+"</option>";    
                    }  
                  }else{
                      html += "<option value='"+producto.id+"'>"+producto.serie+"</option>";    
                  }
                });
                html += '</select>';
                $('#divseries').html(html);
                $('#series').select2();
                $('#divbtnbuscar').html(boton);
            }else{
                if(a.url==null){
                    alerta(a.error,10000);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            $('#divbtnbuscar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
            $('#divseries').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

function elegirserietrasladocaso(){
    var serie = $('#series').val();
    $('#serie-trasladar').val(serie);
}


function registrartrasladocaso(){
    var numero = $('#numero').val();
    if(numero.trim().length>0){
        var fecha = $('#fecha').val()
        if(fecha.length==10){
            var idsucursal = $('#origen').val();
            if(idsucursal>0){
                var motivo = $('#motivos').val();
                if(motivo>0){
                    var serie = $('#series').val();
                    if(serie>0){
                        var formData = $("#trasladoform").serialize();
                        $.ajax({
                            type: "POST",
                            url: "caso-traslado",
                            data: formData,
                            success: function(a) {
                                a = JSON.parse(a);
                                if(a.ok){
                                    window.location = "traslado?id="+a.traslado;
                                }else{
                                    if(a.url==null){
                                        alerta(a.error,10000);
                                        $('#divbtnregistrar').html("<a onclick='registrartraslado()' class='btn-large'>GUARDAR<i class='material-icons right'>save</i></a>");
                                    }else{
                                        window.location = a.url;
                                    }
                                }
                            },beforeSend:function(){
                                $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                            }
                        });
                    }else{
                        alerta("Elija la serie");
                    }
                }else{
                    alerta("Elija un motivo");
                }
            }else{
                alerta("Elija una sucursal");
            }
        }else{
            alerta("Ingrese una fecha");
        }
    }else{
        alerta("Ingrese un número de guia de remisión");
    }
}

function tipoeleccionreemplazo(){
    var tipo = $('#tipoeleccion').val();
    if(tipo==1){
        $('#otrasucursal').show();
        $('#mismasucursal').hide();
    }else if(tipo==2){
        $('#otrasucursal').hide();
        $('#mismasucursal').show();
    }
}

function elegirseriereemplazo(){
    var serie = $('#series').val();
    var caso = $('#caso').val();
    if(serie>0){
        if(caso!=null){
            $.ajax({
                type: "GET",
                url: "caso-serie-reemplazo",
                data: {"serie":serie,"caso":caso},
                success: function(a) {
                    a = JSON.parse(a);
                    if(a.ok){
                        window.location = "caso?id="+a.caso;
                    }else{
                        if(a.url==null){
                            alerta(a.error,10000);
                            $('#divbtnregistrar').html("<a onclick='elegirseriereemplazo()' class='btn-large'>GUARDAR<i class='material-icons right'>save</i></a>");
                        }else{
                            window.location = a.url;
                        }
                    }
                },beforeSend:function(){
                    $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
                }
            });
        }else{
            alerta("Ha ocurrido un error");
        }
    }else{
        alerta("Elija una serie");
    }
}

function fincaso(){
    var formData = $("#fincaso").serialize();
    $.ajax({
        type: "POST",
        url: "caso-fin",
        data: formData,
        success: function(a) {
            a = JSON.parse(a);
            if(a.ok){
                window.location = "caso?id="+a.caso;
            }else{
                if(a.url==null){
                    alerta(a.error,15000);
                    $('#divbtnregistrar').html(boton);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            $('#divbtnregistrar').html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

//------------------------CASOS---------------------------------//



//---------------------------REPORTES--------------------//

function reportelistarsucursales(id){
    var tipo = $('#tipossucursal'+id).val();
    var territorio = $('#tiposterritorio'+id).val();
    $.ajax({
        type: "GET",
        url: "sucursales",
        data: {"modo":"ajax","tipo":tipo,"territorio":territorio},
        success: function(a) {
            a = JSON.parse(a);
            if(a.ok){
                var lista = a.obj;
                var html = '<label>SUCURSALES</label>'+
                            '<select name="sucursal" id="sucursales'+id+'" style="width: 100%;">';
                if(lista.length>0){
                    html += '<option value="0">TODAS</option>';
                    $.each(lista,function (key,sucursal){
                      html += "<option value='"+sucursal.id+"'>"+sucursal.nombre+"</option>";  
                    });
                }else{
                    html += '<option value="0">NO HAY SUCURSALES</option>';
                }
                    
                html += '</select>';
                $('#divsucursales'+id).html(html);
                $('#sucursales'+id).select2();
            }else{
                if(a.url==null){
                    alerta(a.error,10000);
                }else{
                    window.location = a.url;
                }
            }
        },beforeSend:function(){
            $('#divsucursales'+id).html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

function reportelistarmodelos(id){
    var marca = $('#marcas'+id).val();
    var tipo = $('#tiposequipo'+id).val();
    $.ajax({
        type: "GET",
        url: "modelos",
        data: {"modo":"ajax","id_marca":marca,"id_tipo_equipo":tipo},
        success: function(a) {
            a = JSON.parse(a);
            var modelos = a.obj;
            var html = '<label>PRODUCTOS</label>\n\
                    <select  id="modelos'+id+'" style="width: 100%;">';
            if(modelos.length>0){
                html += '<option value="0">TODOS</option>';
                $.each(modelos,function (key,modelo){
                  html += "<option value='"+modelo.id+"'>"+modelo.nombre+"</option>";  
                });
            }else{
                html += '<option value="0">NO HAY MODELOS</option>';
            }
            html += "</select>"
            $('#divmodelos'+id).html(html);
            $('#modelos'+id).select2();
        },beforeSend:function(){
            $("#divmodelos"+id).html("<div class='row center'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-blue'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-red'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-yellow'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div><div class='spinner-layer spinner-green'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>");
        }
    });
}

function reporte(id){
    var formData = $("#reporte"+id).serialize();
    window.open("reporte?"+formData);
}