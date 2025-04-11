<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';

class AuthController{

	private ?User $user;
	private ?string $password;

	public function __construct(array $POST){

		try{

			if (count($POST)!=2){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('email', $POST)){

				throw new Exception('Email field missing.');

			}

			if (!array_key_exists('password', $POST)){

				throw new Exception('Password field missing.');

			}

			$email = trim($POST['email']);
			$password = trim($POST['password']);

			if (empty($email)){

				throw new Exception('Code field cannot be empty.');

			}

			if (empty($password)){

				throw new Exception('Password field cannot be empty.');

			}

			$this->user = User::find_by_email([$email], [

				'conditions' => ['state = ?', true]

			]);

			$this->password = $password;

		}catch(Exception $e){

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'error',
				'message' => $e->getMessage()

			]);

			exit();

		}

	}

	public function verify(): bool{

		return isset($this->user) ? $this->password===$this->user->password : false;

	}

	public function getUserName(): string{

		return $this->user->name;

	}

	public function getUserDNI(): string{

		return $this->user->dni;

	}

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	try{

		$auth = new AuthController($_POST);

		if (!$auth->verify()){

			throw new Exception('Wrong credentials.');

		}else{

			$name = $auth->getUserName();

			$_SESSION['user_dni'] = $auth->getUserDNI();

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'success',
				'message' => 'Welcome '. $name,
				'url' => 'http://localhost/PurchaseSystem/src/pages/Home/home.page.php'

			]);

			exit();

		}

	}catch(Exception $e){

		header('Content-Type: application/json');

		echo json_encode([

			'status' => 'error',
			'message' => $e->getMessage()

		]);

		exit();

	}

}

?>