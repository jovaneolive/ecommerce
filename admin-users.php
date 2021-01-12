<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get("/admin/users", function () {

	User::verifyLogin();//verifica se a pessoa esta logada no sistema\

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));

});

$app->get("/admin/users/create", function () {

	User::verifyLogin();//verifica se a pessoa esta logada no sistema

	$page = new PageAdmin();

	$page->setTpl("users-create");

});

$app->get("/admin/users/:iduser/delete", function ($iduser) { //delete vem antes por causa do /delete que vem dps do iduser para nao confundir o slim framework. O update nao vai executar o delete

	 User::verifyLogin();

	 $user = new User();

	 $user->get((int)$iduser);

	 $user->delete();

	 header("Location: /admin/users");
	 exit();

});

$app->get("/admin/users/:iduser", function ($iduser) {

	User::verifyLogin();//verifica se a pessoa esta logada no sistema

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(

		"user"=>$user->getValues()

	));

});

$app->post("/admin/users/create", function () {

 	User::verifyLogin();

	$user = new User();

 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

 		"cost"=>12

 	]);

 	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");
 	exit;

});

$app->post("/admin/users/:iduser", function ($iduser) {

	 User::verifyLogin();

	 $user = new User();

	 $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	 $user->get((int)$iduser);

	 $user->setData($_POST);

	 $user->update();

	 header("Location: /admin/users");
	 exit;

});

?>