

function slctr(texto,valor){

this.texto = texto;

this.valor = valor;

}

var VACIO=new Array();

VACIO[0] = new slctr('Seleccionar','');

var DEPARTAMENTO1 = new Array();

DEPARTAMENTO1[0] = new slctr('Seleccionar','');

DEPARTAMENTO1[1] = new slctr('CHACHAPOYAS','1');

DEPARTAMENTO1[2] = new slctr('BAGUA','2');

DEPARTAMENTO1[3] = new slctr('BONGARA','3');

DEPARTAMENTO1[4] = new slctr('CONDORCANQUI','4');

DEPARTAMENTO1[5] = new slctr('LUYA','5');

DEPARTAMENTO1[6] = new slctr('RODRIGUEZ DE MENDOZA','6');

DEPARTAMENTO1[7] = new slctr('UTCUBAMBA','7');

var DEPARTAMENTO2 = new Array();

DEPARTAMENTO2[0] = new slctr('Seleccionar','');

DEPARTAMENTO2[1] = new slctr('HUARAZ','8');

DEPARTAMENTO2[2] = new slctr('AIJA','9');

DEPARTAMENTO2[3] = new slctr('ANTONIO RAYMONDI','10');

DEPARTAMENTO2[4] = new slctr('ASUNCION','11');

DEPARTAMENTO2[5] = new slctr('BOLOGNESI','12');

DEPARTAMENTO2[6] = new slctr('CARHUAZ','13');

DEPARTAMENTO2[7] = new slctr('CARLOS FERMIN FITZCARRALD','14');

DEPARTAMENTO2[8] = new slctr('CASMA','15');

DEPARTAMENTO2[9] = new slctr('CORONGO','16');

DEPARTAMENTO2[10] = new slctr('HUARI','17');

DEPARTAMENTO2[11] = new slctr('HUARMEY','18');

DEPARTAMENTO2[12] = new slctr('HUAYLAS','19');

DEPARTAMENTO2[13] = new slctr('MARISCAL LUZURIAGA','20');

DEPARTAMENTO2[14] = new slctr('OCROS','21');

DEPARTAMENTO2[15] = new slctr('PALLASCA','22');

DEPARTAMENTO2[16] = new slctr('POMABAMBA','23');

DEPARTAMENTO2[17] = new slctr('RECUAY','24');

DEPARTAMENTO2[18] = new slctr('SANTA','25');

DEPARTAMENTO2[19] = new slctr('SIHUAS','26');

DEPARTAMENTO2[20] = new slctr('YUNGAY','27');

var DEPARTAMENTO3 = new Array();

DEPARTAMENTO3[0] = new slctr('Seleccionar','');

DEPARTAMENTO3[1] = new slctr('ABANCAY','28');

DEPARTAMENTO3[2] = new slctr('ANDAHUAYLAS','29');

DEPARTAMENTO3[3] = new slctr('ANTABAMBA','30');

DEPARTAMENTO3[4] = new slctr('AYMARAES','31');

DEPARTAMENTO3[5] = new slctr('COTABAMBAS','32');

DEPARTAMENTO3[6] = new slctr('CHINCHEROS','33');

DEPARTAMENTO3[7] = new slctr('GRAU','34');

var DEPARTAMENTO4 = new Array();

DEPARTAMENTO4[0] = new slctr('Seleccionar','');

DEPARTAMENTO4[1] = new slctr('AREQUIPA','35');

DEPARTAMENTO4[2] = new slctr('CAMANA','36');

DEPARTAMENTO4[3] = new slctr('CARAVELI','37');

DEPARTAMENTO4[4] = new slctr('CASTILLA','38');

DEPARTAMENTO4[5] = new slctr('CAYLLOMA','39');

DEPARTAMENTO4[6] = new slctr('CONDESUYOS','40');

DEPARTAMENTO4[7] = new slctr('ISLAY','41');

DEPARTAMENTO4[8] = new slctr('LA UNION','42');

var DEPARTAMENTO5 = new Array();

DEPARTAMENTO5[0] = new slctr('Seleccionar','');

DEPARTAMENTO5[1] = new slctr('HUAMANGA','43');

DEPARTAMENTO5[2] = new slctr('CANGALLO','44');

DEPARTAMENTO5[3] = new slctr('HUANCA SANCOS','45');

DEPARTAMENTO5[4] = new slctr('HUANTA','46');

DEPARTAMENTO5[5] = new slctr('LA MAR','47');

DEPARTAMENTO5[6] = new slctr('LUCANAS','48');

DEPARTAMENTO5[7] = new slctr('PARINACOCHAS','49');

DEPARTAMENTO5[8] = new slctr('PAUCAR DEL SARA SARA','50');

