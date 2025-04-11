
async function warning(b){

	const shot = await Swal.fire({

        title: 'Are you sure you want to '+(b ? 'activate' : 'deactivate')+'?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: b ? 'Activate' : 'Deactivate',
        cancelButtonText: 'Cancel',
        reverseButtons: true

    });

    if (shot.isConfirmed){
	
		return true;

    }else{// if (shot.isDismissed){

        Swal.fire('Cancelled', 'Action has been cancelled', 'info');
	
		return false;

    }

}

async function toggle(id, state){

	const b = await warning(state);

	if (b){

		fetch("http://localhost/PurchaseSystem/src/pages/Forms/Purchase/Purchase.controller.php",{

			method: 'DELETE',
			headers: {

				'Content-Type': 'application/json'

			}, body: JSON.stringify({

				id: id

			})

		}).then(

			response => response.json()

		).then(data => {

			if (data.status=='success'){

				Swal.fire(data.state ? 'Activated' : 'Deactivated', 'Employee has been successfully '+(data.state ? 'activated' : 'deactivated')+'.', 'success');

				const Checkbox = document.getElementById(id);
				Checkbox.checked = data.state;

			}else{

				formWarning(data);

			}

		}).catch(e => {

			console.error('Error al cargar la información del item:', e);
			
		});

	}

}