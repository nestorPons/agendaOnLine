
    <div class="cabecera-content">
    <h1>Nota del dia</h1>
    <?php 
        include URL_TEMPLATES . "datepicker.php" ;
    ?>
	</div>
    <table class=tablas>
     <thead>
      <tr>
       <th><span class="tituloOpciones">Opciones</span></th>
       <th><span class="tituloNumero">Numero</span></th>
       <th><span class="tituloFecha">Fecha</span></th>
       <th><span class="tituloHora">Hora</span></th>
       <th><span class="tituloDescripcion">Descripcion</span></th>
      </tr>
     </thead>
     <tbody>
      <?php 
       $notas = $Notas->getBy("DATE_FORMAT (fecha, '%Y-%m-%d')",$fecha); 
       foreach($notas as $nota){
            include URL_TEMPLATES . 'row.notas.php';
       }
      ?>
     </tbody>
    </table>