DEPARTAMENTO5[9] = new slctr('SUCRE','51');

DEPARTAMENTO5[10] = new slctr('VICTOR FAJARDO','52');

DEPARTAMENTO5[11] = new slctr('VILCAS HUAMAN','53');

var DEPARTAMENTO6 = new Array();

DEPARTAMENTO6[0] = new slctr('Seleccionar','');

DEPARTAMENTO6[1] = new slctr('CAJAMARCA','54');

DEPARTAMENTO6[2] = new slctr('CAJABAMBA','55');

DEPARTAMENTO6[3] = new slctr('CELENDIN','56');

DEPARTAMENTO6[4] = new slctr('CHOTA','57');

DEPARTAMENTO6[5] = new slctr('CONTUMAZA','58');

DEPARTAMENTO6[6] = new slctr('CUTERVO','59');

DEPARTAMENTO6[7] = new slctr('HUALGAYOC','60');

DEPARTAMENTO6[8] = new slctr('JAEN','61');

DEPARTAMENTO6[9] = new slctr('SAN IGNACIO','62');

DEPARTAMENTO6[10] = new slctr('SAN MARCOS','63');

DEPARTAMENTO6[11] = new slctr('SAN MIGUEL','64');

DEPARTAMENTO6[12] = new slctr('SAN PABLO','65');

DEPARTAMENTO6[13] = new slctr('SANTA CRUZ','66');

var DEPARTAMENTO7 = new Array();

DEPARTAMENTO7[0] = new slctr('Seleccionar','');

DEPARTAMENTO7[1] = new slctr('CALLAO','67');

var DEPARTAMENTO8 = new Array();

DEPARTAMENTO8[0] = new slctr('Seleccionar','');

DEPARTAMENTO8[1] = new slctr('CUSCO','68');

DEPARTAMENTO8[2] = new slctr('ACOMAYO','69');

DEPARTAMENTO8[3] = new slctr('ANTA','70');

DEPARTAMENTO8[4] = new slctr('CALCA','71');

DEPARTAMENTO8[5] = new slctr('CANAS','72');

DEPARTAMENTO8[6] = new slctr('CANCHIS','73');

DEPARTAMENTO8[7] = new slctr('CHUMBIVILCAS','74');

DEPARTAMENTO8[8] = new slctr('ESPINAR','75');

DEPARTAMENTO8[9] = new slctr('LA CONVENCION','76');

DEPARTAMENTO8[10] = new slctr('PARURO','77');

DEPARTAMENTO8[11] = new slctr('PAUCARTAMBO','78');

DEPARTAMENTO8[12] = new slctr('QUISPICANCHI','79');

DEPARTAMENTO8[13] = new slctr('URUBAMBA','80');

var DEPARTAMENTO9 = new Array();

DEPARTAMENTO9[0] = new slctr('Seleccionar','');

DEPARTAMENTO9[1] = new slctr('HUANCAVELICA','81');

DEPARTAMENTO9[2] = new slctr('ACOBAMBA','82');

DEPARTAMENTO9[3] = new slctr('ANGARAES','83');

DEPARTAMENTO9[4] = new slctr('CASTROVIRREYNA','84');

DEPARTAMENTO9[5] = new slctr('CHURCAMPA','85');

DEPARTAMENTO9[6] = new slctr('HUAYTARA','86');

DEPARTAMENTO9[7] = new slctr('TAYACAJA','87');

var DEPARTAMENTO10 = new Array();

DEPARTAMENTO10[0] = new slctr('Seleccionar','');

DEPARTAMENTO10[1] = new slctr('HUANUCO','88');

DEPARTAMENTO10[2] = new slctr('AMBO','89');

DEPARTAMENTO10[3] = new slctr('DOS DE MAYO','90');

DEPARTAMENTO10[4] = new slctr('HUACAYBAMBA','91');

DEPARTAMENTO10[5] = new slctr('HUAMALIES','92');

DEPARTAMENTO10[6] = new slctr('LEONCIO PRADO','93');

DEPARTAMENTO10[7] = new slctr('MARAÑON','94');

DEPARTAMENTO10[8] = new slctr('PACHITEA','95');

DEPARTAMENTO10[9] = new slctr('PUERTO INCA','96');

DEPARTAMENTO10[10] = new slctr('LAURICOCHA','97');

DEPARTAMENTO10[11] = new slctr('YAROWILCA','98');

var DEPARTAMENTO11 = new Array();

DEPARTAMENTO11[0] = new slctr('Seleccionar','');

DEPARTAMENTO11[1] = new slctr('ICA','99');

DEPARTAMENTO11[2] = new slctr('CHINCHA','100');

DEPARTAMENTO11[3] = new slctr('NAZCA','101');

