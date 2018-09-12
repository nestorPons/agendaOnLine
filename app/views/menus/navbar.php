<div id="mySidenav" class="sidenav ocultarNav">
  <ul class="">
			<li title="Cita">
				<a id="menu1" name='menu[]' class="" data-capa="crearCita">
					<span class="lnr-calendar-full" ></span>
					<span class="caption" >Cita</span>
				</a>
			</li>
			<li title="Agendas">
				<a id="menu0" name='menu[]' class="app-bar-element selected" data-capa="main">
					<span class="lnr-book" ></span>		
					<span class="caption ">Agendas</span>				
				</a>
			</li>
			<li title="Notas">
				<a id="menu5"  name='menu[]'  data-capa="notas" class="<?= empty($notas)?'':'hay-nota'?>">
					<span class="lnr-pencil"></span>
					<span class="caption">Notas</span>
				</a>
			</li>
			<li title="Clientes">
				<a id="menu2" name='menu[]' class="app-bar-element" data-capa="usuarios">
					<span class="lnr-users" ></span>
					<span class="caption">Clientes</span>
				</a>
			</li>
			<li title="Servicios">
				<a id="menu3" name='menu[]' data-capa="servicios" >
					<span class="lnr-list" ></span>
					<span class="caption">Servicios</span>
				</a>
			</li>
			<li title="Familias">
				<a id="menu4" name='menu[]' data-capa="familias" >
					<span class="lnr-bug" ></span>
					<span class="caption">Familias</span>
				</a>
			</li>

			<li title="Historial">
				<a id="menu9"  name='menu[]'  data-capa="historial">
					<span class="lnr-history" ></span>
					<span class="caption">Historial</span>
				</a>
			</li>
			<li>
				<a id="menu8"  class="dropdown-toggle"  title="Config">
					<span class="lnr-cog" ></span>
					<span class="caption">Config</span>
				</a>
				<ul class="d-menu" data-role="dropdown">
					<li>
						<a name='menu[]' data-capa="config"	 title="Configuración aplicacion">
							<span class="lnr-cog"></span>
							<span class="caption">Configuración</span>
						</a>
					</li>
					<li>
						<a name='menu[]' data-capa="horarios"  title="Programar horarios">
							<span class="lnr-clock" ></span>
							<span class="caption">Horarios</span>
						</a>
					</li>
					<li>
						<a name='menu[]' data-capa="festivos"  title="Selección dias festivos">
							<span class="lnr-rocket" ></span>
							<span class="caption">Festivos</span>
						</a>
					</li>
					<li>
						<a name='menu[]' data-capa="agendas"  title="Configuración agendas">
							<span class="lnr-book" ></span>
							<span class="caption">Agendas</span>
						</a>
					</li>	
					<li>
						<a name='menu[]' data-capa="estilos"  title="Personalización de la aplicación">
							<span class="lnr-diamond" ></span>
							<span class="caption">Estilos</span>
						</a>
					</li>	
				</ul>
			</li>

			
	</ul>
</div>