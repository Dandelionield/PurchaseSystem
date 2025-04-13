<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/User.php';

	if (!isset($_SESSION['user_dni'])){

		header('Location: /var/www/');
		exit();

	}

	$header_url = '/src/components/Header/';

?>

<link rel="stylesheet" href="<?= $header_url?>header.component.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<?php

function HeaderComponent(?User $user): string{

	$header_url = '/src/components/header/';

	ob_start();

?>

	<div id ='header'>

		<header class="navbar navbar-dark bg-dark shadow-sm">

			<div class="container-fluid">

				<button class="sidebar-collapse-btn" id="sidebarToggle">

					<i class="fas fa-bars"></i>

				</button>

				<a class="navbar-brand" href="/src/Pages/Home/home.page.php">
					Purchase System
				</a>

				<div class="d-flex align-items-center text-light">

					<i class="fas fa-user-circle me-2"></i>
					<?= $user!=null ? $user->name : 'User' ?>

					<a href="/var/www/" class="btn btn-outline-light btn-sm ms-3">

						<i class="fas fa-sign-out-alt"></i>

					</a>

				</div>

			</div>

			<nav id="sidebar" class="bg-light sidebar">

				<div class="position-sticky pt-3">

					<div class="sidebar-header d-flex justify-content-end p-3">

						<button class="btn btn-close" id="closeSidebar"></button>

					</div>

					<?php if ($user->admin == 1): ?>

						<h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">

							<i class="fas fa-cogs me-2"></i>Administration

						</h6>

						<ul class="nav flex-column">

							<li class="nav-item">

								<a class="nav-link active" href="/src/pages/Forms/User/User.page.php">

									<i class="fas fa-users-cog me-2"></i>Users

								</a>

							</li>

						</ul>

					<?php endif; ?>

					<h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">

						<i class="fas fa-cash-register me-2"></i>Purchases

					</h6>
		
					<ul class="nav flex-column">

						<li class="nav-item">

							<a class="nav-link" href="/src/pages/Forms/Purchase/purchase.page.php">

								<i class="fas fa-cart-plus me-2"></i>New Purchase

							</a>

						</li>

					</ul>

					<h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">

						<i class="fas fa-solid fa-clock-rotate-left me-2"></i>Time

					</h6>
		
					<ul class="nav flex-column">

						<li class="nav-item">

							<a class="nav-link" href="/src/pages/Clock/clock.page.php">

								<i class="fas fa-solid fa-clock me-2"></i>Digital Clock

							</a>

						</li>

					</ul>

				</div>

			</nav>

		</header>

		<script src="<?= $header_url?>header.component.js"></script>

	</div>

<?php

	return ob_get_clean();

}

?>