DEPARTAMENTO11[4] = new slctr('PALPA','102');

DEPARTAMENTO11[5] = new slctr('PISCO','103');

var DEPARTAMENTO12 = new Array();

DEPARTAMENTO12[0] = new slctr('Seleccionar','');

DEPARTAMENTO12[1] = new slctr('HUANCAYO','104');

DEPARTAMENTO12[2] = new slctr('CONCEPCION','105');

DEPARTAMENTO12[3] = new slctr('CHANCHAMAYO','106');

DEPARTAMENTO12[4] = new slctr('JAUJA','107');

DEPARTAMENTO12[5] = new slctr('JUNIN','108');

DEPARTAMENTO12[6] = new slctr('SATIPO','109');

DEPARTAMENTO12[7] = new slctr('TARMA','110');

DEPARTAMENTO12[8] = new slctr('YAULI','111');

DEPARTAMENTO12[9] = new slctr('CHUPACA','112');

var DEPARTAMENTO13 = new Array();

DEPARTAMENTO13[0] = new slctr('Seleccionar','');

DEPARTAMENTO13[1] = new slctr('TRUJILLO','113');

DEPARTAMENTO13[2] = new slctr('ASCOPE','114');

DEPARTAMENTO13[3] = new slctr('BOLIVAR','115');

DEPARTAMENTO13[4] = new slctr('CHEPEN','116');

DEPARTAMENTO13[5] = new slctr('JULCAN','117');

DEPARTAMENTO13[6] = new slctr('OTUZCO','118');

DEPARTAMENTO13[7] = new slctr('PACASMAYO','119');

DEPARTAMENTO13[8] = new slctr('PATAZ','120');

DEPARTAMENTO13[9] = new slctr('SANCHEZ CARRION','121');

DEPARTAMENTO13[10] = new slctr('SANTIAGO DE CHUCO','122');

DEPARTAMENTO13[11] = new slctr('GRAN CHIMU','123');

DEPARTAMENTO13[12] = new slctr('VIRU','124');

var DEPARTAMENTO14 = new Array();

DEPARTAMENTO14[0] = new slctr('Seleccionar','');

DEPARTAMENTO14[1] = new slctr('CHICLAYO','125');

DEPARTAMENTO14[2] = new slctr('FERREÑAFE','126');

DEPARTAMENTO14[3] = new slctr('LAMBAYEQUE','127');

var DEPARTAMENTO15 = new Array();

DEPARTAMENTO15[0] = new slctr('Seleccionar','');

DEPARTAMENTO15[1] = new slctr('LIMA','128');

DEPARTAMENTO15[2] = new slctr('BARRANCA','129');

DEPARTAMENTO15[3] = new slctr('CAJATAMBO','130');

DEPARTAMENTO15[4] = new slctr('CANTA','131');

DEPARTAMENTO15[5] = new slctr('CAÑETE','132');

DEPARTAMENTO15[6] = new slctr('HUARAL','133');

DEPARTAMENTO15[7] = new slctr('HUAROCHIRI','134');

DEPARTAMENTO15[8] = new slctr('HUAURA','135');

DEPARTAMENTO15[9] = new slctr('OYON','136');

DEPARTAMENTO15[10] = new slctr('YAUYOS','137');

var DEPARTAMENTO16 = new Array();

DEPARTAMENTO16[0] = new slctr('Seleccionar','');

DEPARTAMENTO16[1] = new slctr('MAYNAS','138');

DEPARTAMENTO16[2] = new slctr('ALTO AMAZONAS','139');

DEPARTAMENTO16[3] = new slctr('LORETO','140');

DEPARTAMENTO16[4] = new slctr('MARISCAL RAMON CASTILLA','141');

DEPARTAMENTO16[5] = new slctr('REQUENA','142');

DEPARTAMENTO16[6] = new slctr('UCAYALI','143');

var DEPARTAMENTO17 = new Array();

DEPARTAMENTO17[0] = new slctr('Seleccionar','');

DEPARTAMENTO17[1] = new slctr('TAMBOPATA','144');

DEPARTAMENTO17[2] = new slctr('MANU','145');

DEPARTAMENTO17[3] = new slctr('TAHUAMANU','146');

var DEPARTAMENTO18 = new Array();

DEPARTAMENTO18[0] = new slctr('Seleccionar','');

DEPARTAMENTO18[1] = new slctr('MARISCAL NIETO','147');

DEPARTAMENTO18[2] = new slctr('GENERAL SANCHEZ CERRO','148');

DEPARTAMENTO18[3] = new slctr('ILO','149');

var DEPARTAMENTO19 = new Array();

DEPARTAMENTO19[0] = new slctr('Seleccionar','');

