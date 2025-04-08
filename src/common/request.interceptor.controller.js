
if (document.getElementById('form')!=null){

	document.getElementById('form').onsubmit = function(event){

		event.preventDefault();

		const formData = new FormData(this);

		fetch(document.getElementById('form').action, {

			method: 'POST',
			body: formData

		}).then(response =>{

			console.log(response);
			return response.json();

		}).then(data => {

			formWarning(data);

			if (data.status === 'error') {

				restore(formData);

			}else if (data.type==='insert'){

				clear(formData);

			}
			

		}).catch(e =>{

			console.log(e);

		});

	};

}

async function formWarning(data){

	let b = data.status==='error';
	let c = data.type==='insert';

	const shot = await Swal.fire({
	
		title: b ? 'Error' : 'Exito',
		text: data.message,
		icon: b ? 'error' : 'success',
		showCancelButton: !b ? c : b,
		showConfirmButton: !b,
		confirmButtonText: 'Listo', 
		cancelButtonText: b ? 'Cancel' : 'Listo', 
		reverseButtons: true, 
		allowOutsideClick: true

	});

	if (shot.isConfirmed){

        window.location.href = data.url;

    }

}

function restore(formData){

    formData.forEach((value, key) =>{
		
        const input = document.querySelector(`[name=${key}]`);

        if (input){
		
            input.value = value;

        }

    });

}

function clear(formData){

    formData.forEach((value, key) =>{
		
        const input = document.querySelector(`[name=${key}]`);

        if (input){
		
            input.value = '';

        }

    });

}