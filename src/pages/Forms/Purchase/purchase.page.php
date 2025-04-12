<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Purchases</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Header/header.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Forms/Purchase/PurchaseRow/purchase_row.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/models/Purchase.php';

			$purchase_url = '/PurchaseSystem/src/pages/Forms/Purchase/';

		?>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.js"></script>


		<link rel="stylesheet" href="<?=$purchase_url?>purchase.page.css">

	</head>

	<body>

		<?=HeaderComponent(User::find_by_dni([$_SESSION['user_dni']]))?>

		<div class="container mt-4">

			<div class="d-flex justify-content-between align-items-center mb-4">

				<h2>Purchase Management</h2>

				<button class="btn btn-success" id="btnAdd">

					<i class="fas fa-plus-circle me-2"></i>Add New

				</button>

			</div>

			<div class="table-responsive">

				<table class="table table-striped table-hover" id="PurchasesTable">

					<thead class="table-dark">

						<tr>

							<th>ID</th>
							<th>Total</th>
							<th>Date</th>
							<th>Details</th>
							<th>User</th>
							<th>State</th>
							<th>Action</th>

						</tr>

					</thead>

					<tbody>

						<?php

							$purchases = @Purchase::all();

						?>

						<?php foreach($purchases as $purchase): ?>

							<?=PurchaseRow($purchase)?>

						<?php endforeach; ?>

					</tbody>

				</table>

			</div>

		</div>

		<div class="modal fade" id="PurchaseModal" tabindex="-1"></div>

		<script src="<?=$purchase_url?>purchase.page.js"></script>

	</body>

</html>