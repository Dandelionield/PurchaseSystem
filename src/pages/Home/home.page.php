<?php

	session_start();

?><!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home - Purchase System</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/src/components/Header/header.component.php';

			$home_url = '/src/pages/Home/';

		?>

		<link href="<?= $home_url ?>home.page.css" rel="stylesheet">

	</head>

	<body>

		<?=HeaderComponent(User::find_by_dni($_SESSION['user_dni']))?>

		<div class="welcome-container">

			<h1 class="welcome-text">Welcome<br><span><?=$user->name?></span></h1>

		</div>

		<script src="<?= $home_url ?>home.page.js"></script>

	</body>

</html>