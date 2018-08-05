var agendas = {
	change: false ,
	add: function(){
		var data = {
			controller: 'agendas', 
			action: ADD
		 }
		$.post(INDEX,data,function(r){
			if(r)
				location.reload()
			else
				notify.error("No se ha podido crear la agenda.\n\r Consulte con el administrador")
		},'json')
	 }, 
	del: function (id) {
		var data = {
			controller: 'agendas', 
			action: DEL, 
			id : id
		 }
		if(
		 confirm("Realmente desea borrar la agenda? \n No se podran recuperar los datos.")
		){
			$.post(INDEX,data,function(r){
				if(r)
					location.reload()
				else
					notify.error("No se ha podido eliminar la agenda.")
			},'json')
		}
	 }, 
	guardar: function (callback){
		var $frm = $('#agendas #frmAg'), 
			data = {
				id: new Array(), 
				nombre: new Array(), 
				chck: new Array(), 
				controller: 'agendas', 
				action: SAVE
			},
			$datos = $frm.find('div.tr.datos')

		$datos.each(function(i) {
			data.id[i] = $(this).find('span.fnDel').attr('id')
			data.nombre[i] = $(this).find('.col2 input').val()
			data.chck[i] = $(this).find('.col3 input').is(':checked')?1:0
		})

		$.ajax({
			type: "POST",
			dataType: "json",
			data: data,
			url:INDEX
		})
		.done(function(r){
			if (r) {
				notify.success('Los cambios han sido guardados');
				agendas.change = false;
				$('#agendas #frmAg label').each(function(element) {
					var id = $(this).find('input:checkbox').val(), 
						value = $(this).find('input:text').val()
					agendas.set.name(id,value)
				}, this);
				$('#agendas #frmAg input:text').each(function(index){
					var i = index+1;
					var lblMain =$('#main .encabezado #nombreAgenda'+i)
					var lblCrearCita = $('#crearCita #frmCrearCita #lblAgenda'+i)
					var name  = $(this).val();
					if(!$.isEmpty(name)){
						lblMain.html(name)
						lblCrearCita.html(name)
					}
				})
			} else {
				notify.error('No se pudieron guardar los cambios')
			}
		})
		.always(function(r){
			typeof callback == "function" && callback();
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
			main.set.nameAgenda(id,value)
			if(crearCita != 'undefined')crearCita.set.nameAgenda(id,value)
			if(horario != 'undefined')horario.set.nameAgenda(id,value)
			if(config != 'undefined')config.set.nameAgenda(id,value)
		}
	 }
	
 } 
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
		