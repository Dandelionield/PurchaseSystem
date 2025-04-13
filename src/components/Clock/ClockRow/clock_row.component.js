
document.querySelectorAll('.clock-row').forEach(row => {

	row.addEventListener('mouseenter', function() {

		this.style.textShadow = '0 0 8px rgba(0, 255, 136, 0.5)';

	});
	
	row.addEventListener('mouseleave', function() {

		this.style.textShadow = 'none';

	});

});