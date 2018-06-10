
function alerta(texto,tiempo,modo,funcion){
    if(tiempo==null){
        tiempo=((texto.length)/8)*1000;
    }
    if(modo==null){
        modo="";
    }
    if(funcion==null){
        funcion = function(){};
    }
    if(tiempo<5000){
        tiempo = 5000;
    }console.log(texto);
    Materialize.toast(texto, tiempo,modo,funcion);
}

function AlertaEliminar(contenido,url,parametros,ejecutar){
    alertaToast("ADVERTENCIA",contenido,"enviarURL('"+url+"','"+parametros+"','"+ejecutar+"');");
}

function AlertaForm(formulario,contenido,fnCancelar,fnValidacion){
    if(fnCancelar==null){
        fnCancelar = "";
    }
    if(fnValidacion==null){
        fnValidacion = $("#"+formulario).attr("validation-function");
    }
    alertaToast("ADVERTENCIA",contenido,fnValidacion,fnCancelar);
}

function AlertaFuncion(contenido,funcion){
    alertaToast("ADVERTENCIA",contenido,funcion);
}

var timeToast = 300000;

function cerrarToast(toast){
    $(toast).fadeOut(1000);
    setTimeout(function (){ 
        $(toast).remove();
        if($("#toast-container").children().length==0){$("#toast-container").removeClass("z-depth-5");}
    },500);
}

function mensajeToast(titulo,contenido){
    if(titulo.toString().length==0){
        titulo = "INFORMACION";
    }
    var temp = contenido;
    try{
        contenido = decodeURIComponent(contenido);
    } catch (e) {
        console.log(e);
        contenido = temp;
    }
    Materialize.toast('<div class="" style="width:100%;"><div class="row toastHeader"><h2>'+titulo+'</h2></div><div class="row toastContent"><div class="col s12"><p class="center">'+contenido+'</p></div><div class="col s12 center"><div class="col s12"><div class="center"><button class="btn btnToastAceptar" onclick="cerrarToast($(this).parent().parent().parent().parent().parent().parent());">ACEPTAR</button></div></div></div></div></div>', timeToast, '', 'if($("#toast-container").children().length==0){$("#toast-container").removeClass("z-depth-5");}');
    $(".toast").each(function(key,val){
        $(val).css("padding","0px");
        $(val).css("width","100%");
        $(val).addClass("z-depth-5");
    });
    $("#toast-container").css("display","block");
    $("#toast-container").removeClass("z-depth-5");
    $("#toast-container").addClass("z-depth-5");
}

function alertaToast(titulo,contenido,funcion,funcionCancelar){
    if(funcionCancelar==null){
        funcionCancelar = "";
    }
    contenido = decodeURIComponent(contenido);
    Materialize.toast('<div class="" style="width:100%;"><div class="row toastHeader"><h2>'+titulo+'</h2></div><div class="row toastContent"><div class="col s12"><p class="center">'+contenido+'</p></div><div class="col s12 center"><div class="col s6"><div class=""><button class="btn btnToastAceptar" onclick="$(this).parent().parent().parent().parent().parent().parent().remove();'+funcion+'">ACEPTAR</button></div></div><div class="col s6"><div class=""><button class="btn btnToastCancelar" onclick="cerrarToast($(this).parent().parent().parent().parent().parent().parent());'+funcionCancelar+'">CANCELAR</button></div></div></div></div></div>', timeToast, '', 'if($("#toast-container").children().length==0){$("#toast-container").removeClass("z-depth-5");}');
    $(".toast").each(function(key,val){
        $(val).css("padding","0px");
        $(val).css("width","100%");
        $(val).addClass("z-depth-5");
    });
    $("#toast-container").css("display","block");
    $("#toast-container").removeClass("z-depth-5");
    $("#toast-container").addClass("z-depth-5");
}

var cargando = '<div class="loader"></div>';

