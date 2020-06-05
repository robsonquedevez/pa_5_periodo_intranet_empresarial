<?php
	
	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;
	use App\Model;
	use App\User;

	$app->post('/private/log/:id', function($id) use ($app){
		sleep(1);	

		$sql = new Sql();
		$connection = $sql->getConnection();

		$queryLog = $connection->query("SELECT log.id, arq.nome AS arquivo, usu.nome AS usuario, log.tipo, log.data FROM tb_log_documento AS log INNER JOIN tb_anexo AS arq ON log.arquivo = arq.id INNER JOIN tb_usuarios AS usu ON log.usuario = usu.id WHERE log.id_documento = $id");
		$log = $queryLog->fetchAll();

		return $app->response->write(json_encode([
			'status'	=> true,
			'message'	=> $log
		]));

	});


	$app->get('/private', function(){

		User::verifyLogin();

		$pgAdmin = new PageAdmin(array(
			'username' 	=> $_SESSION['User']['nome'],
			'avatar'	=> $_SESSION['User']['avatar']
		));

		$sql = new Sql();
		$connection = $sql->getConnection();

		$queryFiles = $connection->query("SELECT doc.id, doc.nome, usu.nome AS usuario, dept.nome AS departamento, cat.nome AS categoria, anx.tamanho, doc.dtHrEnvio, anx.nome AS nomeArquivo, anx.caminho FROM tb_documentos AS doc INNER JOIN tb_usuarios AS usu ON doc.usuario = usu.id INNER JOIN tb_departamento AS dept ON doc.departamento = dept.id INNER JOIN tb_categorias AS cat ON doc.categoria = cat.id INNER JOIN tb_anexo AS anx ON doc.id = anx.id_documento");

		$pgAdmin->setPage('arquivosPrivados', array(
			'documento'		=> 	$queryFiles->fetchAll()
		));
	});

?>