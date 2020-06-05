<?php

	session_start();

	require_once(__DIR__.'/vendor/autoload.php');
	require_once(__DIR__.'./function.php');

	date_default_timezone_set("America/Sao_Paulo");

	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;
	use App\Model;
	use App\User;

	$app = new Slim();

	$app->get('/', function(){

		$page = new Page();

		$page->setPage('login');
	});

	$app->get('/home', function(){

		User::verifyLogin();

		$pgAdmin = new PageAdmin(array(
				'username' 	=> $_SESSION['User']['nome'],
				'avatar'	=> $_SESSION['User']['avatar']
			));
		$pgAdmin->setPage('home');
	});

	$app->get('/login', function() {

		$page = new Page();

		$page->setPage('login');
	});

	$app->post('/login', function() {

		User::Login($_POST['user'], $_POST['password']);

		header('Location: /home');
		exit;
	});

	$app->get('/logout', function(){

		User::logout();

		$page = new Page();
		session_destroy();
		$page->setPage('login');
	});

	$app->group('/register', function() use ($app){
		
		include(__DIR__.'\routes\user.php');

		include(__DIR__.'\routes\category.php');
		
		include(__DIR__.'\routes\departament.php');
	});

	$app->group('/file', function() use ($app){

		include(__DIR__.'\routes\includeFile.php');

		include(__DIR__.'\routes\privateFiles.php');

		include(__DIR__.'\routes\publicFiles.php');
	});

	$app->get('/access', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> $_SESSION['User']['nome'],
			'avatar'	=> $_SESSION['User']['avatar']
		));
		$pgAdmin->setPage('acessos');
	});

	$app->get('/profile', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> $_SESSION['User']['nome'],
			'avatar'	=> $_SESSION['User']['avatar']
		));

		$id = $_SESSION['User']['id'];

		$sql = new Sql();
		$connection = $sql->getConnection();
		$queryUser = $connection->query("SELECT usu.id, usu.nome, usu.usuario, usu.gestor, usu.avatar, dept.nome AS departamento FROM tb_usuarios AS usu LEFT JOIN tb_departamento AS dept ON usu.departamento = dept.id WHERE usu.id = $id");
		$user = $queryUser->fetchAll()[0];

		$pgAdmin->setPage('profile', array(
			'id'			=> $user['id'],
			'nome' 			=> $user['nome'],
			'usuario'		=> $user['usuario'],
			'departamento'	=> $user['departamento'],
			'gestor'		=> (($user['gestor']) ? "Sim" : "Não"),
			'avatar'		=> $user['avatar']
		));
	});

	$app->run();

?>