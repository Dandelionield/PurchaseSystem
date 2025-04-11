<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities/Employee.php';

$id = isset($_GET['code']) ? $_GET['code'] : null;

if ($id!=null){

	echo EmployeeInsertForm(Employee::find_by_code($_GET['code']));
	$_SESSION['updated_employee'] = $_GET['code'];
	$_SESSION['REAL_METHOD'] = 'PATCH';

}else{

	$_SESSION['REAL_METHOD'] = 'POST';
	echo EmployeeInsertForm(null);

}

function EmployeeInsertForm(?Employee $employee): string{

	$employee_url = 'http://localhost/PurchaseSystem/src/pages/Forms/Employee/';

	ob_start();

?>

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="modalTitle">New Employee</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>

			</div>

			<form id="form" action="<?=$employee_url?>employee.controller.php" method="POST">

				<div class="modal-body">

					<input type="hidden" id="employeeId" name="id">

					<?php if ($employee==null): ?>

						<div class="mb-3">

							<label class="form-label">Code</label>
							<input type="text" class="form-control" name="code" value="<?=$employee!=null ? $employee->code : ''?>">

						</div>

					<?php endif; ?>

					<div class="mb-3">

						<label class="form-label">DNI</label>
						<input type="text" class="form-control" name="dni" value="<?=$employee!=null ? $employee->dni : ''?>">

					</div>

					<div class="mb-3">

						<label class="form-label">Password</label>
						<input type="text" class="form-control" name="password" value="<?=$employee!=null ? $employee->password : ''?>">

					</div>

					<div class="mb-3">

						<input type="hidden" name="admin" value="false">
						<input type="checkbox" name = "admin" value = "true" <?=$employee!=null ? (
	
							$employee->admin==1 ? 'checked' : ''
	
						) : ''?>>
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

<?php

	return ob_get_clean();

}

?>