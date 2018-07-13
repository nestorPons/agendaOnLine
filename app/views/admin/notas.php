
<table class=tablas>
    <thead>
    <tr>
    <th><span class="tituloOpciones">Opciones</span></th>
    <th><span class="tituloNumero">Id</span></th>
    <th><span class="tituloFecha">Fecha</span></th>
    <th><span class="tituloHora">Hora</span></th>
    <th><span class="tituloDescripcion">Descripcion</span></th>
    </tr>
    </thead>
    <tbody class="deslizanteFechas">
        <tr class="template">
        <td class="ico" >
            <a class= "icon-edit fnEdit x6"></a>
        </td>
        <td class="idid"></td>
        <td class="idFecha"></td>
        <td class="idHora"></td>
        <td class="idDescripcion"></td>
    </tr>
    
    <?php 

    $notas = $Notas->getBy("DATE_FORMAT (fecha, '%Y-%m-%d')",Date('Y-m-d')); 
    
    foreach($notas as $nota){
        include URL_TEMPLATES . 'row.notas.php';
    }
    ?>
    </tbody>
</table>