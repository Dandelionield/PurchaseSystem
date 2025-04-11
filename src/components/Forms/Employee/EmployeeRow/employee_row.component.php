<?php

	$employee_row_url = 'http://localhost/PurchaseSystem/src/components/Forms/Employee/EmployeeRow/';

?>

<link rel="stylesheet" href="<?=$employee_row_url?>employee_row.component.css">
<script src="<?=$employee_row_url?>employee_row.component.js"></script>

<?php

function EmployeeRow(Employee $employee): string{

	ob_start();

?>

	<tr>

		<td><?= $employee->code ?></td>
		<td><?= User::find_by_dni([$employee->dni])->name ?></td>
		<td><input type="checkbox" disabled <?=$employee->admin ? 'checked' : ''?>></td>
		<td><input type="checkbox" disabled <?=$employee->state ? 'checked' : ''?> id="<?= $employee->code ?>"></td>
		<td>

			<button class="btn btn-sm btn-warning btn-edit" onclick="showForm('<?= $employee->code ?>')">

				<i class="fas fa-edit"></i>

			</button>

			<button class="btn btn-sm btn-danger btn-delete" onclick="toggle('<?= $employee->code ?>', '<?= !$employee->state ?>')">

				<i class="fas fa-trash"></i>

			</button>

		</td>

	</tr>

<?php

	return ob_get_clean();

}

?>