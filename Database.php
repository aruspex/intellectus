<?php

include 'config.php';

class Database
{	
	private $server   = DB_SERVER;
	private $username = DB_USERNAME;
	private $password = DB_PASSWORD;
	private $database = DB_DATABASE;

	public $conn;

	public function __construct()
	{
		$dsn = 'mysql:host=' . $this->server . ';dbname=' . $this->database;
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
		);
		try {
			$this->conn = new PDO($dsn, $this->username, $this->password, $options);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}
	}

	public function get_all_users() {
		return $this->conn->query('SELECT * FROM users');
	}

	public function get_user($login, $password) {
		$stmt = $this->conn->prepare('SELECT * FROM users
			                          WHERE login=:login AND password=:password');
		$stmt->execute(array(
			'login'     => $login,
			'password' => $password
		));
		return $stmt->rowCount() == 1 ? $stmt->fetch() : false;

	}

	public function create_user($login, $password, $is_admin) {
		try {
			$stmt = $this->conn->prepare('INSERT INTO users (login, password, is_admin)
				                          VALUES (:login, :password, :is_admin)');
			return $stmt->execute(array(
				'login'     => $login,
				'password' => $password,
				'is_admin' => $is_admin
			));
		} catch (Exception $e) {
			return false;
		}
	}


	public function update_user($id, $params) {
		$user = $this->conn->query('SELECT * FROM users WHERE id=' . $id)->fetch();
		// string of type param=:value param2=:value for prepare function
		$set_str = '';
		foreach ($params as $param => $value) {
			if ($user[$param] != $value) {
				$set_str .= $param . '=:' . $param . ',';
			} else {
				unset($params[$param]);
			}
		}
		if ($set_str) {
			// some fields were changed
			$stmt = $this->conn->prepare('UPDATE users SET ' . trim($set_str, ',') . ' WHERE id = :id');
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			var_dump($params);
			echo '                ' . trim($set_str, ',');
			var_dump($stmt);
			foreach ($params as $param => $value) {
				echo 'Param: ' . $param . '   ' . $value;
				$stmt->bindValue(':' . $param, $value);
			}
			return $stmt->execute();
		}
		return false;
	}

	public function delete_user($id) {
		$stmt = $this->conn->prepare('DELETE FROM users WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		return $stmt->execute();
	}

}