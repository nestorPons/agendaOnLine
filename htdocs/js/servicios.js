var servicios = {
	isLoad : true, 
	controller : 'servicios',
	init : function () {
		var clase = $('.menuServicios a').not('.ocultar_baja').attr('id')  ; 
		if (!$.isEmpty( clase )){
			clase_id = clase.replace(/\D/g,'')
			servicios.mostrar(clase_id)
			
		 }
		 $('#servicios')
		 .on('click','.menuServicios a',function(){servicios.mostrar($(this).attr('id'),$('#servicios'))})
		 .on('change','.lstServicios ',function(){servicios.mostrar($(this).val())})
		 .on('change','#familia',function(){familias.change = true})
		 .on( "click", "[name*='editar']", function(e){servicios.dialog($(this).attr('value'))})
		 .find('option:first-child').attr('selected','selected')
		 
	 },
	mostrar: function(id_familia, no_validate) {
		var id = id_familia, no_validate = no_validate || false
		
		if (no_validate && $('#servicios .fam'+ id).is(':visible') || $('#crearCita .fam'+ id).is(':visible')  ) return false ;

		var id = $.isEmpty(id)?0:id

		$('.contenedorServicios').each(function(){
			$(this)
				.find('tbody tr').hide().end()
				.find('.fam'+id).show()		
			
		})

		$('.menuServicios').each(function(){
			$(this)
				.find('.c3').removeClass('c3').end()
				.find('#'+id).addClass('c3');
		})
		colorear_filas($('#servicios table'))
		
	 },
	dialog : function(id){
		var fnLoad = function (isNew) {
			var dlg = $('#dlgServicios')

			if (dlg.find('#lstFamilias select').length==0){
				var $lstFam = 
					$('#servicios .menuServicios #lstSerSelect')
						.clone(true,true)
						.removeClass('responsiveDesing_show')
						.appendTo('#dlgServicios #lstFamilias');
			}
			dlg.find("#id").val(id);
			
			if (id!=-1){ 
				//EDITANDO...
				var row = $("#servicios #rowServicios"+id),	
					cod = row.find("[name='cod']").text(),
					des = row.find("[name='des']").text(),
					time = row.find("[name='time']").text(),
					price = row.find("[name='price']").data("value"),
					fam = row.attr('familia')

				dlg
					.find('#codigo').val(cod).end()
					.find('#descripcion').val(des).end()
					.find('#tiempo').val(parseInt(time)).end()
					.find('#precio').val(price).end()
					.find('#familia').val(fam).end()
					.find('#eliminar').val('Eliminar').end()
					.find('#lstFamilias option[value="'+fam+'"]').prop('selected',true)
					.find('h1').html('Editando...')

			}else{ 
				//NUEVO....
				var idCapa = $('#servicios .c3').attr('id');
				dlg
					.find('#id').val(-1).end()
					.find('#codigo').val($('#servicios #buscarTxt').val()).end()
					.find('#familia').val(idCapa).end()
					.find('#btnEliminar').val('Cancelar').end()
					.find('h1').html('Nuevo...')
			}
			
			if ($('#servicios #rowServicios'+ id ).hasClass('mostrar_baja')) {
				dlg.find('.aceptar').html('Restaurar')
			}
		 }

		dialog.open('dlgServicios',servicios.guardar,servicios.eliminar,fnLoad)
	 },
	guardar: function (){
		var _fnOk = function (rsp , isNew){
				if (rsp.success) {
	
					isNew ?  servicios.crear(rsp)  : servicios.actualizar(rsp) 
	
					servicios.mostrar(rsp.idFamilia)
					
					dialog.close('dlgServicios')
					
				}else{ 
					notify.error('Codigo de servicio ocupado </br> Seleccione otro codigo distinto.', 'CODIGO OCUPADO') ;
				}
				$("#servicios #rowServicios"+id).fadeTo("slow", 1);
				btn.load.hide();
			}
		if(servicios.validate.form()){
			var id= $('#frmEditarServicios #id').val().replace(/\D/g,' ').trim()

			servicios.sendAjax(SAVE , _fnOk)

		  }else{
			btn.load.hide()
		  }		
	 },
	eliminar: function() {

		var id= $('#dlgServicios #id').val().trim(), 
			_fnOk = function (r) {

				if (r.success == true){

					var baja  = $('#chckOpUsersDel').is(':checked')? 'mostrar_baja' : 'ocultar_baja'

					$("#rowServicios"+id).each(function(){
						$(this).addClass(baja) 
					})
		
				}else{

					$("servicios #rowServicios"+id).fadeTo("slow", 1)
					notify.error(r.success) 
				}

				dialog.close('dlgServicios')
			}

		if (id!=-1){
			if (confirm ("Deseas eliminar el servicio "+id+", " + $('#dlgServicios #codigo').val() + "?")) 
				servicios.sendAjax(DEL , _fnOk)

		}else{
			dialog.close('dlgServicios');
		}
	 },
	actualizar: function(datos){
		$('#servicios #rowServicios'+datos.id)
			.css('class','fam'+datos.idFamilia)
			.removeClass('mostrar_baja , ocultar_baja') 
			.attr('name',normalize(datos.codigo))
			.attr('familia',datos.idFamilia)
			.removeAttr('class').addClass('fam'+datos.idFamilia)
			.attr('value',datos.id)
			.find(' td:nth-child(1)').attr('value',datos.id).end()
			.find(' td:nth-child(2)')
				.html(datos.codigo)
				.attr('id', datos.id)
			.end()
			.find(' td:nth-child(3)').html(datos.descripcion).end()
			.find(' td:nth-child(4)').html(datos.tiempo).end()
			.find(' td:nth-child(5)').data('value' , datos.precio).end()

		

		$('#crearCita #rowServicios'+datos.id)
			.removeClass('mostrar_baja , ocultar_baja') 
			.css('class','fam'+datos.idFamilia)
			.find('label')
				.attr('for', datos.codigo)
				.text(datos.descripcion + ' (' + datos.tiempo +'min.)')
			.end()
			.find(':checkbox').attr({
				id : datos.codigo , 
				value : datos.id , 
				'data-time' : datos.tiempo , 
				'data-familia' : datos.idFamilia ,
			})

			// Actualizar en los lbls
			$('.lbl .servicio').each(function(){
				let $span = $(this).find('span'), 
					cod = $span.attr('id_codigo')

				if(cod == datos.id){
					$span
						.attr('des_codigo',datos.descripcion)
						.attr('tiempo',datos.tiempo)
						.attr('title',datos.descripcion)
						.text(datos.codigo)
				}
			})
		
	 },
	crear: function(data){
		//NUEVO
		var mostrar = (data.mostrar==1)?'checked':'';

		// secrea fila
		$('#servicios').find('table tbody').append('\
			<tr id="rowServicios'+data.id+'">\
				<td class="ico"><a name="editar[]" class="icon-edit x6"></a></td>\
				<td name="cod" class="aling-left cod"></td>\
				<td name="des" class="nom"></td>\
				<td name="time" class="ico"></td>\
				<td name="price" class="hidden"></td>\
			</tr>\
		')

		// se crea en crearcita
		$('#crearCita').find('.contenedorServicios tbody').append('\
			<tr id="rowServicios'+data.id+'">\
				<td>\
					<label>\
						<input type="checkbox" name="servicios[]" class="idServicios">\
					</label>\
				</td>\
			</tr>\
		')

		servicios.actualizar(data)
	
	 },
	sendAjax: function(action , callback){
		var dlg = $('#dlgServicios') , id = dlg.find('#id').val() ,row = dlg.find("#rowServicios"+id)
		var	data = $("#frmEditarServicios").serializeArray()			
			data.push({name : 'baja' , value : 0})
			data.push({name : 'controller' , value : servicios.controller})
			data.push({name : 'action' , value : action})
		if (action == DEL)
			data.push({name : 'baja' , value : 1})

		var isNew = id==-1

		id!=-1 && row.fadeTo("slow", 0.30)

		$.ajax({
			url: INDEX,
			type: "POST",
			dataType: "json",
			data: data,
		})
		.done(function(rsp){
			typeof callback == "function" && callback(rsp ,isNew)
		})
		.fail(function( jqXHR, textStatus, errorThrown ) { 
			echo (jqXHR, textStatus,  errorThrown) 
		 })
	 },
	validate : {
		form : function () {  
			var nombre = $('#dlgServicios #codigo').val(); 

			if ($.isEmpty(nombre)){
				notify.error('El campo del codigo no puede estar vacio.','ERROR CAMPO VACIO!')
				return false ;
			}else {
				return true ;
			}
		 }
	 }
 }