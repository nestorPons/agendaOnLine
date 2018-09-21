<header><?php include URL_MENUS . "admin.php"?></header>
<nav><?php include URL_MENUS . "navbar.php"?></nav>
<main id="admin" data-empresa="<?=$Empresa->code()?>">
	<div id='sections'>
		<section id='main' data-nombre="Principal" class="capasPrincipales activa" ><?php include URL_CONTROLLERS . "main.php"?></section>
		<section id='notas' data-nombre="Notas" class="capasPrincipales" ><?php include URL_CONTROLLERS . "notas.php"?></section>
		<section id='usuarios' data-nombre="Clientes" class="capasPrincipales" ></section>
		<section id='horarios' data-nombre="Horarios" class="capasPrincipales" ></section>
		<section id='crearCita' data-nombre="Crear cita" class="capasPrincipales" ></section>
		<section id='servicios' data-nombre="Servicios" class="capasPrincipales" ></section>
		<section id='familias' data-nombre="Familias" class="capasPrincipales" ></section>
		<section id='general' data-nombre="Datos" class="capasPrincipales" ></section>
		<section id='config' data-nombre="Configuración" class="capasPrincipales" ></section>
		<section id='estilos' data-nombre="Estilo" class="capasPrincipales" ></section>
		<section id='festivos' data-nombre="Festivos" class="capasPrincipales" ></section>
		<section id='agendas' data-nombre="Edición agendas" class="capasPrincipales" ></section>
		<section id='historial' data-nombre="Historial" class="capasPrincipales" ></section>
	</div>
	<div id="dialogs" class="popup-overlay"></div>	
	<div id="loader" class="popup-overlay hide">
		<i class="icon-load animate-spin"></i>
	</div>
</main>