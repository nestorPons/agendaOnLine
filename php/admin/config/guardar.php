<?php
include "../../connect/conexion.php";
$conexion = conexion(true,false,true);

//guardarLogo
	$target_dir = "../../../".$_SESSION['bd']."/arch/";
	$target_file = $target_dir . basename($_FILES["fileLogo"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$js['success'] = false;
	// Check if image file is a actual image or fake image
if (!Empty($_FILES["fileLogo"]["tmp_name"])){
	$check = getimagesize($_FILES["fileLogo"]["tmp_name"]);
	$js['errorImage'] = ($check !== false)?0:1;//no es una imagen
	$js['errorImage'] = file_exists($target_file)?2:0;//existe la imagen
	$js['errorImage'] = $_FILES["fileLogo"]["size"] > 500000?3:0;// tamaño de la imagen 
	$js['errorImage'] = $imageFileType == "png"||$imageFileType == "jpg"||$imageFileType == "ico"?0:4;//formato archivo
	
	if ($js['errorImage'] ==0){
		if (!move_uploaded_file($_FILES["fileLogo"]["tmp_name"], $target_file)) {
			$js['errorImage'] = 5;
		}else{
			
			//redimensionar imagen a 64X64 y guardo con nombre logo.png
			$ruta_imagen = $target_file;

			$miniatura_ancho_maximo = 64;
			$miniatura_alto_maximo = 64;

			$info_imagen = getimagesize($ruta_imagen);
			$imagen_ancho = $info_imagen[0];
			$imagen_alto = $info_imagen[1];
			$imagen_tipo = $info_imagen['mime'];


			$proporcion_imagen = $imagen_ancho / $imagen_alto;
			$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

			if ( $proporcion_imagen > $proporcion_miniatura ){
				$miniatura_ancho = $miniatura_ancho_maximo;
				$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
			} else if ( $proporcion_imagen < $proporcion_miniatura ){
				$miniatura_ancho = $miniatura_ancho_maximo * $proporcion_imagen;
				$miniatura_alto = $miniatura_alto_maximo;
			} else {
				$miniatura_ancho = $miniatura_ancho_maximo;
				$miniatura_alto = $miniatura_alto_maximo;
			}

			switch ( $imagen_tipo ){
				case "image/jpg":
				case "image/jpeg":
					$imagen = imagecreatefromjpeg( $ruta_imagen );
					break;
				case "image/png":
					$imagen = imagecreatefrompng( $ruta_imagen );
					break;
				case "image/gif":
					$imagen = imagecreatefromgif( $ruta_imagen );
					break;
			}

			$lienzo = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
			imagesavealpha($lienzo,true);
			
			//create a fully transparent background (127 means fully transparent)
			$trans_background = imagecolorallocatealpha($lienzo, 0, 0, 0, 127);
			//fill the image with a transparent background
			imagefill($lienzo, 0, 0, $trans_background);
			
			imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
			
			$js['redimen'] =  imagepng($lienzo,$target_dir.'logo.png', 5);
			unlink($target_file);
		}
	}	
}

//guardarConfiguracion
	$sendAdmin = (!empty($_POST['sendMailAdmin']))?1:0;
	$showInactivas = (!empty($_POST['showInactivas']))?1:0;
	$sendUser = (!empty($_POST['sendMailUser']))?1:0;
	$festivos = (!empty($_POST['festivosON']))?1:0;
	$minTime = $_POST['minTime']??0;
	$sql = "UPDATE config SET sendMailAdmin = $sendAdmin, sendMailUser = $sendUser, festivosON  = $festivos , ShowRow=$showInactivas, MinTime=$minTime WHERE idEmpresa = ". CONFIG['idEmpresa'].";";
	$js['datosGuardados'] =mysqli_query($conexion,$sql);
	imagedestroy($imagen);
	
//echo json_encode($js);