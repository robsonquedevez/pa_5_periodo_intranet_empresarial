<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;
	
	$app->delete('/departament/delete/:id', function($id) use ($app){
			sleep(1);

			if(!isset($id)){
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Nenhum departamento foi selecionado'
				]));
			}

			$sql = new Sql();
			$connection = $sql->getConnection();

			try {

				$statement = $connection->prepare('DELETE FROM tb_departamento WHERE id = :ID');
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

	$app->put('/departament/update', function() use ($app){
		sleep(1);

		if(!isset($_POST['departamento']) || empty($_POST['departamento'])){
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nome do departamento deve ser informado'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();
		$statement = $connection->prepare("SELECT nome FROM tb_departamento WHERE nome = :NOME");
		$statement->bindParam(':NOME', $_POST['departamento']);	
		$statement->execute();

		if (!empty($statement->fetchAll())) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nome de departamento já existe'
			]));
		}

		$gestor = ($_POST['gestor'] != "0") ? $_POST['gestor'] : null;

		try {

			$statement = $connection->prepare('INSERT INTO tb_departamento (nome, gestor) VALUES (:NOME, :GESTOR)');
			$statement->bindParam(':NOME', $_POST['departamento']);			
			$statement->bindParam(':GESTOR', $gestor);
			$statement->execute();

			$queryUser = $connection->query("SELECT nome FROM tb_usuarios WHERE id = $gestor LIMIT 1");

			$user = $queryUser->fetchAll()[0];

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
					'departamento' 	=> $_POST['departamento'],
					'gestor'		=> $user['nome'],
					'id'			=> $connection->lastInsertId()
				]
			]));
		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> $e->getMessage()
			]));
		}			
	});

	$app->post('/departament/insert', function() use ($app){
		sleep(1);

		if(!isset($_POST['departamento']) || empty($_POST['departamento'])){
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nome do departamento deve ser informado'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();
		$statement = $connection->prepare("SELECT nome FROM tb_departamento WHERE nome = :NOME");
		$statement->bindParam(':NOME', $_POST['departamento']);	
		$statement->execute();

		if (!empty($statement->fetchAll())) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nome de departamento já existe'
			]));
		}

		$gestor = ($_POST['gestor'] != "0") ? $_POST['gestor'] : null;

		try {

			$statement = $connection->prepare('INSERT INTO tb_departamento (nome, gestor) VALUES (:NOME, :GESTOR)');
			$statement->bindParam(':NOME', $_POST['departamento']);			
			$statement->bindParam(':GESTOR', $gestor);
			$statement->execute();

			$queryUser = $connection->query("SELECT nome FROM tb_usuarios WHERE id = $gestor LIMIT 1");

			$user = $queryUser->fetchAll()[0];

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
					'departamento' 	=> $_POST['departamento'],
					'gestor'		=> $user['nome'],
					'id'			=> $connection->lastInsertId()
				]
			]));
		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> $e->getMessage()
			]));
		}			
	});

	$app->get('/departament', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> 'Robson Quedevez',
			'avatar'	=> '/../views/img/avatar/avatar.jpg'
		));

		$sql = new Sql();
		$connection = $sql->getConnection();
		$queryDept = $connection->query('SELECT dept.id, dept.nome, user.nome AS gestor FROM tb_departamento AS dept LEFT JOIN tb_usuarios AS user ON user.id = dept.gestor');
		$queryManagers = $connection->query('SELECT id, nome FROM tb_usuarios WHERE gestor = 1');

		
		$pgAdmin->setPage('departamento', array(
			'departaments' 	=> $queryDept->fetchAll(),
			'managers'		=> $queryManagers->fetchAll()
		));
	});

?>