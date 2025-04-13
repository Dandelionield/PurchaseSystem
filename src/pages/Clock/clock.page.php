<?php

	session_start();

?><!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Digital Clock</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/src/components/Header/header.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/src/components/Clock/clock.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/src/components/Clock/ClockRow/clock_row.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/Clock.php';

			$clock_url = '/src/pages/Clock/';

		?>

		<link href="<?=$clock_url?>clock.page.css" rel="stylesheet">

	</head>

	<body class="bg-light">

		<?=HeaderComponent(User::find_by_dni($_SESSION['user_dni']))?>

		<?=ClockComponent()?>

		<button class="capture-btn" id="captureBtn">CAPTURE</button>

		<div class="main-content">
		
			<div class="table-container">

				<table class="table-transparent">

					<thead>

						<tr>

							<th></th>

						</tr>

					</thead>

					<tbody id="timers">

						<?php

							$clocks = @Clock::all(['order' => 'clock_date DESC']);

						?>

						<?php foreach($clocks as $clock): ?>

							<?=ClockRow($clock)?>

						<?php endforeach; ?>

					</tbody>

				</table>

			</div>

		</div>

		<script src="<?=$clock_url?>clock.page.js"></script>

	</body>

</html>