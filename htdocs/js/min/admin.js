main.scripts.loaded.push('admin');function sincronizar(dias,date){var fecha=date||Fecha.general,$datepicker=$('.datepicker')
if(dias)
fecha=Fecha.calcular(dias,fecha);else dias=0;Fecha.anterior=Fecha.general
Fecha.general=Fecha.sql(fecha)
Fecha.id=Fecha.number(Fecha.general)
colorearMenuDiasSemana();admin.sincronizar(dias)
notas.load(Fecha.general)
if(typeof crearCita.horas=='object')crearCita.horas.sincronizar()
if(typeof historial.sinc=='function')historial.sinc()
var diaFestivo=$.inArray(Fecha.md(Fecha.general),config.festivos)!=-1;(diaFestivo)?$datepicker.addClass('c-red'):$datepicker.removeClass('c-red')
$datepicker.val(Fecha.print(fecha)).datepicker("setDate",Fecha.print(fecha))}
var worker={w:null,init:function(){this.w.postMessage(0)},send:function(){setTimeout(this.init(),1000*60)},sync:function(){this.w=new Worker('/js/worker.js');this.w.onmessage=e=>{let data=JSON.parse(e.data);if(data){$.each(data,function(i,d){$.each(d,function(i,v){let action=parseInt(v.action),obj=null
switch(v.table){case 'data':obj=admin.lbl;break;case 'notas':obj=notas;break;case 'usuarios':obj=usuarios.rows;break;case 'servicios':obj=servicios;break;case 'familias':obj=familias;break};switch(action){case 1:obj.create(v);break;case 2:obj.edit(v);break;case 3:obj.delete(v,!0);break}})})}
worker.send()}
worker.send()},},admin={idUser:$('#main').data('user'),z_index:2,data:new Object(),arrSer:new Array(),last:new Object(),idsControl:new Object(),idCita:-1,ancho:0,init:function(){this.lbl.width=$('#main th').first().width()-2;this.ancho=$('#sections').width()
let n=(localStorage.getItem("showRows")==1)?1:0;this.inactivas.change(n)
this.inactivas.comprobar()
this.lbl.load()
notas.init()
worker.sync()
cargarDatepicker()
colorearMenuDiasSemana()
Device.init()
if(Device.isCel())localStorage.setItem('menuOpen',0)
$('.tabcontrol').tabcontrol()
$('.fnToggleCharm').click(function(){menu.nav.charm.toggle($(this))})
$('#frmContact').submit(function(event){event.preventDefault()
var data=$("#frmContact").serializeArray()
data.push({name:'controller',value:'contacto'})
data.empresa=$('main').data('empresa')
data[1].value=normalize(data[1].value)
$.post(INDEX,data,function(r){if(r.success)
notify.success('Email mandado con éxito')
else notify.error('No se pudo mandar el email!! <br> Compruebe que estan todos los datos')
menu.nav.contacto.cerrar()
btn.load.hide()},'json')})
$(".login").on('focusout','[data-max-leght]',function(){var $this=$("[data-max-leght]");if($this.val().length>$this.data("max-leght")){$this.removeClass("valid");$this.addClass("invalid")}else{$this.removeClass("invalid");$this.addClass("valid")}});$('#main').on('click','.lbl',function(e){var val=($(this).css('z-index')==3)?1:3
$('.lbl').css({'z-index':2})
$(this).css({'z-index':val})
admin.lbl.resize($(this))
e.stopPropagation()}).on('dblclick','.lbl',function(e){admin.edit($(this).attr('idcita'))}).on('click','.celda',function(){let celda=$(this)
admin.mostrarCapa('crearCita',function($this){crearCita.data.agenda=celda.attr('agenda')
crearCita.data.hora=celda.parents('tr').data('hour')
$this.find('#agenda'+crearCita.data.agenda).prop('checked',!0)})}).on('click','#mainLstDiasSemana a',function(){var diaA=parseInt(Fecha.diaSemana(Fecha.general));var diaB=parseInt($(this).data('value'));sincronizar(diaB-diaA)}).on('change','#lstDiasSemana',function(){var diaA=parseInt(Fecha.diaSemana(Fecha.general));var diaB=parseInt($(this).val());sincronizar(diaB-diaA)}).on('click','.icon-attention',function(e){admin.citasSup($(this));e.stopPropagation()}).on('click','.fnEdit',function(e){e.stopPropagation()
admin.edit($(this).parents('.lbl').attr('idcita'))}).on('click','.cita',function(e){$(this).parent().find('.note').addClass('show').find('input').focus()}).on('click','.lbl .fnDel',function(e){$(".selector").draggable("option","disabled",!0);e.stopPropagation();admin.del($(this).parents('.lbl').attr('idcita'))}).on('change','.nombreagenda',function(){var data={id:$(this).data('agenda'),nombre:$(this).val(),controller:'agendas',action:'saveName'}
$.post(INDEX,data,function(r){},'json')}).find('.cuerpo').on("swipeleft",function(){sincronizar(1)}).on("swiperight",function(){sincronizar(-1)})
$('#navbar').on('click','#btnShow',menu.show).on('click','#btnEdit',menu.edit).on('click','#btnSearch',function(){if($('#txtBuscar').is(':hidden')){$('#txtBuscar').parent().show('slide',{direction:'right'}).end().focus();$('#btnSearch').find('i').removeClass().addClass('lnr-cross').end().find('span').text('Cerrar')}else{menu.load()}}).on('change','#txtBuscar',function(){if($('#txtBuscar').val()!=""){menu.buscar($('#txtBuscar').val(),$('.capasPrincipales.activa').attr('id'))}}).on('click','#btnReset',function(){if($('#usuarios').is(':visible'))usuarios.select('A')}).on('click','#btnSave',menu.save).on('keyup','#txtBuscar',function(event){if(event.which==13)menu.load();if(event.which==27)
menu.exit();event.stopPropagation()}).on('click','#btnAdd',menu.add).on('click','#btnDel',menu.del).on('click','#btnReset',menu.reset).on('click','#btnOptions #chckOpUsersDel',menu.options).find('#showByTime').on('click','input',function(){$(this).prop('checked',!0)
historial.get($(this).val())}).end()
$('#mySidenav').find('[name="menu[]"]').parent().click(function(){if(Device.isCel()){menu.nav.open(0)
menu.nav.estado(0)}
admin.mostrarCapa($(this).find('a').data('capa'))})
$('#notas').on("click",".fnEdit",function(e){notas.dialog($(this).attr('id'))}).on("click",".fnDel",function(e){e.stopPropagation()
notas.delete($(this).parent().attr('id'))}).on('click','#nuevaNota',function(){notas.dialog(-1)})
$('<title/>').text('AgendaOnline zona admin').appendTo('head')},reload:function(){let that=this
$.post(INDEX,{controller:'admin'},function(html){let $main=$(html).filter('main')
$('body').hide('fade').find('#sections').detach().end().show('fade').append($main);menu.nav.btn.save.switch()
menu.status('main');that.init()},'html')},set:{nameAgenda:function(id,name){$('#main').find('#nombreagenda'+id).val(name)},data:function(idCita){var lbl=$('#idCita_'+idCita+'.lbl')
admin.data[idCita]={idCita:idCita,agenda:lbl.parents('.celda').attr('agenda'),cliente:{id:lbl.find('.nombre').attr('id'),nombre:lbl.find('.nombre').text().trim()},fecha:Fecha.sql(lbl.parents('.dia').attr('id')),hora:lbl.parents('tr').data('hour'),obs:lbl.find('.note').text().trim(),servicios:new Array(),tiempo_servicios:parseInt(lbl.attr('tiempo'))}
lbl.find('.codigo').each(function(i,o){var id=$(this).attr('id_codigo'),codigo=$(this).html(),descripcion=$(this).attr('des_codigo'),tiempo=$(this).attr('tiempo')
admin.data[idCita].servicios.push({id,codigo,descripcion,tiempo})
admin.arrSer.push({id,codigo,descripcion,tiempo})})},tiempoServicios:function(){var ts=admin.data[admin.idCita].tiempo_servicios
$('#dlgEditCita').find('#tiempoServicios').val(ts)}},sincronizar:function(dir=0){main.loader.show()
let _pasarDia=function(){if(Fecha.id!=$("#main").find('.dia.activa').attr('id')){var ent=dir>0?'right':'left',sal=dir>0?'left':'right'
$('#main .cuerpo').hide("slide",{direction:sal},500,function(){$('.dia.activa').removeClass('activa')
$("#main").find('#'+Fecha.id).addClass('activa')
$('#main .cuerpo').show("slide",{direction:ent},500)
admin.inactivas.comprobar()})}
main.loader.hide()}
if(!$("#main").find('#'+Fecha.id).length)
admin.crearDias(_pasarDia)
else _pasarDia()},activeDay:function(){$('.activa').removeClass('activa')
$('#'+Fecha.id).addClass('activa')},crearDias:function(callback){var fecha=fecha||Fecha.general;var dias=$('#main .cuerpo').find('.dia')
var ids=new Array();$.each(dias,function(){ids.push($(this).attr('id'))})
$.ajax({type:"POST",url:INDEX,dataType:'html',data:{fecha:Fecha.general,ids:ids,controller:'main',action:VIEW},cache:!1}).done(function(html){$('#main .cuerpo').append(html)
admin.lbl.load()
typeof callback=="function"&&callback()}).fail(function(r,status){console.log("Fallo refrescando=>"+status)})},citasSup:function($this){var $celda=$this.parents('.celda');var idCita=new Array();$celda.find('table:visible').hide('blind',function(){var $this=$(this).next().length?$(this).next():$(this).prev();$this.show('blind').find('.icon-attention').show().end().parent().removeClass('color1 color2').addClass($this.data('color'))})},save:function(data,callback){data.controller='cita'
$.ajax({type:"POST",dataType:"json",url:INDEX,data:data,}).done(function(r){if(r.success){typeof callback=="function"&&callback()}else{notify.error('No se pudo guardar.')}}).fail(function(r){console.log(r)})},edit:function(idCita,idCelda){if(!idCita)return!1
admin.idCita=idCita
var lbl=$('#idCita_'+admin.idCita+'.lbl')
admin.lbl.obj=lbl
admin.set.data(admin.idCita)
admin.last={idCita:admin.data[admin.idCita].idCita,agenda:admin.data[admin.idCita].agenda,tiempo_servicios:admin.data[admin.idCita].tiempo_servicios,hora:admin.data[admin.idCita].hora,fecha:admin.data[admin.idCita].fecha,cliente:{id:admin.data[admin.idCita].cliente.id,nombre:admin.data[admin.idCita].cliente.nombre},obs:admin.data[admin.idCita].obs,lastmod:admin.data[admin.idCita].lastMod}
var _addServiceToLbl=function(callback){var arrSer=admin.data[admin.idCita].servicios,lblSer=admin.lbl.obj.find('.servicios'),html=''
lblSer.empty()
for(let i=0;i<arrSer.length;i++){let self=arrSer[i]
var dataArrSer={id:self.id,codigo:self.codigo,idCita:self.idCita,descripcion:self.descripcion,tiempo:self.tiempo}
html+=admin.lbl.service(dataArrSer)}
lblSer.html(html)
admin.lbl.obj.removeClassPrefix('row_').addClass('row_'+Math.ceil(admin.data[admin.idCita].tiempo_servicios/15))
typeof callback=="function"&&callback()}
var _delRow=function(div){var cod=div.find('.codigo'),idCod=cod.attr('id_codigo'),arrSer=admin.data[admin.idCita].servicios,len=arrSer.length
admin.data[admin.idCita].tiempo_servicios=0
var borrar_index=null
for(let i=0;i<len;i++){if(idCod==arrSer[i].id){borrar_index=i}else{admin.data[admin.idCita].tiempo_servicios+=parseInt(arrSer[i].tiempo)}}
if(borrar_index!=null){admin.data[admin.idCita].servicios.splice(borrar_index,1)
div.fadeOut('fast').remove()}
admin.set.tiempoServicios()}
var _addRow=function(id,codigo,descripcion,tiempo,callback){var $dlg=$('#dlgEditCita')
$dlg.find('.template').clone().removeClass('template').find('.codigo').attr('id_codigo',id).html(codigo+" => ").attr('tiempo',tiempo).end().find('.descripcion').html(descripcion).end().appendTo($('#dlgEditCita').find('#codigos')).on('click','.fnDelSer',function(){_delRow($(this).parent())})
typeof callback=="function"&&callback()}
var _eventAddService=function(){$('#dlgEditCita').on('change','#lstServ',function(){var select=$(this).find(':selected')
id=select.val(),codigo=select.attr('codigo'),descripcion=select.text(),tiempo=select.attr('tiempo')
admin.data[admin.idCita].servicios.push({id,codigo,descripcion,tiempo})
admin.data[admin.idCita].tiempo_servicios+=parseInt(tiempo)
_addRow(id,codigo,descripcion,tiempo,admin.set.tiempoServicios)
$(this).val('')})}
var _save=function(){var dlg=$('#dlgEditCita'),duration=0,arrIdSer=new Array(),data=new Array()
dlg.find('input').each(function(i,v){data[$(this).attr('id')]=$(this).val()})
let str=normalize(data.cliente),selCli=$('#lstClientes [data-name="'+str+'"]')
admin.data[admin.idCita].cliente.id=selCli.data('id')
admin.data[admin.idCita].cliente.nombre=selCli.val()
admin.data[admin.idCita].fecha=data.fecha
admin.data[admin.idCita].hora=data.hora
admin.data[admin.idCita].obs=data.obs
admin.data[admin.idCita].tiempo_servicios=data.tiempoServicios
admin.data[admin.idCita].lastMod=Fecha.now()
$.each(admin.data[admin.idCita].servicios,function(i,v){arrIdSer.push(v.id)})
var sendData={action:EDIT,idCita:admin.idCita,agenda:admin.data[admin.idCita].agenda,idUsuario:admin.data[admin.idCita].cliente.id||!1,fecha:Fecha.sql(dlg.find('#fecha').val()),hora:dlg.find('#hora').val(),obs:dlg.find('#obs').val(),tiempo_servicios:data.tiempoServicios,servicios:arrIdSer,status:!1}
admin.save(sendData,function(){admin.lbl.edit(admin.data[admin.idCita],admin.last)
_addServiceToLbl(function(){dialog.close('dlgEditCita')
if(!$.isEmpty(sendData.obs)){admin.lbl.obj.find('.text_note').text(sendData.obs).end().find('.note').addClass('show')}else{admin.lbl.obj.find('.text_note').text(sendData.obs).end().find('.note').removeClass('show')}})})}
if(!$.isEmpty(idCelda)){let decode=generateId.decode(idCelda)
admin.data[admin.idCita].agenda=decode.agenda
admin.data[admin.idCita].fecha=decode.date
admin.data[admin.idCita].hora=decode.hour
let edata=admin.data[admin.idCita],len=admin.data[admin.idCita].servicios.length,ser=admin.data[admin.idCita].servicios
edata.servicios=new Array;edata.idUsuario=edata.cliente.id
delete edata.cliente
for(let i=0;i<len;i++){edata.servicios.push(ser[i].id)}
edata.action=EDIT
admin.save(edata)}else{var
fnCancel=function(){admin.del(admin.data[admin.idCita].idCita)},callback=function($this){$this.find('#codigos').html('').end().data('idCita',admin.idCita).find('#id').val(admin.idCita).end().find('#cliente').val(admin.data[admin.idCita].cliente.nombre).end().find('#obs').val(admin.data[admin.idCita].obs||null).end().find('#fecha').val(admin.data[admin.idCita].fecha).end().find('#hora').val(admin.data[admin.idCita].hora).end().find('#tiempoServicios').val(admin.data[admin.idCita].tiempo_servicios);$.each(admin.data[admin.idCita].servicios,function(i,a){_addRow(a.id,a.codigo,a.descripcion,a.tiempo,admin.set.tiempoServicios)})
if(dialog.new)_eventAddService()}
dialog.open('dlgEditCita',_save,fnCancel,callback)}},del:function(idCita){data={id:idCita,action:'del',controller:'cita',fecha:Fecha.sql(Fecha.general)}
if(admin.lbl.delete(data.id,!1)){$.post(INDEX,data,function(r){if(r.success){$('#lstChckSer').empty();$('#dlgEditCita').removeData('idCita')
dialog.close('dlgEditCita')}},'json').fail(function(jqXHR,textStatus,errorThrown){echo(jqXHR.responseText)})}},guardarNota:function($this){var txt=$this.find('input').val();var id=$this.parents(':eq(3)').attr('idcita')
if(!$.isEmpty(txt)){$this.find('.icon-load').fadeIn();$.get(INDEX,{id:id,txt:txt},function(r){if(r.success){$this.find('.icon-ok').fadeIn()
setTimeout(function(){$this.find('.icon-ok').fadeOut()},3000)}else{echo(r)}}).always($this.find('.icon-load').fadeOut())}},unidadTiempo:tiempoServicios=>Math.ceil(tiempoServicios/15),inactivas:{click:function(){var status=localStorage.getItem("showRows")==1||$('.dia.activa').find('.fuera_horario').is(':visible')?0:1;admin.inactivas.change(status)},change:function(std,save=!0){let effect='puff',duration=1500;if(std==1){$('#main .disabled').removeClass('disabled');$('#btnShow').find('.menulbl').html('Ocultar').end().find('i').removeClass().addClass('lnr-star')}else{std=0;$('#main .fuera_horario').parent().addClass('disabled')
$('#btnShow').find('.menulbl').html('Mostrar').end().find('i').removeClass().addClass('lnr-star-empty')}
if(save)localStorage.setItem("showRows",std)},comprobar:function(){if($('#'+Fecha.id).find('tr').find('.fuera_horario').find('.lbl').length)
admin.inactivas.change(!0,!1)
else if(localStorage.getItem("showRows")==0)
admin.inactivas.change(!1,!1)}},lbl:{width:'25',height:new Array,clone:new Object,idLastcelda:0,obj:null,load:function(){$('.lbl').each(function(){admin.lbl.draggable($(this))})
this.droppable()
menu.nav.estado(localStorage.getItem("menuOpen"))
this.color()},loadData(data){let strSer='',classNote=($.isEmpty(data.nota))?'':'show';$.each(data.servicios,function(id,serv){strSer+=admin.lbl.service(serv)})
$('#idCita_'+data.idCita).attr('lastmod',Fecha.now()).attr('idcita',data.idCita).attr('tiempo',data.tiempo_servicios).removeClassPrefix('row_').addClass('row_'+admin.unidadTiempo(data.tiempo_servicios)).find('.nombre').attr('id',data.cliente.id).find('span').text(data.cliente.nombre).end().end().find('.servicios').html(strSer).end().find('.note').removeClass('show').addClass(classNote).find('span').text(data.nota)},create:function(data){if($('#idCita_'+data.idCita).length)return!1;var lbl=admin.lbl,htmlSer='',idCelda=generateId.encode(data.agenda,data.fecha,data.hora),$celda=$('#'+idCelda)
if($celda.length){$.each(data.servicios,function(id,serv){htmlSer+=lbl.service(serv)})
$celda.find('.fnCogerCita').remove().end().append(lbl.container(data,htmlSer))
this.obj=$('#idCita_'+data.idCita+'.lbl')
lbl.style()
admin.lbl.draggable(this.obj)}},edit:function(data,last=null){let $lbl=$('#idCita_'+data.idCita);if($lbl.length&&Fecha.equate(data.lastMod,$lbl.attr('lastmod'))==1){$lbl.attr('lastmod',data.lastMod);if(last){var idCita=data.idCita,object=$('#main').find('#idCita_'+idCita)
$('#idCita_'+data.idCita+'.lbl').attr('tiempo',data.tiempo_servicios)
if(data.cliente.id!=last.cliente.id){object.find('.nombre').attr('id',data.cliente.id).find('.text-value').html(data.cliente.nombre)}
if(data.fecha!=last.fecha||data.hora!=last.hora){let idCell=generateId.encode(data.agenda,data.fecha,data.hora),clon=object.clone()
object.remove()
clon.appendTo('#'+idCell)
admin.lbl.style()}
if(data.obs!=last.obs)object.find('#obs').val(data.obs)}else{this.loadData(data)}}else return!1},container:function(data,htmlSer){var html_icono_desplegar=(data.servicios.length<=data.tiempo_servicios)?"<i class ='icon-angle-down fnExtend' ></i>":"",html_icono_usuario_coge_cita=typeof data.cliente!='undefined'&&data.cliente.usuarioCogeCita==admin.idUser?"<i class ='lnr-laptop-phone' title='La cita ha sido remotamente'></i>":"",idUsuario=data.idUsuario||data.cliente.id,nombre=data.nombre||data.cliente.nombre,lastMod=(typeof data.lastMod=='undefined')?Fecha.now:data.lastMod;var claseNotas=($.isEmpty(data.nota))?'':'show'
var nota=$.isEmpty(data.nota)?'':data.nota
var html="<div id='idCita_"+data.idCita+"' lastmod='"+lastMod+"'	 idcita="+data.idCita+" class='lbl row_"+admin.unidadTiempo(data.tiempo_servicios)+"' tiempo='"+data.tiempo_servicios+"'> \
					<div class='iconos'>"+html_icono_desplegar+html_icono_usuario_coge_cita+"<div class='icons_crud'>\
							<i class ='fnEdit icon-pencil-1'></i>  \
							<i class ='fnDel icon-trash'></i>  \
						</div>\
						<i class ='fnMove icon-move '></i>  \
					</div> \
					<div id ='"+idUsuario+"' class='nombre'> \
						<i class ='icon-user-1'></i> \
						<span>"+nombre+"</span> \
					</div> \
					<div class='servicios'>"+htmlSer+"</div> \
					<div class='note "+claseNotas+"'> \
						<i class='icon-note'></i> \
						<span class='text_note'>"+nota+"</span> \
					</div> \
				</div>";return html},service:function(data){return"\
				<div class='servicio'>\
					<i class ='icon-angle-right'></i>\
					<span class='codigo' des_codigo='"+data.descripcion+"' \
					id_codigo = '"+data.id+"' tiempo = '"+data.tiempo+"'>"+data.codigo+"</span>\
				</div>\
			"},color:function(callback){var $sec=$("#main"),dias=$sec.find('.dia'),agendas=($sec.find('thead th').length)-1,color='',colorPares=new Array(),colorImpares=new Array(),$lstClientes=$('#lstClientes')
dias.each(function(){$(this).find('color1').removeClass('color1').end().find('color2').removeClass('color2').end().find('color3').removeClass('color3').end().find('color-red').removeClass('color-red')
let idCita=0;$(this).find('.lbl').each(function(){let a=$(this).parent().attr('agenda'),id=$(this).find('.nombre').attr('id'),colorCliente=$lstClientes.find('option[data-id="'+id+'"]').data('color')
if(!$.isEmpty(colorCliente)){$(this).css('background-color',colorCliente)}else{if(a%2==0){if(colorPares[a]=='undefined')colorPares[a]='color1'
color=colorPares[a]
colorPares[a]=colorPares[a]=='color1'?'color2':'color1'}else{if(colorImpares[a]=='undefined')colorImpares[a]='color2'
color=colorImpares[a]
colorImpares[a]=colorImpares[a]=='color1'?'color2':'color1'}
$(this).removeClass('color1 color2 color3 color-admin').addClass(color)}
var tiempo=Math.ceil($(this).attr('tiempo')/15),servicios=$(this).find('.servicio').length})})
typeof callback=="function"&&callback()},style:function(){let w=($('#main th').is(':visible'))?$('#main th').first().width():this.width;$('.lbl').css('z-index',2).width(w-3);this.width=w;this.color()},delete:function(data,nomens=!1,callback){let idCita=(typeof data==='object')?data.idCita:data,$this=$('#idCita_'+idCita),_del=function(){$this.hide('explode',1000,function(){$this.remove()})
admin.lbl.color()
return!0},r=(nomens||confirm('Desea eliminar la cita con id: '+idCita+' ?'))?_del():!1;typeof callback=="function"&&callback();return r},draggable:function($this){$this.draggable({handle:$this.find('.fnMove'),disabled:!1,opacity:0.50,zIndex:100,revertDuration:500,revert:function(ob){if(ob==!1){$('.ui-draggable-dragging').remove()
$('#'+admin.lbl.idLastCelda).html(admin.lbl.clone)
admin.lbl.draggable(admin.lbl.clone)
return!0}},start:function(e,ui){admin.lbl.clone=$this.clone().removeClass('ui-draggable-dragging').css('opacity',0.8)
admin.lbl.idLastCelda=$this.parents('.celda').attr('id')
$this.removeClassPrefix('row_').addClass('row_1')},})},droppable:function(){$(".celda").droppable({accept:".lbl",classes:{"ui-droppable-hover":"ui-state-hover"},drop:function(event,ui){var posi=$(this).position()
var drag=ui.draggable
var css_margin=1;var idCita=drag.attr('idcita')
var idCelda=$(this).attr('id')
let $last=$('#'+admin.lbl.idLastCelda),lbl=admin.lbl
if(idCelda!=admin.lbl.idLastCelda&&confirm('Desea modificar la cita ')){drag.animate({'top':posi.top+css_margin+'px','left':posi.left+css_margin+'px'},200,function(){})
$(this).find('.fnCogerCita').remove().end().append(lbl.clone)
lbl.style()
$last.append('<i class="icon-plus fnCogerCita"></i>').find('.lbl').remove()
admin.edit(idCita,idCelda)
lbl.draggable($(this).find('.lbl'))}else{drag.draggable("option","revert",!0)
$('.ui-draggable-dragging').remove()
$last.append(admin.lbl.clone)
lbl.draggable($last.find('.lbl'))}
admin.lbl.clone=null},})},resize:function($this){var tamanyoNota=Math.ceil($this.find('.text_note').height()/$('.celda:visible').first().height())
var unidadTiempo=Math.ceil($this.attr('tiempo')/15),totalServicios=$this.find('.servicio').length+tamanyoNota+1
if(unidadTiempo<totalServicios)
if($this.hasClass('initial')){$this.removeClass('initial').find('.icon-angle-up').removeClass('icon-angle-up parpadear').addClass('icon-angle-down').end().removeClassPrefix('row_',{duration:500}).addClass('row_'+unidadTiempo,{duration:500})
if($this.hasClass('with_6'))
$this.find('.icons_crud').hide()}else{$this.find('.icon-angle-down').removeClass('icon-angle-down').addClass('icon-angle-up parpadear').end().removeClassPrefix('row_',{duration:500}).addClass('initial row_'+totalServicios,{duration:500})
if($this.hasClass('with_6'))
$this.find('.icons_crud').css('display','inline-block')}}},mostrarCapa(capa,callback){let lastLayer=$('#admin section.activa').attr('id')
if(typeof(window[lastLayer].exit)==='function')window[lastLayer].exit()
var data={controller:capa,fecha:Fecha.sql,},$capa=$('#'+capa),$menu=$('#mySidenav')
$('.app-bar-pullmenu ').hide('blind');$menu.find('.selected').removeClass('selected')
$menu.find('[data-capa="'+capa+'"]').addClass('selected')
if($capa.hasClass('activa'))return!1;$('#chckOpUsersDel').prop("checked",!1);$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja');if($capa.is(':empty')){$.post(INDEX,data,function(html){$('#'+capa).html(html).promise().done(__INIT__);function __INIT__(){}
main.scripts.load(capa,typeof callback=='function'&&function(){callback($('#'+capa))})},'html')}else{if($('#config').is(':visible')&&config.change)config.guardar();if($('#agendas').is(':visible')&&agendas.change)agendas.guardar();typeof callback=="function"&&callback($('#'+capa))}
$('.capasPrincipales.activa').hide().removeClass('activa')
$capa.fadeIn().addClass('activa')
menu.status(capa)
if(capa=='main')$('#'+Fecha.id).show()
$('html,body').animate({scrollTop:0},500)},pass:function(pass,rpass,opass){var
$dlg=$('#dlgCambiarPass'),$pass=$dlg.find('#pass'),pass=$pass.val(),$rpass=$dlg.find('#repeatPass'),rpass=$rpass.val(),$oldPass=$dlg.find('#oldPass'),opass=$oldPass.val()
data={controller:'password',action:EDIT,pass:Tools.SHA(pass),oldPass:Tools.SHA(opass)}
if(pass!=undefined&&pass===rpass){$.post(INDEX,data,function(r,textStatus,jqXHR){if(r.success){notify.success('Password cambiado con exito')
dialog.close()}else{$oldPass.removeClass().addClass('input-error')
notify.error('Error en passwords!!')}
btn.load.hide()},'json')}else{$pass.removeClass().addClass('input-error')
$rpass.removeClass().addClass('input-error')
btn.load.hide()}}},menu={nav:{open:(estado=null)=>{if(!$.isEmpty(estado)){estado=estado>2?0:estado
localStorage.setItem("menuOpen",estado)}else{if($.isEmpty(localStorage.getItem("menuOpen"))){localStorage.setItem("menuOpen",1)}
return parseInt(localStorage.getItem("menuOpen"))}},estado:(estado)=>{let w=0,border=6;if(Device.isCel()&&estado>1){localStorage.setItem("menuOpen",0)
estado=0}
switch(parseInt(estado)){case 1:w=50
$('#mySidenav').width(w).find('a').width(20).end().find('.caption').hide();if(!Device.isCel()){$('#sections').width((admin.ancho-w-border)).animate({'left':w})}
localStorage.setItem("menuOpen",1)
break;case 2:w=145
$('#mySidenav').width(w).find('a').width('110px').end().find('.caption').show()
if(!Device.isCel()){$('#sections').width((admin.ancho-w-border)).animate({'left':w})}
localStorage.setItem("menuOpen",2)
break;default:w=0
$('#mySidenav').width(w)
$('#sections').removeAttr('style')
localStorage.setItem("menuOpen",w)}
admin.lbl.style()},charm:{icon:'',btn:new Object,idBtnOpen:'',toggle:function($btn){this.btn=$btn
if(this.idBtnOpen==''){this.open()}else{let open=this.idBtnOpen
this.close()
if(open!=$btn.attr('id'))this.open()}},close:function(){let $btn=$('#'+this.idBtnOpen),$frm=$('#'+$btn.data('frm'))
$frm.hide('slide',{direction:'right'})
$btn.find('i').removeClass().addClass(this.icon)
this.idBtnOpen=''},open:function(){let $btn=this.btn,$frm=$('#'+$btn.data('frm'))
$frm.show('slide',{direction:'right'})
this.icon=$btn.find('i').attr('class')
$btn.find('i').removeClass().addClass('lnr-cross')
this.idBtnOpen=$btn.attr('id')}},btn:{save:{off:function(){$('#btnSave').find('i').removeClass().addClass('icon-floppy')},switch:function(){if($('#btnSave').find('.lnr-sync').length){$('#btnSave').find('i').removeClass().addClass('icon-floppy')}else{$('#btnSave').find('i').removeClass().addClass('lnr-sync animate-spin')}}}}},status:function(capa){var add=$('#btnAdd'),reset=$('#btnReset'),search=$('#btnSearch'),save=$('#btnSave'),show=$('#btnShow'),edit=$('#btnEdit'),options=$('#btnOptions'),del=$('#btnDel'),calendar=$('.contenedor-datepicker'),df={options:!0}
options.find('li').addClass('disabled')
$('#tools').find('.app-bar-element:visible').hide()
$('.contenedor-datepicker').hide()
switch(capa){case 'main':menu.enabled(show,calendar)
break;case 'crearCita':break;case 'usuarios':menu.enabled(add,search)
break;case 'servicios':menu.enabled(add,search)
break;case 'config':menu.enabled(save)
break;case 'familias':menu.enabled(add)
break;case 'horarios':menu.enabled(add,save,del)
break;case 'agendas':menu.enabled(save)
break;case 'festivos':menu.enabled(add);break;case 'general':menu.enabled(save);break;case 'estilos':menu.enabled(save);break;case 'notas':menu.enabled(calendar)
break
case 'historial':menu.enabled(calendar)
break
case 'search':menu.enabled(search)
break
case 'calendar':menu.enabled(calendar)
break}
if(df.options)options.find('#rowsHiddens').removeClass('disabled')
$('#navbar').resize()},save:function(){var _loadShow=function(){$('#btnSave').find('i').removeClass().addClass('lnr-sync animate-spin')}()
var _loadHide=function(){$('#btnSave').find('i').removeClass().addClass('icon-floppy')}
switch($('.capasPrincipales.activa').attr('id')){case 'config':config.guardar(_loadHide)
break;case 'horarios':horarios.guardar(_loadHide);break;case 'agendas':agendas.guardar(_loadHide);break;case 'festivos':festivo.guardar(_loadHide);break;case 'general':general.guardar(_loadHide);break;case 'estilos':estilos.save(_loadHide);break;case 'notas':notas.save(_loadHide)
break}},show:function(){switch($('.capasPrincipales.activa').attr('id')){case 'main':admin.inactivas.click()
break}},edit:function(){switch($('.capasPrincipales.activa').attr('id')){case '':break}},add:function(){switch($('.capasPrincipales.activa').attr('id')){case 'agendas':agendas.add();break;case 'usuarios':usuarios.dialog(-1);break;case 'servicios':servicios.dialog(-1);break;case 'familias':familias.dialog(-1);break;case 'horarios':horarios.nuevo()
break
case 'festivos':festivo.dialog(-1)
break
case 'notas':notas.dialog(-1)
break}},del:function(){switch($('.capasPrincipales.activa').attr('id')){case 'horarios':horarios.del();break}},reset:function(){switch($('.capasPrincipales.activa').attr('id')){case 'main':admin.refresh('main',function(){$('#btnReset .animate').hide()})
break}},disabled:function(){for(let i=0;i<arguments.length;i++)
arguments[i].hide(100)},enabled:function(){for(let i=0;i<arguments.length;i++){arguments[i].css('display','inline-table')}},load:function(){menu.exit()},exit:function(){$('#txtBuscar').val("").parent().hide('slide',{direction:'right'});$('#btnSearch').find('i').removeClass().addClass('lnr-magnifier').end().find('span').text('Buscar')},options:function($this){if($('#btnOptions #chckOpUsersDel').is(':checked'))
$('.ocultar_baja').removeClass('ocultar_baja').addClass('mostrar_baja');else $('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja');servicios.init()},buscar:function(txt,sec){$sec=$("#"+sec)
$encontrados=txt.match(/^@$/)?$sec.find('.email:contains('+txt+')'):$sec.find('.busqueda:contains('+txt+')')
if($encontrados.length){$sec.find("tbody tr").hide().end()
$encontrados.parents('tr').show()}else{$sec.find("tbody tr").hide()}
colorear_filas($('.colorear-filas:visible'))}},notas={days:[Fecha.general],nombreDlg:'dlgNotas',$template:null,dir:'right',init:function(){this.show()},dialog:function(id=-1){var _load=function(){var $dlg=$('#'+notas.nombreDlg)
$dlg.find("#id").val(id)
if(id==-1){$dlg.find('#fecha').val(Fecha.sql).end().find('#hora').val('00:00').end().find('#descripcion').val('').end().find('h1').html('Nuevo...')}else{var $nota=$("#notas #"+id),fecha=Fecha.general,hora=$nota.find(".hora span").text(),des=$nota.find(".contenido span").text()
$dlg.find('#fecha').val(Fecha.sql(fecha.trim())).end().find('#hora').val(hora.trim()).end().find('#descripcion').val(des).find('h1').html('Editando...')}}
dialog.open(notas.nombreDlg,notas.save,()=>notas.delete($('#dlgNotas #id').attr('value')),_load)},save:function(callback){var $dlg=$('#dlgNotas'),data={id:$dlg.find('#id').val(),nota:$dlg.find('#descripcion').val(),fecha:$dlg.find('#fecha').val(),hora:$dlg.find('#hora').val(),controller:'notas',action:SAVE}
$.post(INDEX,data,function(r,textStatus,jqXHR){if(r.success){dialog.close(this.nombreDlg)
data.id=(data.id>-1)?data.id:r.id;notas.create(data)
notify.success('Su nota ha sido guardada')}else{notify.error('No se ha podido guardar la nota')
echo(r)}
typeof callback=="function"&&callback()},'json')},delete:function(id){let data={controller:'notas',action:DEL,id:id}
$.post(INDEX,data,function(r){if(r.success){$("#notas #"+id).hide('explode',1000).remove()
dialog.close('dlgNotas')}else{notify.error('No se ha podido eliminar la nota')
echo(r)}},'json')},load:function(fecha){let data={controller:'notas',action:GET,fecha:fecha}
if(this.days.includes(Fecha.general)){this.show()}else{$.post(INDEX,data,function(r){notas.days.push(Fecha.general)
notas.show()
if(r.success){for(let i=0,datos=r.data,len=datos.length;i<len;i++){notas.create(datos[i])}}else{$('#menu5').removeClass('c4')}
return r.success},'json')}},create:function(d){Tools.template(notas,'row.notas.php',function(r){$('#mySidenav #menu5').addClass('hay-nota')
notas.$template.clone().hide().addClass(Fecha.id).attr('id',d.id).find('.hora span').text(d.hora).end().find('.contenido span').text(d.nota).end().prependTo('#notas').show('fade')})},show:function(){let $sec=$('#notas'),$noteDay=$sec.find('.'+Fecha.id)
$sec.find('.nota').addClass('hide')
$noteDay.removeClass('hide')
$('#mySidenav #menu5.hay-nota').removeClass('hay-nota')
if($noteDay.length)$('#mySidenav #menu5').addClass('hay-nota')},edit:function(d){this.delete(d.id)
this.create(d)}}
$('body').on('click',".idDateAction",function(){if(!$(this).data('disabled')){sincronizar($(this).data('action'))}}).on('click','#boton-menu',function(){let estado=parseInt(localStorage.getItem("menuOpen"))+1;menu.nav.open(estado);menu.nav.estado(estado)}).on('click','#btnCambiarPass',function(){console.log("Abriendo cambio pass ...")
dialog.open('dlgCambiarPass',admin.pass)}).on('click','.close',function(e){dialog.close()}).on('change','input',function(){$(this).removeClass('input-error')}).on('change','#lstSerSelect',function(){let id=$(this).val();$('#lstSerSelect').each(function(){$(this).find('option[value='+id+']').attr('selected','selected')})})