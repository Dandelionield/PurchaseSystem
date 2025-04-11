<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Employees</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Header/header.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/components/Forms/Employee/EmployeeRow/employee_row.component.php';

			$employee_url = 'http://localhost/PurchaseSystem/src/pages/Forms/Employee/';

		?>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.js"></script>


		<link rel="stylesheet" href="<?=$employee_url?>employee.page.css">

	</head>

	<body>

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
							<th>Admin</th>
							<th>State</th>
							<th>Actions</th>

						</tr>

					</thead>

					<tbody>

						<?php

							$employees = @Employee::all();

						?>

						<?php foreach($employees as $emp): ?>

							<?=EmployeeRow($emp)?>

						<?php endforeach; ?>

					</tbody>

				</table>

			</div>

		</div>

		<div class="modal fade" id="employeeModal" tabindex="-1"></div>

		<script src="<?=$employee_url?>employee.page.js"></script>

	</body>

</html>