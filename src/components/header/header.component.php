<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';

	$header_url = 'http://localhost/PurchaseSystem/src/components/header/';

	$employee = null;
	$name = '';

	if (isset($_SESSION['employee_code'])){

		$employee = Employee::find([$_SESSION['employee_code']]);
		$name = User::find([$employee->dni])->name;

	}else{

		header('Location: http://localhost/PurchaseSystem/');

	}

?>

<link rel="stylesheet" href="<?= $header_url?>header.component.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


<div id ='header'>

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

				<a href="http://localhost/PurchaseSystem/" class="btn btn-outline-light btn-sm ms-3">

					<i class="fas fa-sign-out-alt"></i>

				</a>

			</div>

		</div>

		<nav id="sidebar" class="bg-light sidebar">

			<div class="position-sticky pt-3">

				<div class="sidebar-header d-flex justify-content-end p-3">

					<button class="btn btn-close" id="closeSidebar"></button>

				</div>

				<?php

					if ($employee->admin=='t'){

						echo '

				<h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">

					<i class="fas fa-cogs me-2"></i>Administration

				</h6>
	
				<ul class="nav flex-column">

					<li class="nav-item">

						<a class="nav-link active" href="http://localhost/PurchaseSystem/src/pages/Forms/Employee/employee.page.php">

							<i class="fas fa-users-cog me-2"></i>Employees

						</a>

					</li>

					<li class="nav-item">

						<a class="nav-link" href="/PurchaseSystem/src/views/clientes.php">

							<i class="fas fa-users me-2"></i>Clients (CRUD)

						</a>

					</li>

				</ul>

						';

					}

				?>

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

	</header>

	<script src="<?= $header_url?>header.component.js"></script>

</div>
