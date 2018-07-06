'strict'
var historial = {
	sinc: function(){
		if(!$('#historial table').length) return false
		historial.get()
	}, 
	get : function(days=1){
		let data = {
			controller :'history', 
			days : days
		}

		$.post(INDEX, data,	function (html) {
			$('#history').html(html)
		},'html')
	},
	crear: {
		linea: function(d){

			//Si existe que no haga nada en historia no se editan los datos solo se crean 
			$obj = $('#history table tbody')
			if($obj.find('#historia_'+d.id).length) return false
			
			switch(parseInt(d.accion)){
				case 1: 
					ico = 'plus'; 
					accion = "Nueva cita";
				break
				case 2: 
					ico = 'trash-empty';
					accion = "Cita eliminada";
				break
				case 3: 
					ico = 'edit';
					accion = "Cita modificada";
				break
				case 4: 
					ico = 'logout';
					accion = "Salida usuario";
				break
				case 5: 
					ico = 'login';    
					accion = "Entrada usuario";
				break
			}

			 
			
			$obj.find('.template').clone()
				.find('.id').text(d.id).end()
				.find('.fecha').text(d.fecha).end()
				.find('.icono i').addClass('icon'+ico)
				.find('.idUsuario').text(d.idUsuario).end()
				.find('.accion').text(d.accion).end()
				.find('.estado').text(d.estado).end()
			
		}
	}
 }