<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';

	$employee = new Employee();

	$employee->code = '5550050005';
	$employee->dni = '5555555555';
	$employee->password = 'a123';
	$employee->admin = false;

	if ($employee->save()) {
		echo "Empleado creado (ID: {$employee->state})";
	} else {
		echo "Error: " . implode(", ", $employee->errors->full_messages());
	}

	//header('Location: http://localhost/PurchaseSystem/src/pages/Login/login.page.php');

?>