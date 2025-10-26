// Menu burger
function toggleMenu() {
    const menu = document.querySelector('.nav-menu');
    const burger = document.querySelector('.burger');
    const overlay = document.querySelector('.menu-overlay');
    
    menu.classList.toggle('active');
    burger.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.classList.toggle('menu-open');
}

// Fermer le menu en cliquant sur l'overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.querySelector('.menu-overlay');
    if (overlay) {
        overlay.addEventListener('click', toggleMenu);
    }
});

// Rendre la fonction accessible globalement
window.toggleMenu = toggleMenu;