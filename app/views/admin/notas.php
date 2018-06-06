
    <div class="cabecera-content">
    <?php 
        include URL_TEMPLATES . "datepicker.php" ;
    ?>
	</div>
    <h1>Nota del dia</h1>
    <table class=tablas>
     <thead>
      <tr>
       <th><span class="idituloOpciones">Opciones</span></th>
       <th><span class="idTituloFecha">Fecha</span></th>
       <th><span class="idTituloDescripcion">Descripcion</span></th>
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