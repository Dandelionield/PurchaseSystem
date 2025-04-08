<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';

	$employee = null;
	$name = '';

	if (isset($_SESSION['employee_code'])){
		$employee = Employee::find([$_SESSION['employee_code']]);
		$name = User::find([$employee->dni])->name;
	}else{
		header('Location: https://localhost/PurchaseSystem/');
	}

?>

<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Purchase System</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<link rel="stylesheet" href="header.component.css">

	</head>

	<body>

		<header class="navbar navbar-dark bg-dark shadow-sm">

			<div class="container-fluid">

				<button class="sidebar-collapse-btn" id="sidebarToggle">
					<i class="fas fa-bars"></i>
				</button>
				
				<a class="navbar-brand" href="#">
					Purchase System
				</a>
				
				<div class="d-flex align-items-center text-light">

					<i class="fas fa-user-circle me-2"></i>
					<?= $employee!=null ? $name : 'User' ?>

					<a href="/PurchaseSystem/logout.php" class="btn btn-outline-light btn-sm ms-3">

						<i class="fas fa-sign-out-alt"></i>

					</a>

				</div>

			</div>

		</header>

		<!-- Sidebar -->
		<nav id="sidebar" class="bg-light sidebar">

			<div class="position-sticky pt-3">

				<div class="sidebar-header d-flex justify-content-end p-3">

					<button class="btn btn-close" id="closeSidebar"></button>

				</div>

				<h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">

					<i class="fas fa-cogs me-2"></i>Administration

				</h6>
				
				<ul class="nav flex-column">

					<li class="nav-item">

						<a class="nav-link active" href="#">

							<i class="fas fa-users-cog me-2"></i>Employees

						</a>

					</li>

					<li class="nav-item">

						<a class="nav-link" href="/PurchaseSystem/src/views/clientes.php">

							<i class="fas fa-users me-2"></i>Clients (CRUD)

						</a>

					</li>

				</ul>

				<h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">

					<i class="fas fa-cash-register me-2"></i>Purchases

				</h6>
				
				<ul class="nav flex-column">

					<li class="nav-item">

						<a class="nav-link" href="#">

							<i class="fas fa-cart-plus me-2"></i>New Purchase

						</a>

					</li>

					<li class="nav-item">

						<a class="nav-link" href="#">

							<i class="fas fa-chart-bar me-2"></i>Reports

						</a>

					</li>

				</ul>

			</div>

		</nav>

		<script src="header.component.js"></script>

	</body>

</html>