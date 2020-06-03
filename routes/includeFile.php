<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;
	use App\File;

	$app->get('/include', function(){

		$pgAdmin = new PageAdmin(array(
			'username' 	=> 'Robson Quedevez',
			'avatar'	=> '/../views/img/avatar/avatar.jpg'
		));

		$sql = new Sql();
		$connection = $sql->getConnection();

		$queryDept = $connection->query("SELECT id, nome FROM tb_departamento");

		$queryCat = $connection->query("SELECT id, nome FROM tb_categorias");

		$queryFiles = $connection->query("SELECT doc.id, doc.nome, usu.nome AS usuario, dept.nome AS departamento, cat.nome AS categoria, anx.tamanho, doc.dtHrEnvio FROM tb_documentos AS doc INNER JOIN tb_usuarios AS usu ON doc.usuario = usu.id INNER JOIN tb_departamento AS dept ON doc.departamento = dept.id INNER JOIN tb_categorias AS cat ON doc.categoria = cat.id INNER JOIN tb_anexo AS anx ON doc.id = anx.id_documento");

		$pgAdmin->setPage('incluirArquivo', array(
			'departamento' 	=>  $queryDept->fetchAll(),
			'categoria'		=> 	$queryCat->fetchAll(),
			'documento'		=> 	$queryFiles->fetchAll()
		));
	});

	$app->post('/include', function() use ($app) {
		sleep(1);

		if(!isset($_POST['nome']) || empty($_POST['nome']) || !isset($_POST['departamento']) || empty($_POST['departamento']) || !isset($_POST['categoria']) || empty($_POST['categoria']) || !isset($_POST['tipo']) || empty($_POST['tipo'])){
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Todos os campos devem ser preenchidos'
			]));
		}

		if (!isset($_FILES)) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nenhuma arquivo foi selecionado'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();

		try {

			$dt = date('Y-m-d H:i:s');

			$user = 15;

			$statement = $connection->prepare('INSERT INTO tb_documentos (nome, usuario, tipo, dtHrEnvio, departamento, categoria) VALUES (:NOME, :USER, :TIPO, :DTHR, :DEPT, :CAT)');
			$statement->bindParam(':NOME', $_POST['nome']);
			$statement->bindParam(':USER', $user);
			$statement->bindParam(':TIPO', $_POST['tipo']);			
			$statement->bindParam(':DTHR', $dt);
			$statement->bindParam(':DEPT', $_POST['departamento']);
			$statement->bindParam(':CAT', $_POST['categoria']);
			$statement->execute();
			$id = $connection->lastInsertId();

			$path = __DIR__.'\..\views\files\\';

			$ext = explode('/', $_FILES['file']['type']);
			$ext = $ext[1];

			$name = $_FILES['file']['name'].$dt;

			$nameFile = hash('md5', $name).'.'.$ext;

			$uploadFile = $path . basename($nameFile);

			move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

			$statement = $connection->prepare('INSERT INTO tb_anexo (id_documento, caminho, data, nome, tamanho) VALUES (:IDDOC, :CAMI, :DTHR, :NOME, :TAM)');
			$statement->bindParam(':IDDOC', $id);
			$statement->bindParam(':CAMI', $uploadFile);
			$statement->bindParam(':DTHR', $dt);
			$statement->bindParam(':NOME', $_FILES['file']['name']);
			$statement->bindParam(':TAM', $_FILES['file']['size']);
			$statement->execute();

			return $app->response->write(json_encode([
				'status'	=> true
			]));

		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> $e->getMessage()
			]));
		}
		return;
	});

?>