DEPARTAMENTO19[1] = new slctr('PASCO','150');

DEPARTAMENTO19[2] = new slctr('DANIEL ALCIDES CARRION','151');

DEPARTAMENTO19[3] = new slctr('OXAPAMPA','152');

var DEPARTAMENTO20 = new Array();

DEPARTAMENTO20[0] = new slctr('Seleccionar','');

DEPARTAMENTO20[1] = new slctr('PIURA','153');

DEPARTAMENTO20[2] = new slctr('AYABACA','154');

DEPARTAMENTO20[3] = new slctr('HUANCABAMBA','155');

DEPARTAMENTO20[4] = new slctr('MORROPON','156');

DEPARTAMENTO20[5] = new slctr('PAITA','157');

DEPARTAMENTO20[6] = new slctr('SULLANA','158');

DEPARTAMENTO20[7] = new slctr('TALARA','159');

DEPARTAMENTO20[8] = new slctr('SECHURA','160');

var DEPARTAMENTO21 = new Array();

DEPARTAMENTO21[0] = new slctr('Seleccionar','');

DEPARTAMENTO21[1] = new slctr('PUNO','161');

DEPARTAMENTO21[2] = new slctr('AZANGARO','162');

DEPARTAMENTO21[3] = new slctr('CARABAYA','163');

DEPARTAMENTO21[4] = new slctr('CHUCUITO','164');

DEPARTAMENTO21[5] = new slctr('EL COLLAO','165');

DEPARTAMENTO21[6] = new slctr('HUANCANE','166');

DEPARTAMENTO21[7] = new slctr('LAMPA','167');

DEPARTAMENTO21[8] = new slctr('MELGAR','168');

DEPARTAMENTO21[9] = new slctr('MOHO','169');

DEPARTAMENTO21[10] = new slctr('SAN ANTONIO DE PUTINA','170');

DEPARTAMENTO21[11] = new slctr('SAN ROMAN','171');

DEPARTAMENTO21[12] = new slctr('SANDIA','172');

DEPARTAMENTO21[13] = new slctr('YUNGUYO','173');

var DEPARTAMENTO22 = new Array();

DEPARTAMENTO22[0] = new slctr('Seleccionar','');

DEPARTAMENTO22[1] = new slctr('MOYOBAMBA','174');

DEPARTAMENTO22[2] = new slctr('BELLAVISTA','175');

DEPARTAMENTO22[3] = new slctr('EL DORADO','176');

DEPARTAMENTO22[4] = new slctr('HUALLAGA','177');

DEPARTAMENTO22[5] = new slctr('LAMAS','178');

DEPARTAMENTO22[6] = new slctr('MARISCAL CACERES','179');

DEPARTAMENTO22[7] = new slctr('PICOTA','180');

DEPARTAMENTO22[8] = new slctr('RIOJA','181');

DEPARTAMENTO22[9] = new slctr('SAN MARTIN','182');

DEPARTAMENTO22[10] = new slctr('TOCACHE','183');

var DEPARTAMENTO23 = new Array();

DEPARTAMENTO23[0] = new slctr('Seleccionar','');

DEPARTAMENTO23[1] = new slctr('TACNA','184');

DEPARTAMENTO23[2] = new slctr('CANDARAVE','185');

DEPARTAMENTO23[3] = new slctr('JORGE BASADRE','186');

DEPARTAMENTO23[4] = new slctr('TARATA','187');

var DEPARTAMENTO24 = new Array();

DEPARTAMENTO24[0] = new slctr('Seleccionar','');

DEPARTAMENTO24[1] = new slctr('TUMBES','188');

DEPARTAMENTO24[2] = new slctr('CONTRALMIRANTE VILLAR','189');

DEPARTAMENTO24[3] = new slctr('ZARUMILLA','190');

var DEPARTAMENTO25 = new Array();

DEPARTAMENTO25[0] = new slctr('Seleccionar','');

DEPARTAMENTO25[1] = new slctr('CORONEL PORTILLO','191');

DEPARTAMENTO25[2] = new slctr('ATALAYA','192');

DEPARTAMENTO25[3] = new slctr('PADRE ABAD','193');

DEPARTAMENTO25[4] = new slctr('PURUS','194');

function slctryole(cual,donde){
    donde.length=0;
    cual = eval(cual.value);
    for(m=0;m<cual.length;m++){
        var nuevaOpcion = new Option(cual[m].texto);
        donde.options[m] = nuevaOpcion;
        if(cual[m].valor != null){
            donde.options[m].value = cual[m].valor;
        }
        else{
            donde.options[m].value = cual[m].texto;
        }
    }
    $('select').material_select('destroy');
    $('select').material_select();
}