
function fetchTime() {

	let clock = document.getElementById('clock');

	if (clock!=null){

		clock.innerHTML = formatTime(new Date());

	}

}

function formatTime(date) {

	const hours = String(date.getHours()).padStart(2, '0');
	const minutes = String(date.getMinutes()).padStart(2, '0');
	const seconds = String(date.getSeconds()).padStart(2, '0');

	return `${hours}:${minutes}:${seconds}`;

}

setInterval(fetchTime, 1000);