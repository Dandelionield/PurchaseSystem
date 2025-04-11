
document.addEventListener('DOMContentLoaded', () => {

	document.getElementById('btnAdd').addEventListener('click', () => {

		showForm(null);

	});

});

function showForm(dni){

    fetch("http://localhost/PurchaseSystem/src/components/Forms/User/UserForm/user_form.component.php" + (dni!=null ? "?dni="+dni : "")).then(
	
		response => response.text()
	
	).then(data => {

        document.getElementById('UserModal').innerHTML = data;
		
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

		const modal = new bootstrap.Modal('#UserModal');
		document.getElementById('form').reset();
		modal.show();

    }).catch(error => 
	
		console.error('Error al cargar la información del item:', error)
		
	);

}