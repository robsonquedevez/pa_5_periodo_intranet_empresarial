<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;

	$app->delete('/user/delete/:id', function($id) use ($app){
			sleep(1);

			if(!isset($id)){
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Nenhum usuário foi selecionado'
				]));
			}

			$sql = new Sql();
			$connection = $sql->getConnection();

			try {

				$statement = $connection->prepare('DELETE FROM tb_usuarios WHERE id = :ID');
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

	$app->post('/user/update', function() use ($app){
		sleep(1);

		if (!isset($_POST['nome']) || empty($_POST['nome'])) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nome deve ser preenchido'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();

		if (isset($_POST['senha']) && !empty($_POST['senha'])) {
			
			if (!isset($_POST['confirmaSenha']) || empty($_POST['confirmaSenha'])) {
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Cofirmação da senha deve ser preenchido'
				]));
			}

			if ($_POST['senha'] != $_POST['confirmaSenha']) {
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Senhas informadas são diferentes'
				]));
			}

			$pass = password_hash($_POST['senha'], PASSWORD_DEFAULT);

			try {
				
				$statement = $connection->prepare('UPDATE tb_usuarios SET senha = :PASS WHERE id = :ID');
				$statement->bindParam(':PASS', $pass);
				$statement->bindParam(':ID', $_POST['id']);
				$statement->execute();

			} catch (Exception $e) {
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> $e->getMessage()
				]));
			}
		}

		$id = $_POST['id'];

		try {
			if($_POST['departamento'] == '-1'){
				$statement = $connection->prepare('UPDATE tb_usuarios SET nome = :NOME, gestor = :GST WHERE id = :ID');
				$statement->bindParam(':NOME', $_POST['nome']);
				$statement->bindParam(':GST', $_POST['gestor']);
				$statement->bindParam(':ID', $id);
				$statement->execute();
			}
			elseif ($_POST['departamento'] == '0') {
				$statement = $connection->prepare('UPDATE tb_usuarios SET nome = :NOME, departamento = NULL, gestor = :GST WHERE id = :ID');
				$statement->bindParam(':NOME', $_POST['nome']);
				$statement->bindParam(':GST', $_POST['gestor']);
				$statement->bindParam(':ID', $id);
				$statement->execute();
			}
			else{
				$statement = $connection->prepare('UPDATE tb_usuarios SET nome = :NOME, departamento = :DEPT, gestor = :GST WHERE id = :ID');
				$statement->bindParam(':NOME', $_POST['nome']);
				$statement->bindParam(':GST', $_POST['gestor']);
				$statement->bindParam(':DEPT', $_POST['departamento']);
				$statement->bindParam(':ID', $id);
				$statement->execute();
			}



			$queryUser = $connection->query("SELECT user.id, user.nome, user.usuario, dept.nome AS departamento, user.gestor FROM tb_usuarios AS user LEFT JOIN tb_departamento AS dept ON user.departamento = dept.id WHERE user.id = $id");

			$user = $queryUser->fetchAll()[0];

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [					
					'nome'			=> $user['nome'],
					'usuario'		=> $user['usuario'],
					'departamento' 	=> $user['departamento'],
					'gestor'		=> ($user['gestor'] == 0) ? "Não" : "Sim",
					'id'			=> $user['id']
				]
			]));
		} catch (Exception $e) {
			return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> $e->getMessage()
				]));
		}
	});

	$app->post('/user/insert', function() use ($app){
		sleep(1);

		if(!isset($_POST['nome']) || empty($_POST['nome']) || !isset($_POST['departamento']) || empty($_POST['departamento']) || !isset($_POST['gestor']) || !isset($_POST['usuario']) || empty($_POST['usuario']) || !isset($_POST['senha']) || empty($_POST['senha']) || !isset($_POST['repetirSenha']) || empty($_POST['repetirSenha'])){

			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Todos os dados devem ser preenchidos'
			]));
		}

		if ($_POST['senha'] != $_POST['repetirSenha']) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Senhas informadas estão diferentes'
			]));
		}

		$user = $_POST['usuario'];

		$sql = new Sql();
		$connection = $sql->getConnection();
		$statement = $connection->prepare("SELECT usuario FROM tb_usuarios WHERE usuario = :USER");
		$statement->bindParam(':USER', $_POST['usuario']);	
		$statement->execute();

		if (!empty($statement->fetchAll())) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Nome de usuário já existe'
			]));
		}

		$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

		try {

			$statement = $connection->prepare('INSERT INTO tb_usuarios (nome, usuario, senha, departamento, gestor ) VALUES (:NAME, :USER, :PASS, :DEPT, :MANA)');
			$statement->bindParam(':NAME', $_POST['nome']);
			$statement->bindParam(':USER', $_POST['usuario']);	
			$statement->bindParam(':PASS', $senha);	
			$statement->bindParam(':DEPT', $_POST['departamento']);				
			$statement->bindParam(':MANA', $_POST['gestor']);
			$statement->execute();

			$id_dept = $_POST['departamento'];

			$queryDept = $connection->query("SELECT nome FROM tb_departamento WHERE id = $id_dept  LIMIT 1");

			$dept = $queryDept->fetchAll()[0];

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
					'nome'			=> $_POST['nome'],
					'usuario'		=> $_POST['usuario'],
					'departamento' 	=> $dept['nome'],
					'gestor'		=> (($_POST['gestor'] == 1) ? "Sim" : "Não"),
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

	$app->get('/user', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> 'Robson Quedevez',
			'avatar'	=> '/../views/img/avatar/avatar.jpg'
		));

		$sql = new Sql();
		$connection = $sql->getConnection();
		$queryUser = $connection->query('SELECT u.id, u.nome, u.usuario, d.nome departamento, u.gestor FROM tb_usuarios AS u LEFT JOIN tb_departamento AS d ON u.departamento = d.id ORDER BY u.nome ASC');
		$queryDept = $connection->query('SELECT id, nome FROM tb_departamento');

		$pgAdmin->setPage('usuario', array(
			'users' 		=> $queryUser->fetchAll(),
			'departaments'	=> $queryDept->fetchAll()
		));
	});


?>