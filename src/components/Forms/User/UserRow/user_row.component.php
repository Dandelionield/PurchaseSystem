<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/User.php';
	$user_row_url = 'http://localhost/PurchaseSystem/src/components/Forms/User/UserRow/';

?>

<link rel="stylesheet" href="<?=$user_row_url?>user_row.component.css">
<script src="<?=$user_row_url?>user_row.component.js"></script>

<?php

function UserRow(User $user): string{

	ob_start();

?>

	<tr>

		<td><?= $user->dni ?></td>
		<td><?= $user->name ?></td>
		<td><?= $user->email ?></td>
		<td><input type="checkbox" disabled <?=$user->admin ? 'checked' : ''?>></td>
		<td><input type="checkbox" disabled <?=$user->login ? 'checked' : ''?>></td>
		<td><input type="checkbox" disabled <?=$user->state ? 'checked' : ''?> id="<?= $user->dni ?>"></td>
		<td>

			<button class="btn btn-sm btn-warning btn-edit" onclick="showForm('<?= $user->dni ?>')">

				<i class="fas fa-edit"></i>

			</button>

			<button class="btn btn-sm btn-danger btn-delete" onclick="toggle('<?= $user->dni ?>', '<?= !$user->state ?>')">

				<i class="fas fa-trash"></i>

			</button>

		</td>

	</tr>

<?php

	return ob_get_clean();

}

?>