
    <div class="cabecera-content">
    <?php 
        include URL_TEMPLATES . "datepicker.php" ;
    ?>
	</div>
    <form>
        <p>Nota del dia:</p>
        <textarea id="txtNotas" rows="5" cols=""><?=trim($Notas->getOneBy('fecha' , $fecha, 'nota'));?></textarea>
    </form>
