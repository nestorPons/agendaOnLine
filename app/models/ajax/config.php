<?php
header('Content-Type: application/json');

// Check if image file is a actual image or fake image
if (!empty($_FILES["fileLogo"]["tmp_name"])){

	$target_file = URL_EMPRESA . basename($_FILES["fileLogo"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$js['success'] = false;

	$check = getimagesize($_FILES["fileLogo"]["tmp_name"]);

	$js['err'] = ($check == false) ?
		'El archivo seleccionado no es una imagen' : //no es una imagen
			file_exists($target_file) ?
			'Esta imagen ya existe' : //existe la imagen
				$_FILES["fileLogo"]["size"] > 500000 ?
				'Imagen demasiado grande':// tamaño de la imagen 
					!move_uploaded_file($_FILES["fileLogo"]["tmp_name"], $target_file) ? 
					'No se ha podido guardar la imagen ' :
						$imageFileType == "png"||$imageFileType == "jpg"||$imageFileType == "ico" ?
						true : 
						'Formato archivo incorrecto';//formato archivo

	if ($js['err'] == true ){	

		//redimensionar imagen a 64X64 y guardo con nombre logo.png
		$ruta_imagen = $target_file;

		$miniatura_ancho_maximo = 128;
		$miniatura_alto_maximo = 128;

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
		
		$js['redimen'] =  imagepng($lienzo,URL_EMPRESA.'logo.png', 5);

		unlink($target_file);
		imagedestroy($imagen);
	}
	$js['img'] 	= 'URL_EMPRESA';
}

//guardarConfiguracion

$data = array(
	'sendMailAdmin' => (!empty($_POST['sendMailAdmin']))?1:0,
	'ShowRow' => (!empty($_POST['showInactivas']))?1:0,
	'sendMailUser' => (!empty($_POST['sendMailUser']))?1:0,
	'festivosON' => (!empty($_POST['festivosON']))?1:0,
	'minTime' => $_POST['minTime']??0,
);
$Config  = new core\BaseClass('config') ;

$js['success'] = $Config->saveAll($data);

echo json_encode($js);