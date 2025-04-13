
document.getElementById('captureBtn').addEventListener('click', async () => {

	fetch('/src/pages/Clock/clock.controller.php', {

		method: 'POST'

	}).then(response =>{

		//console.log(response.text());
		return response.json();

	}).then(data =>{

		if (data.success) {

			const tbody = document.getElementById('timers');
			const newRow = document.createElement('tr');
			newRow.className = 'clock-row';
			newRow.innerHTML = `<td>${data.time}</td>`;
			tbody.insertBefore(newRow, tbody.firstChild);

		}

	}).catch(e =>{

		console.log(e);

	});

});