function enviarForm(form,button){
    //var boton = $("#"+button).html();
    //$("#"+button).html(cargando);
    $("#"+button).prop("disabled",true);
    var formData = new FormData(document.getElementById(form));
    var ajax_function = $.ajax({
        /*async:true,    
        cache:false,
        contentType: false,
        processData: false,
        type: 'POST',
        url: $("#"+form).attr("action"),
        data: $("#"+form).serialize(),*/
        type: "POST",
        url: $("#"+form).attr("action"),
        data: formData,
        contentType:false,
        processData: false,
        cache:false,
        success: function (data, textStatus, jqXHR) {
            try {
                var json = JSON.parse(data);
                var correcto = json.correcto;
                if(json.url==null){
                    json.url="";
                }
                if(json.vista==null){
                    json.vista="";
                }
                var url = json.url.toString();
                if(!correcto){
                    mensajeToast('ERROR',json.error);
                }else{
                    if(json.mensaje!=null && json.mensaje.toString().trim().length>0){
                        mensajeToast('',json.mensaje);
                    }
                }
                var ejecutar = json.ejecutar;
                if(ejecutar!=null && ejecutar.toString().trim().length>0){
                    eval(ejecutar);
                }
                if(url.trim().length>0){
                    window.location = url;
                }else{
                    var vista = json.vista;
                    var parametros = json.parametros;
                    if(vista.trim().length>0){
                        recargarPorURL(vista,parametros);
                    }else{
                        //$("#"+button).html(boton);
                        $("#"+button).prop("disabled",false);
                    }
                }
            } catch(err) {
                console.log(err);alerta("OCURRIO UN ERROR EN EL SISTEMA, REVISE");
            }
        },
        beforeSend: function (xhr) {

        }
    });
    //AJAX.push(ajax_function);
}

function enviarURL(url,parametros,ejecutar){
    var ajax_function = $.ajax({
        async:true,    
        cache:false,
        type: 'POST',
        url: url,
        data: parametros,
        success: function (data, textStatus, jqXHR) {
            try{
                var json = JSON.parse(data);
                var correcto = json.correcto;
                var url = json.url.toString();
                if(!correcto){
                    mensajeToast('ERROR',json.error);
                }else{
                    if(json.mensaje != null && json.mensaje.trim().length>0){
                        mensajeToast('',json.mensaje);
                    }
                }
                if(url.trim().length>0){
                    window.location = url;
                }else{
                    var vista = json.vista;
                    var parametros = json.parametros;
                    if(vista.trim().length>0){
                        recargarPorURL(vista,parametros);
                    }else{
                        if(ejecutar!=null){
                            eval(ejecutar);
                        }
                    }
                }
            } catch(err) {
                console.log(err);alerta("OCURRIO UN ERROR EN EL SISTEMA, REVISE");
            }
        },
        beforeSend: function (xhr) {

        }
    });
    //AJAX.push(ajax_function);
}

