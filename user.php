<?php

session_start();

if (isset($_SESSION['user'])) {
	require 'views/user.tmpl.php';
} else {
	header('Location: ./index.php');
}
