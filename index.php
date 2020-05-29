<?php

	require_once(__DIR__.'/vendor/autoload.php');
	require_once(__DIR__.'./function.php');

	use Slim\Slim;
	use App\Page;
	use App\PageAdmin;	
	use App\Sql;

	$app = new Slim();

	$app->group('/register', function() use ($app){		

		include(__DIR__.'\routes\user.php');

		$app->get('/category', function(){
			$page = new PageAdmin(array(
				'username' 	=> 'Robson Quedevez',
				'avatar'	=> '/../views/img/avatar/avatar.jpg'
			));

			$page->setPage('categoria');
		});

		include(__DIR__.'\routes\departament.php');
	});

	$app->group('/file', function() use ($app){

		$app->get('/include', function(){
			$pgAdmin = new PageAdmin(array(
				'username' 	=> 'Robson Quedevez',
				'avatar'	=> '/../views/img/avatar/avatar.jpg'
			));
			$pgAdmin->setPage('incluirArquivo');
		});

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

	$app->get('/home', function(){
		$pgAdmin = new PageAdmin(array(
				'username' 	=> 'Robson Quedevez',
				'avatar'	=> '/../views/img/avatar/avatar.jpg'
			));
		$pgAdmin->setPage('home');
	});

	$app->get('/logout', function(){
		$page = new Page();

		$page->setPage('login');
	});

	$app->get('/', function(){
		$page = new Page();

		$page->setPage('login');
	});

	$app->run();

?>