// Efecto de desvanecimiento gradual
window.addEventListener('DOMContentLoaded', () => {
    const welcomeText = document.querySelector('.welcome-text');
    
    // Elimina la animación después de completarse
    welcomeText.addEventListener('animationend', () => {
        welcomeText.style.animation = 'none';
    });
    
    // Opcional: Efecto parallax con movimiento de mouse
    document.addEventListener('mousemove', (e) => {
        const x = (window.innerWidth / 2 - e.pageX) / 30;
        const y = (window.innerHeight / 2 - e.pageY) / 30;
        welcomeText.style.transform = `translate(${x}px, ${y}px)`;
    });
});