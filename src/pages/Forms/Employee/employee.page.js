
document.addEventListener('DOMContentLoaded', () => {

	document.getElementById('btnAdd').addEventListener('click', () => {

		showForm(null);

	});

});

function showForm(code){

    fetch("http://localhost/PurchaseSystem/src/components/Forms/Employee/EmployeeInsert/employee_insert.component.php" + (code!=null ? "?code="+code : "")).then(
	
		response => response.text()
	
	).then(data => {
		
        document.getElementById('employeeModal').innerHTML = data;
		
		let script = document.getElementById('controller');
		
		if (script!=null){

			script.remove();

		}

		script = document.createElement('script');
		script.id = 'controller';
		script.type = 'text/javascript';
		script.src = 'http://localhost/PurchaseSystem/src/common/request.interceptor.controller.js';
		script.async = true;

		document.body.appendChild(script);

		const modal = new bootstrap.Modal('#employeeModal');
		document.getElementById('form').reset();
		document.getElementById('modalTitle').textContent = 'New Employee';
		modal.show();

    }).catch(error => 
	
		console.error('Error al cargar la información del item:', error)
		
	);

}