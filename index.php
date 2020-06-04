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
				'username' 	=> "Robson",
				'avatar'	=> '/../views/img/avatar/avatar.jpg'
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

		$app->get('/private', function(){
			$page = new PageAdmin(array(
				'username' 	=> 'Robson Quedevez',
				'avatar'	=> '/../views/img/avatar/avatar.jpg'
			));

			$page->setPage('arquivosPrivados');
		});

		$app->get('/public', function(){
			$pgAdmin = new PageAdmin(array(
				'username' 	=> 'Robson Quedevez',
				'avatar'	=> '/../views/img/avatar/avatar.jpg'
			));
			$pgAdmin->setPage('arquivosPublicos');
		});
	});

	$app->get('/access', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> 'Robson Quedevez',
			'avatar'	=> '/../views/img/avatar/avatar.jpg'
		));
		$pgAdmin->setPage('acessos');
	});

	$app->get('/profile', function(){
		$pgAdmin = new PageAdmin(array(
			'username' 	=> 'Robson Quedevez',
			'avatar'	=> '/../views/img/avatar/avatar.jpg'
		));
		$pgAdmin->setPage('profile');
	});

	$app->run();

?>