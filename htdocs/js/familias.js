var familias = {
	change : false , 
	controller : 'familias', 
	data : new Object , 
	eliminar : function () {
		var id = $('#dlgFamilias #id').val(), del = false
			nombre = $('#dlgFamilias #nombre').val(),
			_fnOk = function ( r ){
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
				$("#rowFamilias"+id).fadeTo("fast", 1)

				dialog.close('dlgFamilias')

			}
		btn.load.show($('#dlgFamilias .cancelar'),false)

		if (confirm ('Desea eliminar la familia?')) 
			familias.sendAjax(DEL , _fnOk)
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
					var mostrar = (r.mostrar==1)?'checked':'';
					$("#familias table").append("\
						<tr id='rowFamilias"+r.id+"'>\
						<td><a name='editar[]' class= 'icon-edit x6' value="+r.id+"></a></td>\
						<td id='familia_"+ r.id + "' class='nombre'>"+r.nombre+"</td>\
						<td class='ico'>\
						<input type='checkbox' name = 'mostrar[]' id='chck"+r.id+" class='mostrar'\
						value="+r.id+" "+ mostrar + "></td></tr>")
					$('#servicios #frmEditar #familia').append("<option value="+r.id+">"+r.nombre+"</option>");
					familias.menu.crear( r.id , r.nombre ) ;
				}else{
					//EDICION
					$('#familias #familia_' + r.id).html(r.nombre);
					$('#familias #rowFamilias' + id ).removeClass('mostrar_baja , ocultar_baja') ;
					$('#sevicios .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
					$('#crearCita .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;

					var estado = (r.mostrar==1)?true:false;
					var $chck = $('#familias #chck'+id);
					$chck.prop("checked",estado);
					$('#servicios #frmEditar #familia option[value='+id+']').html(r.nombre);

					familias.menu.editar( r.id , r.nombre ) ;

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
				familias.sendAjax(SAVE , _fnOk)
		 }
		
	 },
	sendAjax : function(action , callback){
			var  dlg = $('#dlgFamilias') , id = dlg.find('#id').val()
			var	data = $("#frmEditarFamilia").serializeArray()			
				data.push({name : 'controller' , value : familias.controller})
				data.push({name : 'action' , value : SAVE})

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
 }
 $('#familias')
 .on('click','table .icon-edit',function(){
     familias.dialog($(this).attr('value'));
 })

 $('#familias input[name*="mostrar"]')
 .change(function(){
	 var mostrar = ($(this).is(':checked'))?1:0;
	 var id = $(this).attr('id');
	 familias.chckGuardar(id, mostrar);
 });
