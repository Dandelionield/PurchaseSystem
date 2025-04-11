<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';

class EmployeeController{

	private ?Employee $employee;

	public function __construct(array $POST, bool $isPatch=false){

		try{

			if (count($POST)!=(5 - ($isPatch ? 1 : 0))){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('code', $POST) && !$isPatch){

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

			$code = trim(isset($POST['code']) ? $POST['code'] : '');
			$dni = trim($POST['dni']);
			$password = trim($POST['password']);
			$adminBackup = strtolower(trim($POST['admin']));

			if (empty($code) && !$isPatch){

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

			if ((!ctype_digit($code) || strlen($code)!=10) && !$isPatch){

				throw new Exception("Code must be a length's 10 positive integer.");

			}

			$isTrue = $adminBackup==='true';
			$isFalse = $adminBackup==='false';

			if (!$isTrue && !$isFalse){

				throw new Exception('Admin field values are incorrect');

			}

			if (!$isPatch){

				$this->employee = new Employee();
				$this->employee->code = $code;

			}else{

				$this->employee = Employee::find_by_code($_SESSION['updated_employee']);
				$_SESSION['updated_employee'] = '';

			}

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

		if (Employee::exists($this->employee->code)){

			throw new Exception('Employee already exist.');

		}

		return $this->employee->save();

	}

	public function update(): bool{

		return $this->employee->save();

	}

	public function getErrors(): string{

		return $this->employee->errors->full_messages();

	}

}

try{

	$type = '';
	$state = true;

	if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){

		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		if (!isset($data['code'])){

			throw new Exception('Code paramether is missing.');

		}

		$employee = Employee::find_by_code($data['code']);

		if (!isset($employee)){

			throw new Exception('Employee with code '. $code .' not found');

		}

		$state = $employee->state = !$employee->state;

		$employee->save();

		$type = 'update';

	} else if ($_SERVER['REQUEST_METHOD']==='POST' && $_SESSION['REAL_METHOD']==='POST') {

		$empController = new EmployeeController($_POST);

		if (!$empController->insert()){

			throw new Exception($empController->getErrors());

		}

		$type = 'insert';

	}else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['REAL_METHOD']==='PATCH'){

		$empController = new EmployeeController($_POST, true);

		if (!$empController->update()){

			throw new Exception($empController->getErrors());

		}

		$type = 'update';

	}

	header('Content-Type: application/json');

	echo json_encode([

		'type' => $type . $_SERVER['REQUEST_METHOD'],
		'status' => 'success',
		'state' => $state,
		'message' => 'Employee succesfully '. $type .'d',
		'url' => 'http://localhost/PurchaseSystem/src/pages/Forms/Employee/employee.page.php'

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