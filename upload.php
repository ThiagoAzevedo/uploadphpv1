<!DOCTYPE html>
<html lang=pt-br>
<head>
	<meta charset="utf8">
	<title>Upload de Arquivos</title>
</head>
<body>

	<?php

		function uploadArquivos() {
			//Define as extensões aceitas
			$formatosPermitido = array("png", "jpg", "jpeg", "gif");
			//Ler a extensão do arquivo selecionado
			$extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

			//Verifica se existe a extensão no formato permitido
			if(in_array(strtolower($extensao), $formatosPermitido)) {
				$pasta = $GLOBALS['nomePasta'];
				$temporario = $_FILES['arquivo']['tmp_name'];
				$novoNome = uniqid().".$extensao";

				if(move_uploaded_file($temporario, $pasta.$novoNome)) {
					echo $mensagem = "Upload feito com sucesso.";
				} else {
					echo $mensagem = "Erro, não foi possível fazer o upload.";
				}
			} else {
				echo $mensagem = "Formato inválido!";
			}
		}


		if(isset($_POST['enviar-formulario'])) {

			$nomePasta = "uploads-".date("Y")."/";
			
			if(!file_exists($nomePasta)) {				
				$criarPasta = mkdir(__DIR__."/".$nomePasta, 0777, true);

				if($criarPasta) {
					uploadArquivos();
				} else {
					echo "Falha para criar a pasta";
				}
				
			} else {
				uploadArquivos();
			}

		}

	?>

	<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
		<input type="file" name="arquivo">
		<button type="submit" name="enviar-formulario">Enviar</button>
	</form>

</body>
</html>