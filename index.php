<?php

	/*require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Item.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Buyout.php';

	$employee = Employee::find(['1110010001'], ['include' => ['purchases']]);
	$user = User::find([$employee->dni], ['include' => ['purchases']]);
	$item = Item::find_by_id(1);
	$buyout = @Buyout::find([1], ['include' => ['purchase', 'item']]);

	echo $buyout->purchase->code;/**/

	header('Location: https://localhost/PurchaseSystem/src/pages/Login/login.page.php');

?>