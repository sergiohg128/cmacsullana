
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