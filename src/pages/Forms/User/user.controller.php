<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/User.php';

class UserController{

	private ?User $user;

	public function __construct(array $POST, bool $isPatch=false){

		try{

			if (count($POST)!=6){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('dni', $POST)){

				throw new Exception('DNI field missing.');

			}

			if (!array_key_exists('name', $POST)){

				throw new Exception('Name field missing.');

			}

			if (!array_key_exists('email', $POST)){

				throw new Exception('Email field missing.');

			}

			if (!array_key_exists('password', $POST)){

				throw new Exception('Password field missing.');

			}

			if (!array_key_exists('admin', $POST)){

				throw new Exception('Admin field is missing.');

			}

			if (!array_key_exists('login', $POST)){

				throw new Exception('Login field is missing.');

			}

			$dni = trim($POST['dni']);
			$name = trim($POST['name']);
			$email = trim($POST['email']);
			$password = trim($POST['password']);
			$adminBackup = strtolower(trim($POST['admin']));
			$loginBackup = strtolower(trim($POST['login']));

			if (empty($dni)){

				throw new Exception('DNI cannot be empty.');

			}

			if (empty($name)){

				throw new Exception('Name cannot be empty.');

			}

			if (empty($email)){

				throw new Exception('Email cannot be empty.');

			}

			if (empty($password)){

				throw new Exception('DNI cannot be empty.');

			}

			if (empty($adminBackup)){

				throw new Exception('Admin cannot be empty.');

			}

			if (empty($loginBackup)){

				throw new Exception('Login cannot be empty.');

			}

			if (!ctype_digit($dni) || strlen($dni)!=10){

				throw new Exception("DNI's length must be 10  and apositive integer.");

			}

			$isTrue = $adminBackup==='true';
			$isFalse = $adminBackup==='false';

			if (!$isTrue && !$isFalse){

				throw new Exception('Admin field values are incorrect');

			}

			$admin = $isTrue ? 1 : 0;

			$isTrue = $loginBackup==='true';
			$isFalse = $loginBackup==='false';

			if (!$isTrue && !$isFalse){

				throw new Exception('Login field values are incorrect');

			}

			$login = $isTrue ? 1 : 0;

			if (!$isPatch){

				$this->user = new User();

			}else{

				$this->user = User::find_by_dni($_SESSION['updated_user']);
				$_SESSION['updated_user'] = '';

			}

			$this->user->dni = $dni;
			$this->user->name = $name;
			$this->user->email = $email;
			$this->user->password = $password;
			$this->user->admin = $admin;
			$this->user->login = $login;

		}catch(Exception $e){

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'error',
				'message' => $e->getMessage()

			]);

			exit();

		}

	}

	public function insert(): bool{

		if (User::exists($this->user->dni)){

			throw new Exception('User already exist.');

		}

		return $this->user->save();

	}

	public function update(): bool{

		return $this->user->save();

	}

	public function getErrors(): string{

		$errors = "";

		foreach($this->purchase->errors->full_messages() as $e){

			$errors = $errors .", ". $e;

		}

		return $errors;

	}

}

try{

	$type = '';
	$state = true;

	if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){

		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		if (!isset($data['dni'])){

			throw new Exception('DNI paramether is missing.');

		}

		$user = User::find_by_dni($data['dni']);

		if (!isset($user)){

			throw new Exception('User with dni '. $dni .' not found');

		}

		$state = $user->state = !$user->state;

		$user->save();

		$type = 'update';

	} else if ($_SERVER['REQUEST_METHOD']==='POST' && $_SESSION['REAL_METHOD']==='POST') {

		$empController = new UserController($_POST);

		if (!$empController->insert()){

			throw new Exception($empController->getErrors());

		}

		$type = 'insert';

	}else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['REAL_METHOD']==='PATCH'){

		$empController = new UserController($_POST, true);

		if (!$empController->update()){

			throw new Exception($empController->getErrors());

		}

		$type = 'update';

	}

	header('Content-Type: application/json');

	echo json_encode([

		'type' => $type,
		'status' => 'success',
		'state' => $state,
		'message' => 'User succesfully '. $type .'d',
		'url' => '/src/pages/Forms/User/User.page.php'

	]);

	exit();

}catch(Exception $e){

	header('Content-Type: application/json');

	echo json_encode([

		'status' => 'error',
		'message' => $e->getMessage()

	]);

	exit();

}

?>