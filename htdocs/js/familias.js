var familias = {
	isLoad : true, 
	change : false , 
	controller : 'familias', 
	data : new Object ,
	init : function(){
		$('#familias')
		.on('click','table .icon-edit',function(){
			familias.dialog($(this).attr('value'));
		 })
		.find('input[name*="mostrar"]')
			.change(function(){
				var mostrar = ($(this).is(':checked'))?1:0;
				var id = $(this).attr('id');
				familias.chckGuardar(id, mostrar);
			})
		colorear_filas($('#familias').find('.colorear-filas'))
	}, 
	eliminar : function () {
		var id = $('#dlgFamilias #id').val(), del = false
			nombre = $('#dlgFamilias #nombre').val()

		btn.load.show($('#dlgFamilias .cancelar'),false)

		if (confirm ('Desea eliminar la familia?')) 
			familias.sendAjax(DEL , r =>{
				if (r.success == true){
					if (del){		
						familias.menu.eliminar( id ) 
					}else{

						familias.menu.ocultar( id ) 

						var baja = ($('#chckOpUsersDel').is(':checked'))?'mostrar_baja' : 'ocultar_baja'
						
						if (id>=0) $("#rowFamilias"+id).addClass(baja) 
					}
				}else{

					$("#familias #rowFamilias"+id).fadeTo("slow", 1)
					notify.error( r.success ) 
						
				}
				$("#familias rowFamilias"+id).fadeTo("fast", 1)				

				dialog.close('dlgFamilias')
			})
		 else
			btn.load.hide() 
		
		
	 },
	guardar :function (){
		btn.load.show($('#dlgFamilia .aceptar'),false)
		var  dlg = $('#dlgFamilias') , id = dlg.find('#id').val()
		var _fnOk = function (r) {
			if (r.success){
				if (id == -1){
					//NUEVO
					
				}else{
					//EDICION
					familias.obj.edit(r);

				}
				
				dialog.close('dlgFamilias');
			}else{
				notify.error( r.err , 'Error!! ')
			}

				$("#rowFamilias"+id).fadeTo("fast", 1);
		}

		if (id == -1 ){
			(familias.validate.form()) ? familias.sendAjax(SAVE , _fnOk) : btn.load.hide();

		 }else{
			if ($.isEmpty(dlg.find('#nombre').val()))
				notify.error('El campo del nombre no puede estar vacio.','ERROR CAMPO VACIO!')
			else	
				familias.sendAjax(EDIT , _fnOk)
		 }
		
	 },
	sendAjax : function(action , callback){
			var  dlg = $('#dlgFamilias') , id = dlg.find('#id').val()
			var	data = $("#frmEditarFamilia").serializeArray()			
				data.push({name : 'controller' , value : familias.controller})
				data.push({name : 'action' , value : action})

			if (dlg.find('.aceptar').text() == 'Restaurar' && action == SAVE)
				data.push({name : 'baja' , value : 0})
			
			if (action == DEL)
				data.push({name : 'baja' , value : 1})
			

			$.ajax({
				type: "POST",
				dataType: "json",
				data: data, 
				url: INDEX,
				beforeSend: function(){if (id>=0)$("#rowFamilias"+id).fadeTo("slow", 0.30)}
			})
			.done(function(r){ 
				typeof callback == "function" && callback(r)
			})
			.fail(function( jqXHR, textStatus, errorThrown){
				notify.error(jqXHR + '<br/>' +  textStatus + '<br/>' + errorThrown);
				return false;
			})
	 },
	menu : {
		a : function(id , name) {
			return  $('<a>').attr('id', id).html( name ) ;
		},
		editar : function ( id ,  nombre ){
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).remove();
				$(this).find('#lstSerSelect').find('#'+id).remove();
			})
			familias.menu.crear( id , nombre ) ; 

		},
		eliminar : function( id ,callback ){
			$("#rowFamilias"+id).remove()
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).remove()
				$(this).find('#lstSerSelect').find('#'+id).remove()
			 })
			$('#sevicios .fam' + id ).remove() 
			$('#crearCita .fam' + id ).remove() 
			typeof callback == "function" && callback()
		},
		ocultar : function ( id ,callback ) {
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).addClass('ocultar_baja');
				$(this).find('#lstSerSelect').find('#'+id).addClass('ocultar_baja');
			 })
			$('#sevicios .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
			$('#crearCita .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
			typeof callback == "function" && callback();
		},
		crear : function (id, name ) {

			$('#lstSerMain').each(function(){
				$(this).append(familias.menu.a(id ,name))
			})
			$('#lstSerSelect').each(function(){
				$(this).append(familias.menu.option(id , name))
			})

		},

		option : function (id , name  ) {
			return $('<option>').attr('id', id ).val(id).html( name ) ;
		 },

	 }, 
	dialog: function (id){
		var fnLoad = function (isNew) {
			var dlg = $('#dlgFamilias')
			if (id!=-1){
				dlg
					.find ('#id').val(id).end()
					.find("#nombre").val($('#familias #rowFamilias'+id + ' .nombre ').html()).end()
					.find("#mostrar").attr('checked', $('#familias #chck'+id).prop('checked'));
			}
			if ($('#familias #rowFamilias'+ id ).hasClass('mostrar_baja')) {
				dlg.find('.aceptar').html('Restaurar')
			}
			dlg.find("#id").val(id);
		}
		dialog.open('dlgFamilias',familias.guardar,familias.eliminar,fnLoad)

	 },
	validate : {
		form : function () {  
			var valNom = $('#dlgFamilias #nombre').val(); 
			if ($.isEmpty(valNom)){
				notify.error('El campo del nombre no puede estar vacio.','ERROR CAMPO VACIO!')
				return false ;
			}else {
				return true ;
			}
		 }

	 },
	obj : {
		create : function(data){
			let mostrar = (data.mostrar==1)?'checked':'', 
				id = data.id, 
				nombre = data.nombre 

			$("#familias table").append("\
				<tr id='rowFamilias"+id+"'>\
				<td><a name='editar[]' class= 'icon-edit x6' value="+id+"></a></td>\
				<td id='familia_"+ id + "' class='nombre'>"+nombre+"</td>\
				<td class='ico'>\
				<input type='checkbox' name = 'mostrar[]' id='chck"+id+" class='mostrar'\
				value="+id+" "+ mostrar + "></td></tr>")
			$('#servicios #frmEditar #familia').append("<option value="+id+">"+nombre+"</option>");
			familias.menu.crear( id , nombre ) ;
		}, 
		edit : function(data){
			let estado = (data.mostrar==1)?true:false , 
				$chck = $('#familias #chck'+data.id), 
				id = data.id, 
				nombre = data.nombre
			
			$('#familias #familia_' + id).html(nombre);
			$('#familias #rowFamilias' + id ).removeClass('mostrar_baja , ocultar_baja') ;
			$('#sevicios .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
			$('#crearCita .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;

			$chck.prop("checked",estado);
			$('#servicios #frmEditar #familia option[value='+id+']').html(nombre);

			familias.menu.editar( id , nombre ) ;

		}, 
		delete : function(data){
			familias.menu.ocultar( data.id ) 
			let baja = ($('#chckOpUsersDel').is(':checked'))?'mostrar_baja' : 'ocultar_baja'
			if (data.id>=0) $("#rowFamilias"+data.id).addClass(baja)
			$("#familias rowFamilias"+data.id).fadeTo("fast", 1)
		}

	}
 }
