<div class="cuerpo center" >   
    <div class = '' >
        <div class="aling-left">
            <h4  id='lblColorCompany'>Seleccione los colores de la empresa : </h4>
            <input type="color" id="btnColor1" value="<?= CONFIG['color_main']?>">
            <span class='caption'>Color Principal</span>
            <br>
            <input type="color" id="btnColor2" value="<?= CONFIG['color_secon']?>"> 
            <span class='caption'>Color Secundario</span>
            <br>
        <hr>

            <h4 id='tlTypeBorder' >Seleccione el radio del borde para los controles : </h4>
            <div 
                id = "sldBorderRadius" 
                class="slider"
                data-on-change="sliderConfigBorder"
                data-role="slider"
                data-max-value="25"
                data-min-value="0"
                data-position = "<?= CONFIG['border_radio']?>"
                data-complete-color = "<?= CONFIG['color_main']?>"
                data-color = "<?= CONFIG['color_secon']?>"
            >
            </div>
            <center>
                <button type="button" id="btnTest" class="btn-success">
                    <span class="icon-user"></span>
                    <span class= "btnCaption">Prueba</span>
                </button> 
            </center>
        <hr>
            <div>
                <h4 id='lblSelLetterType'>Seleccione un tipo de letra : </h4>
                    <div class="iconClass-container icon-left">
                        <span class='caption'> Fuente texto </span>
                        <input type="text" id="btnText1" value="<?= CONFIG['font_main']?>">  <br>
                    </div>
                    <div class="iconClass-container icon-left">
                    <span class='caption'>  Fuente Titulo </span>
                    <span class="lnr-bold"></span>
                    <input type="text" id="btnText2" value="<?= CONFIG['font_tile']?>"> <br>
                    </div>
                <br>
                <a id ="linkFuentes" href= "https://fonts.google.com/" target="_blank" > Seleccione el nombre de la fuente desde Google Fonts </a> 
                <p id='fraseTest'>Frase de muestra para seleccionar el tipo de letra</p>
            </div>
        </div>
    </div>
</div>