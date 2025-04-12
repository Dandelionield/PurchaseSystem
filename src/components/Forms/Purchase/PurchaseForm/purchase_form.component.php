<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/models/Purchase.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id!=null){

	echo PurchaseInsertForm(Purchase::find_by_id($id));
	$_SESSION['updated_purchase'] = $id;
	$_SESSION['REAL_METHOD'] = 'PATCH';

}else{

	$_SESSION['REAL_METHOD'] = 'POST';
	echo PurchaseInsertForm(null);

}

function PurchaseInsertForm(?Purchase $purchase): string{

	$purchase_url = '/PurchaseSystem/src/pages/Forms/Purchase/';
	$purchase_form_url = '/PurchaseSystem/src/components/Forms/Purchase/PurchaseForm/';

	ob_start();

?>

	<link rel="stylesheet" href="<?=$purchase_form_url?>purchase_form.component.css">
	<script src="<?=$purchase_form_url?>purchase_form.component.js"></script>

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="modalTitle"><?=$purchase==null ? 'New' : 'Update'?> Purchase</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>

			</div>

			<form id="form" action="<?=$purchase_url?>purchase.controller.php" method="POST">

				<div class="modal-body">

					<div class="mb-3">

						<label class="form-label">Total</label>
						<input type="text" class="form-control" name="total" value="<?=$purchase!=null ? $purchase->total : ''?>">

					</div>

					<div class="mb-3">

						<label class="form-label">Date</label>
						<input type="date" class="form-control" name="date" value="<?=$purchase!=null ? $purchase->purchase_date->format('Y-m-d') : ''?>">

					</div>

					<div class="mb-3">

						<label class="form-label">Details</label>
						<input type="text" class="form-control" name="details" value="<?=$purchase!=null ? $purchase->details : ''?>">

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