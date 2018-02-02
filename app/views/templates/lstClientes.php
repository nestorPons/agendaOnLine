
<datalist id ='lstClientes'>
	<?php
    $Users  = new core\BaseClass('usuarios') ; 
    $users = $Users->getAll('id , nombre');
	foreach($users as $user){
        $name = $user[1] ; 
        $id  = $user[0]

		?>
		<option 
            data-id="<?=$id?>" 
			data-name="<?=\core\Tools::normalize($name)?>" 
			value="<?=$name?>">
		</option>
		<?php
	}
	?>
</datalist>