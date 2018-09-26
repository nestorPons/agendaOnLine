var crearCita={isLoad:!0,data:new Object(),init:function(){var clase=$('#crearCita .contenedorServicios tbody tr').attr('class');$('#btnSearch').hide()
$('#crearCita').on('click','a',function(){crearCita.servicios.mostrar($(this).attr('id'))}).on('click','.idServicios',function(){let id=$(this).data('familia')
$('#crearCita .menuServicios').each(function(){$(this).find('.c3').removeClass('c3').end().find('#'+id).addClass('c3')})}).on('click','.horas',function(){crearCita.data.hora=$(this).val()}).on('change','.lstServicios ',function(){crearCita.servicios.mostrar($(this).val())}).on('click','.horas',crearCita.dialog).on('click','.siguiente',function(e){crearCita.stepper($('div [id^="stepper"]:visible').data('value')+1)}).on('click','[name="agenda[]"]',function(){crearCita.data.agenda=$(this).val()}).on('change','#crearCitaNota',function(){crearCita.data.nota=$(this).val()}).on("swipeleft",'.tablas').on('click','.cancelar',function(){main.mostrarCapa('main')})
if(!$.isEmpty(clase)){var clase_id=clase.replace(/\D/g,'');crearCita.servicios.mostrar(clase_id)}},set:{nameAgenda:function(id,name){$('#crearCita #lblagenda'+id).text(name)}},servicios:{buscar:function(val){var $sec=$('#crearCita'),$conSer=$sec.find('.contenedorServicios')
if($sec.is(':visible')){$conSer.find('tr').hide().find('.descripcion:contains("'+val+'")').parents('tr').show()}},mostrar:function(id_familia,no_validate){var id=id_familia,no_validate=no_validate||!1
if(no_validate&&$('#servicios .fam'+id).is(':visible')||$('#crearCita .fam'+id).is(':visible'))return!1;var id=$.isEmpty(id)?0:id;$('.contenedorServicios').each(function(){var $this=$(this)
$this.find('tbody tr').hide(function(){$this.find('.fam'+id).show()})})
$('.menuServicios').each(function(){$(this).find('.c3').removeClass('c3').end().find('#'+id).addClass('c3')})},init:function(){var clase=$('.menuServicios a').not('.ocultar_baja').attr('id');if(!$.isEmpty(clase)){clase_id=clase.replace(/\D/g,'')
crearCita.servicios.mostrar(clase_id)}},},user:{save:function(){if(typeof usuarios.guardar=='undefined')
$.getScript("/js/usuarios.js",function(){usuarios.guardar()})
else usuarios.guardar()}},dialog:function(){var $sec=$('#crearCita'),idSer=new Array(),strServ="",_cancel=function(){crearCita.data.hora=null
$('.horas:checked').prop('checked',!1)
dialog.close()}
$sec.find('[name="servicios[]"]:checked').each(function(){strServ+=$(this).attr('id')+", "
idSer.push($(this).val())})
dialog.open('dlgGuardar',crearCita.guardar,_cancel,function(){strServ=strServ.slice(0,-2)
data={fecha:Fecha.general,hora:crearCita.data.hora,agenda:crearCita.data.agenda,servicios:idSer,nota:crearCita.data.nota,tiempo_servicios:parseInt($sec.find('#tSer').text())}
$.extend(crearCita.data,data)
$('#dlgGuardar').find('#lblhora').html(data.hora).end().find('#lblfecha').html(Fecha.print()).end().find('#lblcliente').html(crearCita.data.nombre).end().find('#lblSer').html(strServ)})},guardar:function(){var self=crearCita
self.data.lastMod=Fecha.now()
self.data.controller='cita'
self.data.action='save'
if(self.validate.form()){$.post(INDEX,crearCita.data,function(rsp){if(rsp.success){if(rsp.ocupado){notify.error(rsp.mns.body,rsp.mns.tile)}else{self.data.idCita=rsp.idCita
self.data.idUsuario=rsp.idUser
self.data.servicios=rsp.services
self.data.nota=crearCita.data.nota
admin.lbl.create(self.data)
$('#crearCita').find('.dia').remove()
admin.mostrarCapa('main')}}else{echo(rsp)
notify.error('Error inesperado')}
dialog.close('dlgGuardar')},'json').fail(function(jqXHR,textStatus,errorThrown){notify.error(jqXHR+'<br/>'+textStatus+'<br/>'+errorThrown);return!1})}else{notify.error('Complete todos los datos')
return!1}},horas:{iniciar:function(){if(!$('#crearCita #tablas table').length)cargarDatepicker();for(let i=0;i<=config.margenDias;i++){var date=Fecha.calcular(i,Fecha.id)
crearCita.horas.crear(Fecha.number(date))}},hide:function(){console.log('ocultando horas...')
$('#crearCita').find('#tablas.tblhoras').hide()},show:function(){console.log('mostrando horas...')
$('#crearCita').find('#tablas.tblhoras').show()},load:function(){var tiempoServicios=0,lblTS=$('#tSer'),$sec=$('#crearCita'),serviciosSeleccionados=$sec.find('.idServicios:checked')
serviciosSeleccionados.each(function(){tiempoServicios+=$(this).data('time')})
lblTS.text(tiempoServicios)
crearCita.horas.pintar(Fecha.id,tiempoServicios)
if(!$.isEmpty(crearCita.data.hora)){$('#crearCita .dia.activa').find('.horas[value="'+crearCita.data.hora+'"]').prop('checked',!0)
crearCita.dialog()}},crear:function(id_table){let that=this,data={agenda:crearCita.data.agenda,fecha:id_table,controller:'crearCita.horas'}
if($('#crearCita #'+id_table).length)$('#crearCita #'+id_table).remove()
that.hide()
$.post(INDEX,data,function(html){var m=document.getElementById('tablas')
m.innerHTML=html
crearCita.horas.load()
that.show()})},pintar:function(id_table,tiempoServicios=0){var $sec=$('#crearCita'),ts=parseInt(Math.ceil(tiempoServicios/15)),$dia=$sec.find('#'+id_table),$horas=$dia.find('.horas'),count=ts-1
$dia.removeClass('reservado').find('input').attr('disabled',!1)
for(let i=$horas.length-1;i>=0;i--){let $this=$dia.find('#hora'+i)
if($this.hasClass('ocupado'))count=ts
if(count>0)$this.attr('disabled',!0).parent('label').addClass('reservado')
count--}},sincronizar:function(){crearCita.horas.crear(Fecha.id)},},exit:function(){$('#step0').show()
$('#crearCita').find('.dialog').hide().end().find('.steperCapa').hide().end().find('#stepper0').show().end().find('input[name="servicios[]"]:checked').each(function(){$(this).prop('checked',!1)}).end().find('input[name="hora[]"]:checked').prop('checked',!1).end().find('#nombre').removeClass('input-success').removeClass('input-error').end().find('#cliente').val("").removeClass('input-error').end().find('#crearCitaNota').val("").end().find('[name="agenda[]"]').attr('checked',!1).first().prop('checked',!0)
$('#dlgGuardar').find('#lblSer').empty().end().find('#lblHora').empty().end().find('#lblFecha').empty().end().find('#lblSer').empty().end().find('#lblCliente').empty()
crearCita.data=new Object;sessionStorage.removeItem('hora')
sessionStorage.removeItem('agenda')
dialog.close('dlgGuardar')},stepper:function(index){var $visible=$('.steperCapa:visible')
var $stepper=$('#stepper'+index)
if($visible.attr('id')==$stepper.attr('id'))return!1
if(!$stepper.is(':visible')&&$visible.length){if(index==0){_slider()}else if(index==1&&crearCita.validate.name()){menu.status('search')
$('.tblHoras').show()
crearCita.data.agenda=$('#crearCita').find('input[name="agenda[]"]:checked').val()
_slider(crearCita.servicios.init)}else if(index==2&&crearCita.validate.service()){menu.status('calendar')
!$('#crearCita').find('#'+Fecha.id).length&&crearCita.horas.sincronizar()
crearCita.validate.name()&&_slider()}}
function _slider(callback){var dir=$visible.data('value')>0||1
var dirEntrada=index-dir<0?'right':'left'
var dirSalida=dirEntrada=='right'?'left':'right'
$('.stepper').find('li').removeClass('current').end().find('#step'+index).addClass('current');$('#crearCita').find('.steperCapa').hide()
$visible.hide("slide",{direction:dirSalida},750,function(){$stepper.removeClass('hidden').show("slide",{direction:dirEntrada},750,function(){$('.tile-active').height('auto')})})
typeof callback=="function"&&callback()}},validate:{form:function(){return $('#crearCita [name="servicios[]"]:checked').length!==0&&$('#crearCita #cliente').val()!==""&&crearCita.data.hora!='undefined'},name:function(){let $this=$('#crearCita #cliente'),cliente=$this.val().trim();if(cliente!=""){let str=normalize(cliente)
var selCli=$('#lstClientes [data-name="'+str+'"]')
if(selCli.length==0){$this.addClass('input-error');dialog.open('dlgUsuarios',crearCita.user.save,null,function(){$('#dlgUsuarios').find('#id').val(-1).end().find('#nombre').val($('#crearCita #cliente').val()).end().find('h1').text('Nuevo usuario')})}else{crearCita.data.idUser=selCli.data('id')
$('#crearCita #lblCliente').html($this.val())
$this.removeClass('input-error').addClass('input-success');crearCita.data.nombre=cliente
return!0}}else{$this.addClass('input-error').removeClass('input-success');$this.popover('show');return!1}},service:function(){$('#crearCita #lblSer').empty();var $ser=$('#crearCita [name="servicios[]"]:checked');if($ser.length==0){$('#login #crearCita [name="stepperServicios"]').popover('show');return!1}else{$ser.each(function(i,v){var txtSer=$(this).attr('id');$('#crearCita #lblSer').append(txtSer+', ')})
return!0}}},}
main.scripts.loaded.push('crearCita')