<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;
	use App\Model;
	use App\User;


	$app->get('/public/:id', function($id){
		User::verifyLogin();

		$pgAdmin = new PageAdmin(array(
			'username' 	=> $_SESSION['User']['nome'],
			'avatar'	=> $_SESSION['User']['avatar']
		));

		$sql = new Sql();
		$connection = $sql->getConnection();

		$queryName = $connection->query("SELECT nome FROM tb_departamento WHERE id = $id");
		$name = $queryName->fetchAll()[0];

		$queryFiles = $connection->query("SELECT doc.id, doc.nome, usu.nome AS usuario, dept.nome AS departamento, cat.nome AS categoria, doc.dtHrEnvio, anx.nome AS nomeArquivo, anx.caminho FROM tb_documentos AS doc INNER JOIN tb_usuarios AS usu ON doc.usuario = usu.id INNER JOIN tb_departamento AS dept ON doc.departamento = dept.id INNER JOIN tb_categorias AS cat ON doc.categoria = cat.id INNER JOIN tb_anexo AS anx ON doc.id = anx.id_documento WHERE dept.id = $id AND doc.tipo = 'Publico'");

		$pgAdmin->setPage('arquivosPublicosViews', array(
			'nome'			=> $name['nome'],
			'documento'		=> 	$queryFiles->fetchAll()
		));
	});


	$app->get('/public', function(){
		User::verifyLogin();

		$pgAdmin = new PageAdmin(array(
			'username' 	=> $_SESSION['User']['nome'],
			'avatar'	=> $_SESSION['User']['avatar']
		));

		$sql = new Sql();
		$connection = $sql->getConnection();

		$queryFiles = $connection->query("SELECT id, nome FROM tb_departamento ORDER BY nome");

		$pgAdmin->setPage('arquivosPublicos', array(
			'departamento'	=> 	$queryFiles->fetchAll()
		));
	});



?>