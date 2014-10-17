<?php

require 'Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login = $_POST['login'];
	$password = hash('sha512', $_POST['password']);

	$pdo = new Database();
	$user = $pdo->get_user($login, $password);
	if ($user) {
		session_start();
		$_SESSION['user'] = $user['id'];
		if ($user['is_admin']) {
			$_SESSION['user_type'] = 'admin';
			header('Location: ./admin.php');
		} else {
			unset($_SESSION['user_type']);
			header('Location: ./user.php');
		}
		die();
	} else {
		echo 'Incorrect login information!';
	}
}

require 'views/index.tmpl.php';