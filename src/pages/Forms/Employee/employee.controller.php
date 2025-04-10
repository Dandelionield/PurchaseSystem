<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';

class EmployeeController{

	private ?Employee $employee;

	public function __construct(array $POST){

		try{

			if (count($POST)!=5){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('code', $POST)){

				throw new Exception('Code field missing.');

			}

			if (!array_key_exists('dni', $POST)){

				throw new Exception('DNI field missing.');

			}

			if (!array_key_exists('password', $POST)){

				throw new Exception('Password field missing.');

			}

			if (!array_key_exists('admin', $POST)){

				throw new Exception('Admin field is missing.');

			}

			$code = trim($POST['code']);
			$dni = trim($POST['dni']);
			$password = trim($POST['password']);
			$adminBackup = strtolower(trim($POST['admin']));

			if (empty($code)){

				throw new Exception('DNI cannot be empty.');

			}

			if (empty($dni)){

				throw new Exception('DNI cannot be empty.');

			}

			if (empty($password)){

				throw new Exception('DNI cannot be empty.');

			}

			if (empty($adminBackup)){

				throw new Exception('Admin cannot be empty.');

			}

			if (!ctype_digit($code) || strlen($code)!=10){

				throw new Exception("Code must be a length's 10 positive integer.");

			}

			$isTrue = $adminBackup==='true';
			$isFalse = $adminBackup==='false';

			if (!$isTrue && !$isFalse){

				throw new Exception('Admin field values are incorrect');

			}

			$this->employee = new Employee();

			$this->employee->code = $code;
			$this->employee->dni = $dni;
			$this->employee->password = $password;
			$this->employee->admin = $isTrue;

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

		return $this->employee->save();

	}

	public function getErrors(): string{

		return $this->employee->errors->full_messages();

	}

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	try{

		$empController = new EmployeeController($_POST);

		if (!$empController->insert()){

			throw new Exception($empController->getErrors());

		}else{

			header('Content-Type: application/json');

			echo json_encode([

				'type' => 'insert',
				'status' => 'success',
				'message' => 'Employee succesfully created',
				'url' => 'http://localhost/PurchaseSystem/src/pages/Forms/Employee/employee.page.php'

			]);

			exit();

		}/**/

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