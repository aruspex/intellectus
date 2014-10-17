<?php

require 'Database.php';

session_start();

//insufficient privileges to view this page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
	header('Location: ./index.php');
	die();
}

$error = '';
$pdo = new Database();
$users = $pdo->get_all_users();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['delete'])) {
		// user deletion
		$id = $_POST['id'];
		$pdo->delete_user($id);
	} else {
		$login = $_POST['login'];
		$password = $_POST['password'];
		$is_admin = isset($_POST['is_admin']);
		if (isset($_POST['id'])) {
			// user edition
			$id = $_POST['id'];
			$edit_params = array(
				'login'    => $login,
				'is_admin' => $is_admin
			);
			// if something was enetered in password field
			if ($password) {
				$edit_params['password'] = hash('sha512', $password);
			}
			$pdo->update_user($id, $edit_params);
		} else {
			// user creation
			$password = hash('sha512', $password);
			$created = $pdo->create_user($login, $password, $is_admin);
			if (! $created) {
				$error = 'User with this login already exists!';
			}
		}
	}
	// header('Refresh:0');
	// die();
}

require 'views/admin.tmpl.php';