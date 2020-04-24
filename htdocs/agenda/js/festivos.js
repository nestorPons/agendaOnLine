'strict'
main.scripts.loaded.push('festivos');
var festivo = {
	isLoad : true, 
	init : function(){
		$("#festivos")
		.on('click',"[name='eliminar[]']",function(){festivo.eliminar($(this))})
	}, 
	dialog : function () {
		dialog.open('dlgFestivos',festivo.guardar, festivo.eliminar)
	 },
	eliminar:	function ($this){
		var self = this 
		var id = $this.parent().parent().attr('id');
		var f =  $this.parent().parent().find('[name="mes[]"]').text();

		$('#festivos #'+id).fadeTo("slow", 0.30);
		data = {
			id : id ,
			controller : 'festivos',
			action : DEL
		}
		$.post(INDEX,data,function(){
			$('#festivos #'+id).hide("explode")

			var index = $.inArray(Fecha.md(f),config.festivos)
			if (index>-1) config.festivos.splice(index,1)
		},'json');
	 },
	guardar:	function (callback){
		var nombre = $('#dlgFestivos #nombre').val() ,
			fecha = $('#dlgFestivos #fecha').val() ,
			fila = $('#tblFestivos tr:first').clone(),
			data = {
				nombre : nombre ,
				fecha : fecha 	,			
				controller : festivos ,
				action : SAVE}

		if ( $.isEmpty( nombre , fecha ) ){
			notify.error('faltan rellenar los campos' , ' Error festivos') 
			return false 
		 }


		if($.isEmpty(nombre)){
			$('#nuevo [name="nombre[]"]').popover('show');
		 }else{
			if($.isEmpty(fecha)){
				$('#nuevo #dpFestivos').popover('show');
			 }else{
				hideShow('#nuevo .icon-plus')
				$('#nuevo .icon-load').css('display','inline-activa')
				$.post(INDEX ,data,function(r){
					$('#festivos')
						.find('#tblFestivos').append('\
						<tr id="'+r.id+'">\
							<td><a name="eliminar[]"  class= "icon-cancel"></a></td>\
							<td  class=""><span name="nombre[]">'+r.nombre+'</span></td>\
							<td> <span  name="mes[]" >'+Fecha.print(r.fecha)+'</span></td>\
						</tr>\
					').end()
					
					hideShow('#nuevo .icon-plus','#nuevo .icon-load')
					let f = config.festivos
					f.push(Fecha.md(r.fecha)) ;

					dialog.close() 

				},'json').fail(function(rsp){"ERROR=>"+echo(rsp);})
			 }
		 }
	 },
 }
