<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Purchase.php';
	$purchase_row_url = '/PurchaseSystem/src/components/Forms/Purchase/PurchaseRow/';

?>

<link rel="stylesheet" href="<?=$purchase_row_url?>purchase_row.component.css">
<script src="<?=$purchase_row_url?>purchase_row.component.js"></script>

<?php

function PurchaseRow(Purchase $purchase): string{

	ob_start();

?>

	<tr>

		<td><?= $purchase->id ?></td>
		<td><?= $purchase->total ?></td>
		<td><?= $purchase->purchase_date ?></td>
		<td><?= $purchase->details ?></td>
		<td><?= $purchase->user ?></td>
		<td><input type="checkbox" disabled <?=$purchase->state ? 'checked' : ''?> id="<?= $purchase->id ?>"></td>
		<td>

			<button class="btn btn-sm btn-warning btn-edit" onclick="showForm('<?= $purchase->id ?>')">

				<i class="fas fa-edit"></i>

			</button>

			<button class="btn btn-sm btn-danger btn-delete" onclick="toggle('<?= $purchase->id ?>', '<?= !$purchase->state ?>')">

				<i class="fas fa-trash"></i>

			</button>

		</td>

	</tr>

<?php

	return ob_get_clean();

}

?>