<div id="mnuFamilias" class="menu">
    <select id="seleccion" >
        <?php
            foreach($familias as $familia){?>
            <option id="<?=$familia['id']?>" value='<?=$familia['id']?>'><?=$familia['nombre']?></option>
            <?php
        }?>
    </select>
</div>