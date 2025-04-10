<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Header/header.component.php';

	$home_url = 'http://localhost/PurchaseSystem/src/pages/Home/';

?>

<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home - Purchase System</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $home_url ?>home.page.css" rel="stylesheet">

	</head>

	<body>

		<?=HeaderComponent(Employee::find_by_code([$_SESSION['employee_code']]))?>

		<div class="welcome-container">

			<h1 class="welcome-text">Welcome<br><span><?= $_SESSION['employee_name'] ?></span></h1>

		</div>

		<script src="<?= $home_url ?>home.page.js"></script>

	</body>

</html>