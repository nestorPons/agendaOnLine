
<datalist id ='lstClientes'>
	<?php
    $Users  = new core\BaseClass('usuarios') ; 
    $users = $Users->getAll('id , nombre, color', MYSQLI_ASSOC);
	foreach($users as $user){
        $name = $user['nombre'] ; 
        $id  = $user['id']; 
		$color = $user['color'];

		?>
		<option 
            data-id="<?=$id?>" 
			data-name="<?=\core\Tools::normalize($name)?>" 
			value="<?=$name?>"
			data-color = "<?=$color?>">
		</option>
		<?php
	}
	?>
</datalist>