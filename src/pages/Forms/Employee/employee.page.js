document.addEventListener('DOMContentLoaded', () => {

	const modal = new bootstrap.Modal('#employeeModal');
	const form = document.getElementById('employeeForm');
	
	// Add New Button Handler
	document.getElementById('btnAdd').addEventListener('click', () => {

		form.reset();
		document.getElementById('modalTitle').textContent = 'New Employee';
		modal.show();

	});

});