function cargarTabla_JSON(formulario,tBody,divPaginacion,href){
    $("#"+tBody).empty().html('<tr><td colspan="100"><div class="center">'+cargando+'</div></td></tr>');
    $("#"+divPaginacion).empty();
    var url = "";
    var data = "";
    if(formulario.toString().length>0){
        url = $("#"+formulario).attr("action");
        data = $("#"+formulario).serialize();
    }
    if(href!=null){
        url = href;
        data = "";
    }
    var ajax_function = $.ajax({
        async:true,    
        cache:false,
        type: "GET",   
        url: url,
        data: data, 
        success:  function(a){
            try{
                if(a!=null){
                    a = JSON.parse(a);
                    var html = '';
                    var tabla = a.datos;
                    var detalles = a.detalles;
                    var npag = Number(a.npag);
                    var href = a.href;
                    var clases = a.clases;
                    var styles = a.styles;
                    var Npaginas = Number(a.Npaginas);
                    var Npaginacion = Number(a.Npaginacion);
                    var Nlateral = Number((Npaginacion%2==0)?(Npaginacion/2):((Npaginacion-1)/2));
                    if(tabla.length>0){
                        $(tabla).each(function (key,val){
                            html = html + '<tr ';
                            if(clases!=null){
                                html = html + clases[key];
                            }else if(styles!=null){
                                html = html + ' style="'+styles[key]+'"';
                            }
                            if(detalles!=null){
                                html = html + ' available-details="true" data-details="'+detalles[key]+'"';
                            }
                            html = html + '>';
                            $(val).each(function (key2,val2){
                                html = html + '<td>'+val2+'</td>';
                            });
                            html = html + '</tr>';
                        });
                        $("#"+tBody).html(html);
                        $("#"+tBody).addClass("pointer");
                        html = '';
                        html = html + '<div class="col-sm-12">';
                        html = html + '    <ul class="pagination">';
                        html = html + '      <li>';
                        if(npag>1){
                            html = html + '<a href="#" onclick="cargarTabla_JSON(\'\',\''+tBody+'\',\''+divPaginacion+'\',\''+href+'page='+(npag-1).toString()+'\')"><i class="material-icons">chevron_left</i></a>';
                        }else{
                            html = html + '<a class="disabled"><i class="icon-arrow-left22"></i></a>';
                        }
                        html = html + '      </li>';
                        var begin = 0;
                        var end = 0;
                        if(Npaginas<=Npaginacion){ begin = 1;
                        }else{ if(npag-Nlateral<1){ begin = 1;
                        }else{ if(npag-Nlateral>Npaginas-Npaginacion+1){ begin = Npaginas-Npaginacion+1;
                        }else{ begin = npag-Nlateral;}}}
                        if(Npaginas<=Npaginacion){ end = Npaginas;
                        }else{ if(npag+Nlateral<Npaginacion){ end = Npaginacion;
                        }else{ if(npag+Nlateral>Npaginas){ end = Npaginas;
                        }else{ end = npag+Nlateral;}}}
                        for (var i=begin; i<=end; i++){
                            html = html + '<li class="';
                            if(npag == i){
                                html = html + 'active';
                            }else{
                                html = html + '';
                            }
                            html = html + '"><a href="#" onclick="cargarTabla_JSON(\'\',\''+tBody+'\',\''+divPaginacion+'\',\''+href+'page='+i+'\')">'+i+'</a></li>';
                        }
                        html = html + '      <li>';
                        if(npag < Npaginas){
                            html = html + '<a href="#" onclick="cargarTabla_JSON(\'\',\''+tBody+'\',\''+divPaginacion+'\',\''+href+'page='+(npag + 1).toString()+'\')"><i class="material-icons">chevron_right</i></a>';
                        }else{
                            html = html + '<a class="disabled"><i class="icon-arrow-right22"></i></a>';
                        }
                        html = html + '    </ul>';
                        html = html + '</div>';
                        $("#"+divPaginacion).html(html);
                        $('.tooltipped').tooltip({delay: 50});
                        var ejecutar = a.ejecutar;
                        if(ejecutar!=null && ejecutar.toString().trim().length>0){
                            eval(ejecutar);
                        }
                    }else{
                        $("#"+tBody).empty().html('<tr><td colspan="100">No se encontro ninguna coincidencia</td></tr>');
                    }
                }else{
                    window.location='/Selgestiun/';
                }
            } catch(err) {
                console.log(err);alerta("OCURRIO UN ERROR EN EL SISTEMA, REVISE");
            }
        },
        beforeSend:function(){},
        error:function(objXMLHttpRequest){}
    });
    //AJAX.push(ajax_function);
}

function selectAJAX_JSON(url,parametros,icon,propID,propOption,div,name,id,seleccionado,funcion,todos,ejecutar,bloquear,arrayMostrar){
    console.log(typeof (seleccionado));
    console.log(seleccionado==null);
    if(seleccionado==null){
        console.log("SI");
    }else{
        console.log("NO");
    }
    if(seleccionado==null || seleccionado.toString().trim().length==0){
        seleccionado = "0";
    }
    $("#"+div).empty().html('<div class="center">'+cargando+'<input type="hidden" name="'+name+'" value="'+seleccionado+'"></div>');
    var optionTodos = "";
    if(todos==null){
        todos=true;
        optionTodos = '(TODOS)';
    }else{
        if(typeof(todos)=="string"){
            optionTodos = todos;
            todos=true;
        }else{
            optionTodos = '(TODOS)';
        }
    }
    //console.log(bloquear);
    if(bloquear!=null){
        $(bloquear).each(function (key,val){
            //console.log(val);
            $("#"+val).hide();
        });
    }
    var ajax_function = $.ajax({
        async:true,    
        cache:false,
        type: 'GET',   
        url: url,
        data: parametros, 
        success:  function(a){
            try{
                a = JSON.parse(a);
                //console.log(a);
                var html = '<div class="input-group-prepend"><div class="input-group-text"><i class="'+icon+'"></i></div></div>';
                html = html + '<select class="custom-select" name="'+name+'" id="'+id+'"  onchange="'+funcion+'">';
                var cantidad = 0;
                if(todos){
                    html = html + '<option value="0">'+optionTodos+'</option>';
                }
                var dataMostrar = '';
                var js2 = '';
                if(arrayMostrar!=null){
                    var js2 = 'dataMostrar = ';
                    $(arrayMostrar).each(function (key2,val2){
                        js2 = js2 + "val."+val2+"+'|'+";
                    });
                    js2 = js2 + "'';";
                }
                $(a).each(function (key,val){
                    cantidad++;
                    //html = html + '<option value="'+val.Id+'" ';
                    try{
                        eval(js2);
                    } catch(err) {
                        console.log(err);
                        console.log(js2);
                        dataMostrar = "";
                    }
                    dataMostrar = encodeURI(dataMostrar);
                    eval("html = html + '<option value=\"'+val."+propID+"+'\" data_mostrar=\"'+dataMostrar+'\" ';");
                    eval("if(seleccionado==val."+propID+"){html = html + ' selected=\"\"';}");
                    //html = html + '>'+val.Abreviatura+'</option>';
                    eval("html = html + '>'+val."+propOption+"+'</option>';");
                });
                html = html + '</select>';
                $("#"+div).empty().html(html);
                if(ejecutar!=null){
                    eval(ejecutar);
                }
                if(bloquear!=null){
                    var mostrar='';
                    $(bloquear).each(function (key,val){
                        mostrar = mostrar + '$("#'+val+'").show();';
                    });
                    comprobarAjaxPendientes(mostrar);
                }
            } catch(err) {
                console.log(err);alerta("OCURRIO UN ERROR EN EL SISTEMA, REVISE");
            }
        },
        beforeSend:function(){},
        error:function(objXMLHttpRequest){}
    });
    //AJAX.push(ajax_function);
}

