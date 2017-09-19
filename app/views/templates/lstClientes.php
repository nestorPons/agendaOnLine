
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
			data-name="<?=normaliza($name)?>" 
			value="<?=$name?>">
		</option>
		<?php
	}
	?>
</datalist>