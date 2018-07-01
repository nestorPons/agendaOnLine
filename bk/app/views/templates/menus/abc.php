<div id="menuABC" class="menu abc">
 	<?php
	$abecedario = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	if (!$Device->isMovile){
		?>
		<ul id='mainLstABC' class='lstMenu responsiveDesing_hidden'>
			<li>
				<?php
				for ($a = 0;$a <= count($abecedario)-1;$a++){
					?>
					<a id="menu<?php echo$abecedario[$a]?>"><?php echo$abecedario[$a]?></a>
					<?php
				}
				?>
			</li>
		</ul>
		<?php
	}else{
		?>
		<select id='lstABC' class='lstMenu responsiveDesing_show'>
		<?php
		for ($a = 0;$a <= count($abecedario)-1;$a++){
			echo "<option value='$abecedario[$a]'>".$abecedario[$a]."</option>";
		}
		?>
		</select>	
		<?php
	}
	?>
</div>