function autocompleteAJAX_JSON(url,parametros,label,propID,propOption,div,name,id,funcionClick,funcionBlur,claseEspecial,ejecutar,bloquear){
    $("#"+div).empty().html('<div class="center">'+cargando+'</div>');
    if(bloquear!=null){
        $(bloquear).each(function (key,val){
            //console.log(val);
            $("#"+val).hide();
        });
    }
    $.ajax({
        async:true,    
        cache:false,
        type: 'GET',   
        url: url,
        data: parametros, 
        success:  function(a){
            try{
                a = JSON.parse(a);
                //console.log(a);
                var html = '<input type="text" autocomplete="off" class="autocomplete" name="'+name+'" id="'+id+'" onblur="'+funcionBlur+'" last_selected=""><label for="'+id+'">'+label+'</label>';
                $("#"+div).empty().html(html);
                var datos = '';
                var js = 'var datos = {';
                $(a).each(function (key,val){
                    var dataMostrar = '';
                    var js2 = 'var dataMostrar = ';
                    $(propID).each(function (key2,val2){
                        js2 = js2 + "val."+val2+"+'|'+";
                    });
                    js2 = js2 + "'';";
                    eval(js2);
                    dataMostrar = dataMostrar.substring(0, dataMostrar.length - 1);
                    eval("js = js + '\"'+"+propOption+"+'\": \"'+dataMostrar+'\",';");
                });
                js = js + '};';
                eval(js);
                $("#"+id).autocomplete({
                        data: datos
                    },funcionClick,claseEspecial);
                if(ejecutar!=null){
                    eval(ejecutar);
                }
                if(bloquear!=null){
                    var mostrar='';
                    $(bloquear).each(function (key,val){
                        mostrar = mostrar + '$("#'+val+'").show();';
                    });
                    comprobarAjaxPendientes(mostrar);
                }
            } catch(err) {
                console.log(err);alerta("OCURRIO UN ERROR EN EL SISTEMA, REVISE");
            }
        },
        beforeSend:function(){},
        error:function(objXMLHttpRequest){}
    });
}

function limpiarAutocomplete(inptTxt,inptHdd,spanClear){
    $("#"+inptTxt).val("");
    $("#"+inptTxt).attr("last_selected","");
    $("#"+inptHdd).val("0");
    $(spanClear).parent().removeClass("select-wrapper");
    $("#"+inptTxt).prop("readonly",false);
    $(spanClear).remove();
    $("#"+inptTxt).focus();
}

function activeLabels(){
    $("label").each(function (key,val){
        var id_input = $(val).attr("for");
        if(id_input!=null){
            if(($("#"+id_input).attr("type")=="text" || $("#"+id_input).attr("type")=="number" || $("#"+id_input).attr("type")=="password" || $("#"+id_input).prop('type')=="textarea") && $("#"+id_input).val().toString().trim().length>0){
                $(val).addClass("active");
            }
        }
    });
}
