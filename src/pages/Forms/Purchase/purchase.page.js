
document.addEventListener('DOMContentLoaded', () => {

	document.getElementById('btnAdd').addEventListener('click', () => {

		showForm(null);

	});

});

function showForm(id){

    fetch("/PurchaseSystem/src/components/Forms/Purchase/PurchaseForm/purchase_form.component.php" + (id!=null ? "?id="+id : "")).then(
	
		response => response.text()
	
	).then(data => {

        document.getElementById('PurchaseModal').innerHTML = data;
		
		let script = document.getElementById('controller');
		
		if (script!=null){

			script.remove();

		}

		script = document.createElement('script');
		script.id = 'controller';
		script.type = 'text/javascript';
		script.src = '/PurchaseSystem/src/common/request.interceptor.controller.js';
		script.async = true;

		document.body.appendChild(script);

		const modal = new bootstrap.Modal('#PurchaseModal');
		document.getElementById('form').reset();
		modal.show();

    }).catch(e =>
	
		console.error('Error loading the item: ', e)
		
	);

}