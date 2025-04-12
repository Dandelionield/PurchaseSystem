<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Purchase.php';

class PurchaseController{

	private ?Purchase $purchase;

	public function __construct(array $POST, bool $isPatch=false){

		try{

			if (count($POST)!=3){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('total', $POST)){

				throw new Exception('Total field missing.');

			}

			if (!array_key_exists('date', $POST)){

				throw new Exception('Date field missing.');

			}

			if (!array_key_exists('details', $POST)){

				throw new Exception('Details field missing.');

			}

			$total = trim($POST['total']);
			$date = trim($POST['date']);
			$details = trim($POST['details']);

			if (empty($total)){

				throw new Exception('Total cannot be empty.');

			}

			if (empty($date)){

				throw new Exception('Date cannot be empty.');

			}

			if (empty($details)){

				throw new Exception('Details cannot be empty.');

			}

			if (!ctype_digit($total) || $total<=0){

				throw new Exception("Total must be greater than zero.");

			}

			if (!$isPatch){

				$this->purchase = new Purchase();

			}else{

				$this->purchase = Purchase::find_by_id($_SESSION['updated_purchase']);
				$_SESSION['updated_Purchase'] = '';

			}

			$this->purchase->total = $total;
			$this->purchase->purchase_date = date($date);
			$this->purchase->details = $details;
			$this->purchase->user = $_SESSION['user_dni'];

		}catch(Exception $e){

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'error',
				'message' => $e->getMessage()

			]);

			exit();

		}

	}

	public function save(): bool{

		return $this->purchase->save();

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

		if (!isset($data['id'])){

			throw new Exception('ID paramether is missing.');

		}

		$purchase = Purchase::find_by_id($data['id']);

		if (!isset($purchase)){

			throw new Exception('Purchase with id '. $dni .' not found');

		}

		$state = $purchase->state = !$purchase->state;

		$purchase->save();

		$type = 'update';

	} else if ($_SERVER['REQUEST_METHOD']==='POST' && $_SESSION['REAL_METHOD']==='POST') {

		$empController = new PurchaseController($_POST);

		if (!$empController->save()){

			throw new Exception($empController->getErrors());

		}

		$type = 'insert';

	}else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['REAL_METHOD']==='PATCH'){

		$empController = new PurchaseController($_POST, true);

		if (!$empController->save()){

			throw new Exception($empController->getErrors());

		}

		$type = 'update';

	}

	header('Content-Type: application/json');

	echo json_encode([

		'type' => $type,
		'status' => 'success',
		'state' => $state,
		'message' => 'Purchase succesfully '. $type .'d',
		'url' => '/PurchaseSystem/src/pages/Forms/Purchase/Purchase.page.php'

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