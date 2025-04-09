<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';

class AuthController{

	private ?Employee $employee;
	private ?string $password;

	public function __construct(array $POST){

		try{

			if (count($POST)!=2){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('employee_code', $POST)){

				throw new Exception('Code field missing.');

			}

			if (!array_key_exists('password', $POST)){

				throw new Exception('Password field missing.');

			}

			$employee_code = trim($POST['employee_code']);
			$password = trim($POST['password']);

			if (empty($employee_code)){

				throw new Exception('Code field cannot be empty.');

			}

			if (empty($password)){

				throw new Exception('Password field cannot be empty.');

			}

			$this->employee = Employee::find_by_code($employee_code, [

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

		return $this->password===$this->employee->password;

	}

	public function getEmployeeName(): string{

		return User::find([$this->employee->dni])->name;

	}

	public function getEmployeeCode(): string{

		return $this->employee->code;

	}

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	try{

		$auth = new AuthController($_POST);

		if (!$auth->verify()){

			throw new Exception('Wrong credentials.');

		}else{

			$_SESSION['employee_code'] = $auth->getEmployeeCode();

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'success',
				'message' => 'Welcome '. $auth->getEmployeeName(),
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