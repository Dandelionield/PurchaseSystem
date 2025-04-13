<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/User.php';

$id = isset($_GET['dni']) ? $_GET['dni'] : null;

if ($id!=null){

	echo UserInsertForm(User::find_by_dni($id));
	$_SESSION['updated_user'] = $id;
	$_SESSION['REAL_METHOD'] = 'PATCH';

}else{

	$_SESSION['REAL_METHOD'] = 'POST';
	echo UserInsertForm(null);

}

function UserInsertForm(?User $user): string{

	$user_url = '/src/pages/Forms/User/';
	$user_form_url = '/src/components/Forms/User/UserForm/';

	ob_start();

?>

	<link rel="stylesheet" href="<?=$user_form_url?>user_form.component.css">
	<script src="<?=$user_form_url?>user_form.component.js"></script>

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="modalTitle"><?=$user==null ? 'New' : 'Update'?> User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>

			</div>

			<form id="form" action="<?=$user_url?>user.controller.php" method="POST">

				<div class="modal-body">

					<div class="mb-3">

						<label class="form-label">DNI</label>
						<input type="text" class="form-control" name="dni" value="<?=$user!=null ? $user->dni : ''?>">

					</div>

					<div class="mb-3">

						<label class="form-label">Name</label>
						<input type="text" class="form-control" name="name" value="<?=$user!=null ? $user->name : ''?>">

					</div>

					<div class="mb-3">

						<label class="form-label">Password</label>
						<input type="text" class="form-control" name="password" value="<?=$user!=null ? $user->password : ''?>">

					</div>

					<div class="mb-3">

						<label class="form-label">Email</label>
						<input type="text" class="form-control" name="email" value="<?=$user!=null ? $user->email : ''?>">

					</div>

					<div class="mb-3">

						<input type="hidden" name="admin" value="false">
						<input class="checkbox" type="checkbox" name = "admin" value = "true" <?=$user!=null ? (
	
							$user->admin==1 ? 'checked' : ''
	
						) : ''?>>
						<span class="input-check"></span>
						Admin

					</div>

					<div class="mb-3">

						<input type="hidden" name="login" value="false">
						<input class="checkbox" type="checkbox" name = "login" value = "true" <?=$user!=null ? (
	
							$user->login==1 ? 'checked' : ''
	
						) : ''?>>
						<span class="input-check"></span>
						Login

					</div>

				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Save</button>

				</div>

			</form>

		</div>

	</div>

<?php

	return ob_get_clean();

}

?>