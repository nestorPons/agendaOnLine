var agendas = { 
	change: false ,
	reload : false, 
	confirmChanges : false, 
	init : function(){
		$('#agendas')
			.on('#cancelar',function(){dialog.close()})
			.on('submit','#frmAg',function(e){
				e.preventDefault();
				guardarAgenda()
			})
			.on('change','input',function(){
				agendas.change =  true;
			})
			.on('click','.fnDel',function(){
				agendas.del($(this).attr('id'))
			})
			.on('click','#nuevaAgenda',function(){
				let i =  -1; 
				$('#frmAg').find('.template').clone()
					.removeClass('template')
					.find('i').attr('id', i).end()
					.find(':text').attr('id', 'nameAgendaConfig'+i).end()
					.find(':checkbox').attr('id', 'a'+i).attr('value', i).end()
					.find('label').attr('for', 'a'+i).end()
					.appendTo('#frmAg');
				agendas.reload = true;
			})
		this.confirmChanges = false
	 },
	 exit : function(){
		if (this.confirmChanges) this.guardar()
	 }, 
	del: function (id) {
		if(
		 confirm("Realmente desea borrar la agenda? \n No se podran recuperar los datos.")
		){	
			$('#frmAg').find('#'+id).parents('.contenedor-agenda').hide('explode')
			this.confirmChanges = true; 
			this.reload = true;
		}
	 }, 
	guardar: function (){
		let
			$frm = $('#agendas #frmAg'), 
			$destroy = new Array, 
			data = {
				id: new Array(), 
				nombre: new Array(), 
				chck: new Array(), 
				save: new Array(), 
				controller: 'agendas', 
				action: SAVE
			};
		
		this.confirmChanges = false

		$frm.find('.contenedor-agenda').not('.template').each(function(i) {
			data.id[i] = $(this).find('.fnDel').attr('id')
			data.nombre[i] = $(this).find('.nombre').val()
			data.chck[i] = $(this).find('.mostrar').is(':checked')?1:0
			data.save[i] = ($(this).is(':visible'))? 1 : 0;
			if (!$(this).is(':visible')) $destroy.push($(this))
		})
			
		$.ajax({
			type: "POST",
			dataType: "json",
			data: data,
			url:INDEX
		})
		.done(function(r){
			if (r.success) {
				if(agendas.reload){
					this.reload = false 
					admin.reload()
				} else {
					notify.success('Los cambios han sido guardados')
					agendas.change = false

					let len = data.id.length - 1 , 
						$frmCrearCita =  $('#crearCita #frmCrearCita'),
						$main =$('#main .encabezado');
					
					for(let i = 0; i <= len  ; i++){
						
						let n = i + 1, 
						$lblCrearCita = $frmCrearCita.find('#lblAgenda'+n), 
						$lblMain = $main.find('#nombreAgenda'+n); 
						
						agendas.set.name(data.id[i],data.nombre[i]) 

						if(!$.isEmpty(data.nombre[i])){
							$lblMain.html(data.nombre[i])
							$lblCrearCita.html(data.nombre[i])
						}
					}
				}
				notify.success('Cambios guardados con éxito!')
			} else {
				notify.error('No se pudieron guardar los cambios')
			}
			
			// Elimino el dom de las aagendas borradas 
			if($destroy.length) { 
				$destroy.forEach(function($e){
					$e.remove()
				})
			}
		})
	
	 },
	guardarNombre: function(data){
		
		data.controller = 'agendas'
		data.action = 'saveName'

		$.post(INDEX,data,function(r){
			agendas.set.name(data.id, data.nombre)
		},'json')

	 }, 
	set: {
		name: function(id, value){

			admin.set.nameAgenda(id,value)

			if(general.loaded.includes('crearCita')) crearCita.set.nameAgenda(id,value)

			if(general.loaded.includes('horarios')) horarios.set.nameAgenda(id,value)

			if(general.loaded.includes('config')) config.set.nameAgenda(id,value)
		}
	 }
	
 } 
main.scripts.loaded.push('agendas');