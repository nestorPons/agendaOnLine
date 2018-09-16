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

	}
}