<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home - Purchase System</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Header/header.component.php';

			$home_url = '/PurchaseSystem/src/pages/Home/';

		?>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $home_url ?>home.page.css" rel="stylesheet">

	</head>

	<body>

		<?php

			$user = User::find_by_dni($_SESSION['user_dni']);

		?>

		<?=HeaderComponent($user)?>

		<div class="welcome-container">

			<h1 class="welcome-text">Welcome<br><span><?=$user->name?></span></h1>

		</div>

		<script src="<?= $home_url ?>home.page.js"></script>

	</body>

</html>