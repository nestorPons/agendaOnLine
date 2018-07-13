var horario = {
	controller : 'horarios' , 
	section : $('#horarios') ,  
	activo:null,
	nuevo: function(){
		var $sec = $('#horarios'), 
			$lineaHorario = $sec.find('.lineaHorarios').first(),
			numAgenda = $sec.find('#agenda_horario').val()

			$lineaHorario.clone()
				.attr('id','horario_-1')
				.attr('agenda', numAgenda)
				.removeClass('ocultar')
				.appendTo('#frmHorario')
				

	 },
	set:{
		nameAgenda: function(id, val){
			var $sec = $('#horarios'),
				$agendas = $sec.find('#agenda_horario')
				$agendas.find('[value='+id+']').text(val)
				
		}	
	},
	editar: function (){
		var numeroHorario = $('#hor	arios  #nombre option:selected').val();
		$('#horarios .celda-horario').each(function(){
			var n = $(this).attr('name'); //dia y hora
			var est = $(this).hasClass('color1')?1:0;
			HORARIOS[numeroHorario]['h'+n] = est;
		})

		var cargarHoras = (function(callback){
			main.section.find('div.template')
				.clone()
				.removeClass('template')
				.addClass('editando');

			main.section.find(".editando")
				.removeClass('color1 color2 color-red')
				.each(function(){
					var dia = $(this).data('diasemana');
					var fecha = $(this).attr('id');
					fecha = fecha.substr(4);
					for(let i=0;i<=HORARIOS.length-1;i++){//busco horarios por fecha
						if (HORARIOS[i].FechaIni<=fecha&&HORARIOS[i].FechaFin>=fecha){//compruebo en que horario estoy
							for (let h =1; h<=73; h++){
								let hora =  "h"+dia+h;
								HORARIOS[i][hora]==0?$(this).find('.h'+h).addClass('inactiva'):$(this).find('.h'+h).removeClass('inactiva');
							}
							break;
						}
					}
				})
				.removeClass('editando');
			typeof callback == "function" && callback();
		})()
	 },
	guardar: function (callback){

		var	$horarios =$('#horarios '),
			$lineaHorario = $horarios.find('.lineaHorarios'), 
			data = new Object()

			data.action =SAVE
			data.controller = 'horarios'
			data.datos = new Array()

		//if(horario._validate()){
			$lineaHorario.each(function(){
				
				data.datos.push({
					id:	$(this).attr('id').replace('horario_',''),
					agenda: $(this).attr('agenda'),
					dia_inicio: $(this).find('.idDiaInicio').val(),
					dia_fin: $(this).find('.idDiaFin').val(),
					hora_inicio: $(this).find('.idHoraInicio').val(),
					hora_fin: $(this).find('.idHoraFin').val()
				})
			})
			$.post(INDEX,data,function(r){
				if(r.success){
					notify.success('Horario guardado')
					location.reload(true);
				} else {
					notify.error('No se pudo guardare el horario')
				}
			})
	 },
	del: function(){

		var selects = $('#horarios #frmHorario input:checked');

		var data =  {
			controller : 'horarios',
			action : DEL, 
			ids : new Array()
		}		
		
		$.each(selects ,function(){
			data.ids.push($(this).val());
		})

		
		$.post(INDEX,data,function(r){
			if(r.success){
				location.reload();
			}else{
				notify.error('No se ha podido guardar!!')
			}
		}, 'json')
	 },
	 mostrar: function(){
		let $sec = $('#horarios'), 
			val = $sec.find('#agenda_horario').val(), 
			$selects = $sec.find('#frmHorario input:checked')
		//Reseteo los checkbox al cambiar de horario
		$selects.prop('checked',false)

		$sec
			.find('.lineaHorarios').hide().addClass('ocultar')
			.end()
			.find('div[agenda='+val+']').fadeIn().removeClass('ocultar')
	 },
	_validate: function(){
		var $time = $('#horarios #frmHorario .time');
		var return_function = true;
		$.each($time,function(){
			if ($(this).val() == '') return_function = false;
		})
		
		return return_function;
	 },
 }
 $('#horarios').on('click', '#agenda_horario',horario.mostrar)

 horario.mostrar()