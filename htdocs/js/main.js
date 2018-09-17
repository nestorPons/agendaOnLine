main = { 
	scripts  : [], 
	isActive: true, 
	worker : {
		w : null , 
		isActive : true, 
		init : function(){
			if (this.isActive) {
				this.w.postMessage(0);
				this.isActive = true;  // Cambiar a false,  true solo para desarrollo 
			}
		}, 
		send : function(){
		}, 
		sync : function(){
			this.w = new Worker('/js/worker.js');
			this.w.onmessage = e =>{
				let data = JSON.parse(e.data);
				if(data){
					$.each(data, function (i, d) { 
						$.each(d, function (i, v) { 
							let action = parseInt(v.action), obj = null

							switch(v.table){
								case "data": 
									obj = admin.lbl;
									break; 
								case 'notas':
									obj = notas;
									break; 
								case 'usuarios': 
									obj = usuarios.rows;
									break; 
								case 'servicios': 
									obj = servicios;
									break; 
								case 'familias': 
									obj = familias;
									break; 
								};
 
							switch(action){
								case 1: obj.create(v); 			break;  
								case 2: obj.edit(v);			break;
								case 3: obj.delete(v, true);	break; 
							}
						});	 
					});
				} else {
					console.log('No se encontraron datos')
				}
				setTimeout(this.init(), 5000); 				
			}
			// Inicializa los long pollings
			this.init();
		}

	}, 
	mostrarCapa(capa, callback){
		// Muestra las capas de navegacion 
		// El callback devuelve el selector dom jquery de la capa mostrada

		// evento de salida
		let lastLayer = $('#admin section.activa').attr('id')
		if(typeof(window[lastLayer].exit) === 'function') window[lastLayer].exit()
		// ++++++

		var data = { 
				controller : capa ,  
				fecha :  Fecha.sql ,
			  }, 
			 $capa = $('#'+capa),
			$menu = $('#mySidenav')
		
		//Cambia el estado del menu
		$('.app-bar-pullmenu ').hide('blind');
		$menu.find('.selected').removeClass('selected')
		$menu.find('[data-capa="'+capa+'"]').addClass('selected')
		//***	  
		
		// Cerramos funcion si es la misma capa
		if($capa.hasClass('activa')) return false;
	
		$('#chckOpUsersDel').prop( "checked", false ) ;
		$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja') ;
		
		if($capa.is(':empty') ){
			$.post(INDEX,data,function(html){
	
				$('#'+capa).html(html).promise().done(__INIT__);
				function __INIT__ (){
					//Si hay que iniciar en 
				}
	
				$.getScript("/js/"+capa+".js", function(){
					main.scripts.push(capa)

					typeof callback == "function" && callback($('#'+ capa))
				})
				.complete(()=>window[capa].init())
	
			},'html')
		 } else {
			if($('#config').is(':visible')&& config.change) config.guardar();
			if($('#agendas').is(':visible')&& agendas.change) agendas.guardar();
			typeof callback == "function" && callback($('#'+ capa))
		 }
		$('.capasPrincipales.activa').hide().removeClass('activa')
		$capa.fadeIn().addClass('activa')
		menu.status(capa)
		if(capa=='main') $('#'+Fecha.id).show()		
		$('html,body').animate({scrollTop:0}, 500)
	 }

}