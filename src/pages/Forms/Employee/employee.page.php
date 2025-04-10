<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Header/header.component.php';

	$employee_url = 'http://localhost/PurchaseSystem/src/pages/Forms/Employee/';

?>

<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Employees</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.js"></script>


		<link rel="stylesheet" href="employee.page.css">

	</head>

	<body>

		<?php

			$employees = @Employee::all([

				'conditions' => ['state = ?', true]

			]);

		?>

		<?=HeaderComponent(Employee::find_by_code([$_SESSION['employee_code']]))?>

		<div class="container mt-4">

			<div class="d-flex justify-content-between align-items-center mb-4">

				<h2>Employee Management</h2>

				<button class="btn btn-success" id="btnAdd">

					<i class="fas fa-plus-circle me-2"></i>Add New

				</button>

			</div>

			<div class="table-responsive">

				<table class="table table-striped table-hover" id="employeesTable">

					<thead class="table-dark">

						<tr>
							<th>Code</th>
							<th>Name</th>
							<th>Actions</th>

						</tr>

					</thead>

					<tbody>

						<?php foreach($employees as $emp): ?>

							<tr>

								<td><?= $emp->code ?></td>
								<td><?= User::find_by_dni([$emp->dni])->name ?></td>
								<td>
									<button class="btn btn-sm btn-warning btn-edit" data-id="<?= $emp->code ?>">

										<i class="fas fa-edit"></i>

									</button>

									<button class="btn btn-sm btn-danger btn-delete" data-id="<?= $emp->code ?>">

										<i class="fas fa-trash"></i>

									</button>

								</td>

							</tr>

						<?php endforeach; ?>

					</tbody>

				</table>

			</div>

		</div>

		<div class="modal fade" id="employeeModal" tabindex="-1">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<h5 class="modal-title" id="modalTitle">New Employee</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>

					</div>

					<form id="form" action="<?=$employee_url?>employee.controller.php" method="POST">

						<div class="modal-body">

							<input type="hidden" id="employeeId" name="id">

							<div class="mb-3">

								<label class="form-label">Code</label>
								<input type="text" class="form-control" name="code">

							</div>

							<div class="mb-3">

								<label class="form-label">DNI</label>
								<input type="text" class="form-control" name="dni">

							</div>

							<div class="mb-3">

								<label class="form-label">Password</label>
								<input type="text" class="form-control" name="password">

							</div>

							<div class="mb-3">

								<input type="hidden" name="admin" value="false">
								<input type="checkbox" name = "admin" value = "true">
								<span class="input-check"></span>
								Admin

							</div>

						</div>

						<div class="modal-footer">

							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>

						</div>

					</form>

				</div>

			</div>

		</div>

		<script src="http://localhost/PurchaseSystem/src/common/request.interceptor.controller.js"></script>
		<script src="<?=$employee_url?>employee.page.js"></script>

	</body>

</html>