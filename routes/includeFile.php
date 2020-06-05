<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;
	use App\Model;
	use App\User;

	$app->post('/include/infUpdate/:id', function($id) use ($app){
		sleep(1);
		if (!isset($id) || empty($id)) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Erro ao carregar, tente novamente'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();
		try {
			$queryType = $connection->query("SELECT tipo FROM tb_documentos WHERE id = $id");
			$tipo = $queryType->fetchAll()[0];

			if ($tipo['tipo'] == 'Publico') {
				$tipo = true;
			}else{
				$tipo = false;
			}

			$queryAnexo = $connection->query("SELECT nome FROM tb_anexo WHERE id_documento = $id");
			$nome = $queryAnexo->fetchAll()[0];

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
					'tipo'			=> $tipo,
					'nomeArquivo'	=> $nome['nome']
				]
			]));

		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status'	=> false,
				'message'	=> $e->getMessage()
			]));
		}
	});

	$app->post('/include/categoria/:id', function($id) use ($app){
		sleep(1);
		if (!isset($id) || empty($id)) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Erro ao carregar categoria, tente novamente'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();
		try {
			$queryCategoria = $connection->query("SELECT id, nome FROM tb_categorias WHERE departamento = $id");
			$categoria = $queryCategoria->fetchAll();

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> $categoria
			]));

		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status'	=> false,
				'message'	=> $e->getMessage()
			]));
		}
	});
	
	$app->delete('/include/delete/:id', function($id) use ($app){
		sleep(1);

		if(!isset($id)){
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Nenhuma Arquivo foi selecionado'
				]));
			}

			$sql = new Sql();
			$connection = $sql->getConnection();

			$queryFiles = $connection->query("SELECT caminho FROM tb_anexo WHERE id_documento = $id");

			$file = $queryFiles->fetchAll()[0]['caminho'];
			$caminho = $_SERVER['DOCUMENT_ROOT'] . $file;

			if(!unlink($caminho)){
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Erro ao excluir arquivo'
				]));
			}

			try {			

				
				$statement = $connection->prepare('DELETE FROM tb_documentos WHERE id = :ID');
				$statement->bindParam(':ID', $id);
				$statement->execute();
				

				$statement = $connection->prepare('DELETE FROM tb_anexo WHERE id_documento = :ID');
				$statement->bindParam(':ID', $id);
				$statement->execute();
				

				return $app->response->write(json_encode([
					'status'	=> true,
					'message'	=> 'Item excluido'
				]));
			} catch (Exception $e) {
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> $e->getMessage()
				]));
			}
	});

	$app->post('/include/insert', function() use ($app) {
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

			$httpPath = '/views/files/' . $nameFile;

			$uploadFile = $path . basename($nameFile);

			move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

			$statement = $connection->prepare('INSERT INTO tb_anexo (id_documento, caminho, data, nome, tamanho) VALUES (:IDDOC, :CAMI, :DTHR, :NOME, :TAM)');
			$statement->bindParam(':IDDOC', $id);
			$statement->bindParam(':CAMI', $httpPath);
			$statement->bindParam(':DTHR', $dt);
			$statement->bindParam(':NOME', $_FILES['file']['name']);
			$statement->bindParam(':TAM', $_FILES['file']['size']);
			$statement->execute();

			$queryFiles = $connection->query("SELECT doc.id, doc.nome, usu.nome AS usuario, dept.nome AS departamento, cat.nome AS categoria, anx.tamanho, doc.dtHrEnvio, anx.nome AS nomeArquivo, anx.caminho FROM tb_documentos AS doc INNER JOIN tb_usuarios AS usu ON doc.usuario = usu.id INNER JOIN tb_departamento AS dept ON doc.departamento = dept.id INNER JOIN tb_categorias AS cat ON doc.categoria = cat.id INNER JOIN tb_anexo AS anx ON doc.id = anx.id_documento WHERE doc.id = $id");

			$file = $queryFiles->fetchAll()[0];

			$dtFormatada = new DateTime($file['dtHrEnvio']);
			$dtFormatada = $dtFormatada->format("d/m/Y H:i:s");				

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
						'id'			=> $file['id'],
						'nome'			=> $file['nome'],
						'usuario'		=> $file['usuario'],
						'departamento'	=> $file['departamento'],
						'categoria'		=> $file['categoria'],
						'tamanho'		=> (round(($file['tamanho'] / 1024)) . 'KB'),
						'data'			=> $dtFormatada,
						'anexoNome'		=> $file['nomeArquivo'],
						'caminho'		=> $file['caminho']
				]
			]));

		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> $e->getMessage()
			]));
		}
	});

	$app->get('/include', function(){

		User::verifyLogin();

		$pgAdmin = new PageAdmin(array(
			'username' 	=> $_SESSION['User']['nome'],
			'avatar'	=> $_SESSION['User']['avatar']
		));

		$sql = new Sql();
		$connection = $sql->getConnection();

		$queryDept = $connection->query("SELECT id, nome FROM tb_departamento");

		$queryFiles = $connection->query("SELECT doc.id, doc.nome, usu.nome AS usuario, dept.nome AS departamento, cat.nome AS categoria, anx.tamanho, doc.dtHrEnvio, anx.nome AS nomeArquivo, anx.caminho FROM tb_documentos AS doc INNER JOIN tb_usuarios AS usu ON doc.usuario = usu.id INNER JOIN tb_departamento AS dept ON doc.departamento = dept.id INNER JOIN tb_categorias AS cat ON doc.categoria = cat.id INNER JOIN tb_anexo AS anx ON doc.id = anx.id_documento");

		$pgAdmin->setPage('incluirArquivo', array(
			'departamento' 	=>  $queryDept->fetchAll(),
			'documento'		=> 	$queryFiles->fetchAll()
		));
	});

?>