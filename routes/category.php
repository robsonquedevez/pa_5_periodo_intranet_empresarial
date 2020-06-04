<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;

	$app->delete('/category/delete/:id', function($id) use ($app){
		sleep(1);

		if(!isset($id)){
				return $app->response->write(json_encode([
					'status' 	=> false,
					'message'	=> 'Nenhuma categoria foi selecionado'
				]));
			}

			$sql = new Sql();
			$connection = $sql->getConnection();

			try {

				$statement = $connection->prepare('DELETE FROM tb_categorias WHERE id = :ID');
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

	$app->post('/category/update',  function() use ($app){
		sleep(1);

		if (!isset($_POST['categoria']) || empty($_POST['categoria']) || !isset($_POST['departamento'])) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Todos os campos devem ser preenchidos'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();

		try {
			if ($_POST['departamento'] == '0') {
				$statement = $connection->prepare("UPDATE tb_categorias SET nome = :CAT WHERE id = :ID");
				$statement->bindParam(':CAT', $_POST['categoria']);
				$statement->bindParam(':ID', $_POST['idCategoryDbUp']);
				$statement->execute();
			}
			else{
				$statement = $connection->prepare("UPDATE tb_categorias SET nome = :CAT, departamento = :DEPT WHERE id = :ID");
				$statement->bindParam(':CAT', $_POST['categoria']);
				$statement->bindParam(':DEPT', $_POST['departamento']);
				$statement->bindParam(':ID', $_POST['idCategoryDbUp']);
				$statement->execute();
			}

			$id_cat = $_POST['idCategoryDbUp'];

			$queryCat = $connection->query("SELECT cat.id, cat.nome, dept.nome AS departamento FROM tb_categorias AS cat LEFT JOIN tb_departamento AS dept ON cat.departamento = dept.id WHERE cat.id = $id_cat");

			$categoria = $queryCat->fetchAll()[0];

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
					'categoria' 	=> $categoria['nome'],
					'departamento'	=> $categoria['departamento'],
					'id'			=> $categoria['id']
				]
			]));

		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> $e->getMessage()
			]));
		}
	});

	$app->post('/category/insert', function() use ($app){
		sleep(1);

		if (!isset($_POST['categoria']) || empty($_POST['categoria']) || !isset($_POST['departamento']) || empty($_POST['departamento'])) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Todos os campas devem ser preenchidos'
			]));
		}

		$sql = new Sql();
		$connection = $sql->getConnection();
		
		$statement = $connection->prepare("SELECT * FROM tb_categorias WHERE nome = :NOME AND departamento = :DEPT");
		$statement->bindParam(':NOME', $_POST['categoria']);
		$statement->bindParam(':DEPT', $_POST['departamento']);	
		$statement->execute();

		if (!empty($statement->fetchAll())) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> 'Categoria já existe para esse dapartamento'
			]));
		}

		$dept = $_POST['departamento'];

		try {
			$statement = $connection->prepare("INSERT INTO tb_categorias (nome, departamento) VALUES(:NOME, :DEPT)");
			$statement->bindParam(':NOME', $_POST['categoria']);
			$statement->bindParam(':DEPT', $_POST['departamento']);
			$statement->execute();
			$id = $connection->lastInsertId();

			if($dept != null){
				$queryUser = $connection->query("SELECT nome FROM tb_departamento WHERE id = $dept LIMIT 1");
				$dept = $queryUser->fetchAll()[0]['nome'];
			}else{
				$dept = "";
			}

			return $app->response->write(json_encode([
				'status'	=> true,
				'message'	=> [
					'categoria' 	=> $_POST['categoria'],
					'departamento'		=> $dept,
					'id'			=> $id
				]
			]));

		} catch (Exception $e) {
			return $app->response->write(json_encode([
				'status' 	=> false,
				'message'	=> $e->getMessage()
			]));
		}
	});

	$app->get('/category', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> 'Robson Quedevez',
			'avatar'	=> '/../views/img/avatar/avatar.jpg'
		));

		$sql = new Sql();
		$connection = $sql->getConnection();
		$queryCat = $connection->query('SELECT cat.id, cat.nome, dept.nome AS departamento FROM tb_categorias AS cat LEFT JOIN tb_departamento AS dept ON cat.departamento = dept.id');

		$queryDept = $connection->query('SELECT id, nome FROM tb_departamento');

		
		$pgAdmin->setPage('categoria', array(
			'category' 		=> $queryCat->fetchAll(),
			'departament'	=> $queryDept->fetchAll()
		));
	});

?>